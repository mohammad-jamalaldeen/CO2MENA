<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\StaffCompany;
use App\Models\StaffRole;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRole;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    /*
     ** list of Staff Member
    */
    public function index(Request $request, $id)
    {
        $userModel = Auth::guard('admin')->user();
        if($request->ajax()){
            $obj1 = StaffCompany::with(['user','user.role'])->where('company_id',$id)->whereNull('staff_companies.deleted_at');
            $sortField = '';
            $sortOrder = '';
            if (empty($request->get('order')) && empty($request->get('order')[0]) && empty($request->get('order')[0]['column']) && empty($request->get('order')[0]['dir'])) {
                $obj1->orderBy('created_at', 'DESC');
            } else {
                $sortField = $request->get('columns')[$request->get('order')[0]['column']]['name'];
                $sortOrder = strtoupper($request->get('order')[0]['dir']);
            }
            if(isset($request->status_filter)){
                $obj1->whereHas('user',function($query) use($request){
                    $query->where('status',$request->status_filter);
                });
            } else {
                $obj1;
            }
            
            return DataTables::of($obj1)->make(true);
        }
        $companyName = Company::where('id',$id)->first()->toArray();
        return view('admin.staff.list',compact('userModel','companyName'));
    }
    /*
     ** create staff form
    */
    public function create(Request $request,$id)
    {
        $staffrole = UserRole::whereNot('role','Company Admin')->where('type','Frontend')->whereNull('deleted_at')->orderBy('role','asc')->get()->toArray();
        $userModel = Auth::guard('admin')->user();
        return view('admin.staff.create',compact('userModel', 'staffrole'));
    }
    /*
     ** store sub admin 
    */
    public function store(Request $request, $id)
    {
        $request->validate(
            [
                'name' => ['required','string','max:24'],
                // 'contact_number' => ['required'],
                // 'email' => 'required|string|email|max:255|unique:users',
                'profile_picture' => ['nullable','image','mimes:jpeg,png,jpg,webp','max:15360'],
                'status' => ['required'],
                'role' => ['required'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->where(function ($query) {
                        $query->whereNull('deleted_at');
                    }),
                ],
            ]
        );
        
        
        try {
            $imageName = null;
            if ($request->hasFile('profile_picture') && $request->file('profile_picture') instanceof UploadedFile) {
                $profileImage = $request->file('profile_picture');
                $imageName = renameFile($profileImage->getClientOriginalName());
                Storage::disk('admin_user')->put("/{$imageName}", file_get_contents($profileImage->getRealPath()));
            }
            $generateEmpUsername  = User::generateEmpId();
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->contact_number = isset($request->contact_number) ?? 'null';
            $user->user_role_id = $request->input('role'); 
            $user->username = strtolower(substr(str_replace(' ', '', $request->input('name')),0,8)).rand(0,1000000);
            $user->status = $request->input('status');
            $password = generatePassword();
            $user->password = Hash::make($password);
            $user->profile_picture = $imageName;
            $user->employee_id = $generateEmpUsername;
            $user->save();
            if($user->save()){
                $staffCompany = new StaffCompany();
                $staffCompany->user_id = $user->id;
                $staffCompany->company_id = $id;
                $staffCompany->save();
            }
            $companyData = Company::select('id', 'company_logo')->where('id', $id)->first();
            $data = [
                'name' =>$user->name,
                'email'=>$user->email,
                'password' => $password,
                'company_logo' => $companyData->company_logo
            ];
            if(Auth::guard('admin')->user()){
                $jsonCompanyhis = 'Add new staff member "'.$user->name.'"';
                $moduleid = 8;
                $userId = Auth::guard('admin')->user()->id;
                $action = "Created";
                $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
            }
            $adminInfo = User::where('user_role_id','1')->first();
            sendEmail($user->email, $data, Config::get('constants.emailSubject.StaffMemberCreateMail'), Config::get('constants.emailPageUrl.staffMemeberCreate'),[], "", $adminInfo->email);
            return redirect()->route('companystaff.index',$id)->with('success', 'Staff member is successfully added!');
        } catch (Exception $e) {
            return redirect()->route('companystaff.index',$id)->with('error', $e->getMessage());
        }
        
    }
    
    public function show($companyid, $id)
    {
        
        $user = User::with('role')->where('id',$id)->whereNull('deleted_at')->first();
        return view('admin.staff.show', compact('user'));
    }

    public function edit($companyid, $id)
    {
        $staffrole = UserRole::whereNot('role','Company Admin')->where('type','Frontend')->whereNull('deleted_at')->orderBy('role','asc')->get()->toArray();
        $user = User::where('id',$id)->whereNull('deleted_at')->first();
        return view('admin.staff.edit', compact('user', 'staffrole'));
    }

    /**
     * Delete User
    */

    public function destroy($companyid, $id)
    {

        try {
            $user = User::findOrFail($id);
            $companystaff = StaffCompany::where(['user_id'=> $id,'company_id'=>$companyid])->first();
            if ($user->delete()) {
                $companystaff->delete();
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Deleted staff member "'.$user->name.'"';
                    $moduleid = 8;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Deleted";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('companystaff.index',$companyid)->with('success', 'Staff member is successfully deleted.');
           }
        } catch (Exception $e) {
            return redirect()->route('companystaff.index',$companyid)->with('error', $e->getMessage());
        }
       abort(404);
    }

    /**
     * Staff Member Update
    */

    public function update(Request $request, $companyid,$id)
    {
        if(!empty($request->profile_picture)){
            $required = "nullable|image|mimes:jpeg,png,jpg,webp|max:15360";
        } else {
            if(!empty($request->hidden_profile_picture)){
                $required = "nullable|image|mimes:jpg,jpeg,gif,png,webp|max:15360";
            } else {
                $required = "nullable|image|mimes:jpg,jpeg,gif,png,webp|max:15360";
            }
        }
        $request->validate(
            [
                'name' => 'required|string|min:3',
                // 'contact_number' => 'required',
                'profile_picture' => $required,
                'status' => 'required',
            ]
        );
        try {
            $user = User::findOrFail($id);
            $imageName = "";
            /*  Upload Image At Directory Start  */
            if ($request->hasFile('profile_picture') && $request->file('profile_picture') instanceof UploadedFile) {
                $profileImage = $request->file('profile_picture');
                $imageName = renameFile($profileImage->getClientOriginalName());          

                // Upload main image
                Storage::disk('admin_user')->put("/{$imageName}", file_get_contents($profileImage->getRealPath()));
            }else{
                $imageName = $request->hidden_profile_picture;
            }
            /*  Upload Image At Directory End  */
            $user->name = $request->input('name');
            $user->contact_number = isset($request->contact_number) ?? 'null';            
            $user->status = $request->input('status');
            $user->user_role_id = $request->input('role');
            $user->profile_picture = $imageName;
            $user->user_role_id = $request->input('role');
            if ($user->save()) {
                if(Auth::guard('admin')->user()){
                    $jsonCompanyhis = 'Updated staff member "'.$user->name.'"';
                    $moduleid = 8;
                    $userId = Auth::guard('admin')->user()->id;
                    $action = "Updated";
                    $history = userHistoryManage($jsonCompanyhis,$moduleid,$userId,$action);
                }
                return redirect()->route('companystaff.index',$companyid)->with('success', 'Staff member is successfully updated.');
            }
        } catch (Exception $e) {
            return redirect()->route('companystaff.index',$companyid)->with('error', 'An error occurred while updating staff member.');
        }
        abort(404);
    }
    
    public function statusChange(Request $request)
    {
        try {
            $userinfo = User::find($request->user_id);
            $userinfo->status = $request->status;
            $userinfo->save();
            return response()->json(['status'=>true, "message"=>"Status has been change successfully."]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, "message"=>"Status has been not change. "]);
        }

    }
}