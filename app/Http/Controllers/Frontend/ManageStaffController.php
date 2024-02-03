<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use App\Rules\NumericMaxLengthRule;
use Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\{
    User,
    StaffCompany,
    StaffRole,
    Company,
    UserActivity,
    UserRole,
};
class ManageStaffController extends Controller
{
    public function checkUserType()
    {
        $companyAdminRole = UserRole::where('role','Company Admin')->first();
        if(Auth::guard('web')->user()->user_role_id != $companyAdminRole->id)
        {
            return false;
        }
        return true;
    }
    public function index(Request $request)
    {
        $userModel = Auth::guard('web')->user();
        $id = $userModel->id;
        $company_id = '';
        $companyAdminRoleID = UserRole::where('role','Company Admin')->first();
        $staffID = UserRole::whereNot('role','Company Admin')->where('type','Frontend')->pluck('id')->toArray();
        if(Auth::guard('web')->user()->user_role_id == $companyAdminRoleID->id){
            $companyInfo = Company::select('id')->where('user_id', $id)->first();
            $company_id = $companyInfo->id;
        }else if(in_array(Auth::guard('web')->user()->user_role_id, $staffID)){
            $companyInfo = StaffCompany::select('company_id')->where('user_id',Auth::guard('web')->user()->id)->first();
            $company_id = $companyInfo->company_id;
        }
        $staffrole = UserRole::whereNot('role','Company Admin')->where('type','Frontend')->whereNull('deleted_at')->orderBy('role','asc')->get()->toArray();
        if($request->ajax()){
            $obj1 = StaffCompany::with(['user','user.role'])->where('company_id',$company_id)->whereNull('staff_companies.deleted_at');   
            if(isset($request->status_filter)){
                $obj1->whereHas('user',function($query) use($request){
                    $query->where('status',$request->status_filter);
                });
            } else {
                $obj1;
            }
            return DataTables::of($obj1)->make(true);
        }
        return view('frontend.staff.list',compact('userModel', 'staffrole'));
    }
    /*
     ** create staff form
    */
    public function create(Request $request)
    {
        $staffrole = UserRole::whereNot('role','Company Admin')->where('type','Frontend')->whereNull('deleted_at')->orderBy('role','asc')->get()->toArray();
        $userModel = Auth::guard('web')->user();
        return view('frontend.staff.create',compact('userModel', 'staffrole'));
    }
    /*
     ** store sub admin 
    */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'name' => ['required', 'string'],
                // 'contact_number' => ['required'],
                // 'email' => ['required','string','email','max:255','unique:users'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->where(function ($query) {
                        $query->whereNull('deleted_at');
                    }),
                ],
                'status' => ['required'],
                'role' => ['required'],
            ], [
                'email.required' => 'The email field is required.',
                'contact_number.required' => 'The contact number field is required.',
                'role.required' => 'The role field is required.',
                // 'contact_number.digits_between' => 'The contact number is invalid.',
            ]
        );
        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->input('name');
            // $user->username = strtolower(str_replace(" ","_",$request->input('name')));
            $user->email = $request->input('email');
            $user->contact_number = $request->input('contact_number')??'';
            $user->user_role_id = $request->input('role'); 
            $user->status = $request->input('status');
            $password = generatePassword();
            $user->password = Hash::make($password);
            $randomEmployeeId = User::generateEmpId(); 
            $user->employee_id = $randomEmployeeId;
            $user->username = uniqid().strtolower(substr(str_replace(' ', '', $request->input('name')),0,5));
            //$randomEmployeeId;
            if($user->save()){
                if(!empty(Auth::guard('web')->user())){
                   
                    if(Auth::guard('web')->user()->user_role_id == 6)
                    {
                        $companyInfo = Company::select('id', 'company_logo')->where('user_id',Auth::guard('web')->user()->id)->first();
                        $companyId = $companyInfo->id;
                        $company_logo = $companyInfo->company_logo;
                    } else 
                    {
                        $companyInfo = StaffCompany::select('id', 'company_id')->with('company')->where('user_id',Auth::guard('web')->user()->id)->first();
                        $companyId = $companyInfo->company_id;
                        $company_logo = $companyInfo->company->company_logo;
                    }
                    $staffCompany = new StaffCompany();
                    $staffCompany->user_id = $user->id;
                    $staffCompany->company_id = $companyId;
                    $staffCompany->save();

                    $jsonCompanyhis = 'Added new staff member "'.$user->name.'"';
                    $moduleid = 4;
                    $userId = Auth::guard('web')->user()->id;
                    $action = "Created";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                    
                }
                $data = [
                    'name' =>$user->name,
                    'email'=>$user->email,
                    'password' => $password,
                    'company_logo' => $company_logo
                ];
                
                $adminInfo = User::select('id', 'email', 'name')->where('user_role_id','6')->first();
                // StaffMemberEmailJob::dispatch($data, $user->email);
                sendEmail($user->email, $data, Config::get('constants.emailSubject.StaffMemberCreateMail'), Config::get('constants.emailPageUrl.staffMemeberCreate'),[], "", $adminInfo->email); 
                return response()->json(['success' => 'A staff member is successfully added!']);
            }else{
                return response()->json(['add_error' => 'An error occurred while adding a new staff!']);               
            } 
        }
        return response()->json(['errors' => $validator->errors()]);       
    }
    public function show($id)
    {
        $user = User::with('role')->where('id',$id)->whereNull('deleted_at')->first();
        if(!empty($user)){
            return response()->json(['status' => 'true', 'data' => $user]);
        }
    }
    public function getMemberById($id)
    {
        $user = User::with('role')->where('id',$id)->whereNull('deleted_at')->first();
        if(!empty($user)){
            $staffrole = StaffRole::orderBy('id','asc')->get();            
            return response()->json(['status' => 'true', 'data' => $user]);
        }
    }

    public function edit($id)
    {
        $staffrole = "";
        // StaffRole::orderBy('id','asc')->get();
        $user = User::where('id',$id)->whereNull('deleted_at')->first();
        if(empty($user)){
            return redirect()->route('staff.index')->with('error', 'An error occurred while editing staff member.');
        }
        return view('frontend.staff.edit', compact('user', 'staffrole'));
    }

    /**
     * Delete User
    */
    public function destroy($id)
    {         
        $user = User::findOrFail($id);
        if(!empty($user)){
            $userModel = Auth::guard('web')->user();
            $companyAdminRoleID = UserRole::where('role','Company Admin')->first();
            $staffID = UserRole::whereNot('role','Company Admin')->where('type','Frontend')->pluck('id')->toArray();
            if(Auth::guard('web')->user()->user_role_id == $companyAdminRoleID->id){
                $companyInfo = Company::select('id')->where('user_id', Auth::guard('web')->user()->id)->first();
                $companyid = $companyInfo->id;
            }else if(in_array(Auth::guard('web')->user()->user_role_id, $staffID)){
                $companyInfo = StaffCompany::select('company_id')->where('user_id',$id)->first();
                $companyid = $companyInfo->company_id;
            }
                
            $companystaff = StaffCompany::where(['user_id'=> $id,'company_id'=>$companyid])->first();
            $jsonCompanyhis = 'Deleted staff member "'.$user->name.'"';
            $user->status = '0';
            $user->save();
            if ($user->delete()) {
                $companystaff->delete();
                
                $moduleid = 4;
                $userId = Auth::guard('web')->user()->id;
                $action = "Deleted";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                return redirect()->route('staff.index')->with('success', 'Staff member deleted successfully.');
           }
        }    
       return redirect()->route('staff.index')->with('error', 'An error occurred while deleting staff member.');
    }
    /**
     * Staff Member Update
    */

    public function update(Request $request)
    {        
        $id = $request->member_id;
        $validator = Validator::make($request->all(), [
                'name' => ['required','string'],
                // 'contact_number' => ['required'],
                'email' => [
                    'required',
                    'email',
                    'max:250',
                    Rule::unique('users')->ignore($id)->whereNull('deleted_at'),
                ],
                'status' => ['required'],
                'role' => ['required'],
            ], [
                'contact_number.required' => 'The contact number field is required.',
                // 'contact_number.digits_between' => 'The contact number is invalid.',
            ]
        );
        if ($validator->passes()) {
            $user = User::findOrFail($id);
            if(empty($user)){
                return response()->json(['no_data_error' => 'No staff member record found that you are trying to update.']);            
            }
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->contact_number = $request->input('contact_number');
            $user->username = strtolower(str_replace(" ","_",$request->input('name')));
            $user->status = $request->input('status');
            $user->user_role_id = $request->input('role');
            if ($user->save()) {
                if(Auth::guard('web')->user()){
                        $jsonCompanyhis = 'Updated staff member "'.$user->name.'"';
                        $moduleid = 4;
                        $userId = Auth::guard('web')->user()->id;
                        $action = "Updated";
                        $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return response()->json(['success' => 'Staff member updated successfully.']);
            }
            return response()->json(['update_error' => 'An error occurred while updating staff member.']);
        }
        return response()->json(['errors' => $validator->errors()]);
    }

    public function activityList($id)
    {        
        $user = User::where('id',$id)->whereNull('deleted_at')->first();
        $title = ucfirst($user->name);
        if(empty($user)){
            return redirect()->route('staff.index')->with('danger', 'No user found.');
        }
        $staffrole = UserRole::whereNot('role','Company Admin')->where('type','Frontend')->orderBy('id','asc')->get();
        return view('frontend.staff.activity',compact('title', 'user', 'staffrole'));
    }

    public function loadMoreData(Request $request)
    {
        $page = $request->input('page');
        $userId = $request->input('userId');
        $selectedDate = $request->input('selectedDate');
        $perPage = 20;       
        if($selectedDate != "" && !empty($selectedDate)){
            // $selectedDate = date('Y-m-d', strtotime($selectedDate));
            $utcDate = convertDateTimeZoneUTCToDubai($selectedDate);
            $selectedDate = $utcDate->format('Y-m-d');

            $userActivityDates = UserActivity::where(DB::raw('DATE(created_at)'), $selectedDate)->where('user_id', $userId)->whereNull('deleted_at')->orderBy('id','DESC')->skip(($page - 1) * $perPage)->take($perPage)->get()->toArray();
        }else{
            $userActivityDates = UserActivity::where('user_id', $userId)->whereNull('deleted_at')->orderBy('created_at','DESC')->skip(($page - 1) * $perPage)->take($perPage)->get()->toArray();
        }
        $activityDates = [];
        foreach($userActivityDates as $item){
            // $activityDates[date('Y-m-d',strtotime($item['created_at']))][] = $item;
            $timestamp = str_replace(['am','pm'],"",$item['created_at']);
            $activityDates[date('Y-m-d',strtotime($timestamp))][] = $item;
        }        
        return view('frontend.staff.activity_data',compact('activityDates'));
    }

    public function activityListDatewise($id, $selectedDate)
    {
        if(empty($id)){
            return response()->json(['status' => 'false', 'message' => 'user id is empty.']);
        }
        $html = '';
        $selectedDate = date('Y-m-d', strtotime($selectedDate));
        $userActivity = UserActivity::where(DB::raw('DATE(created_at)'), $selectedDate)->where('user_id', $id)->where('module_id','4')->whereNull('deleted_at')->orderBy('id','DESC')->get();
        
        if(count($userActivity) < 1){
            $html .= '<div class="activity-day">
                <h5 class="activity-date">'.date('d M, Y',strtotime($selectedDate)).'</h5>
                <ul>
                    <li> 
                        <div class="activity-list">
                            <span class="activity-name">No activities found.</span>
                        </div>
                        
                    </li>
                </ul>
            </div>';
        }else{
            $html .= '<div class="activity-day">
                <h5 class="activity-date">'.date('d M, Y',strtotime($selectedDate)).'</h5>
                <ul>'; 
                foreach ($userActivity as $key => $value) {                                                    
                    $html .= '<li>
                        <div class="activity-list">
                            <span class="activity-icon">
                                <picture>
                                    <img  src="'.asset('assets/images/staff-member.svg').'" alt="dashboard" width="" height="">
                                </picture>                    
                            </span>
                            <span class="activity-name">'.$value->description.'</span>
                        </div>
                        <div class="activity-time">'.date('H:s A', strtotime($value->created_at)).'</div>
                    </li>';
                }
            $html .= '</ul></div>';
        }
        echo $html;
    }
}
