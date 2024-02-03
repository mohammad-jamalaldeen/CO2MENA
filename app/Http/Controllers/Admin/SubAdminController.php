<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use App\Models\UserRole;
use Exception;
use Illuminate\Support\Facades\Config;
use App\Rules\NumericMaxLengthRule;

class SubAdminController extends Controller
{
    
    /*
     ** list of sub admin
    */
    public function index(Request $request)
    {   
        if($request->ajax()){
            $adminRole = UserRole::whereNot('role','Super Admin')->where('type','Backend')->whereNull('deleted_at')->pluck('id')->toArray();
            $obj1 = User::whereIn('user_role_id',$adminRole)->whereNull('deleted_at');

            $sortField = '';
            $sortOrder = '';
            if (empty($request->get('order')) && empty($request->get('order')[0]) && empty($request->get('order')[0]['column']) && empty($request->get('order')[0]['dir'])) {
                $obj1->orderBy('created_at', 'DESC');
            } else {
                $sortField = $request->get('columns')[$request->get('order')[0]['column']]['name'];
                $sortOrder = strtoupper($request->get('order')[0]['dir']);
            }

            if(isset($request->status_filter) && ($request->status_filter == 1 || $request->status_filter == 0)){
                $obj1->where('status',$request->status_filter);
            }else{
                $obj1;
            }
            return DataTables::of($obj1)->make(true);
        }
        return view('admin.sub-admin.list');
    }


    /*
     ** create sub admin form
    */
    public function create(Request $request)
    {   
        $adminRole = UserRole::whereNot('role','Super Admin')->where('type','Backend')->whereNull('deleted_at')->orderBy('role','asc')->get()->toArray();
        return view('admin.sub-admin.create', compact('adminRole'));
    }

    /*
     ** store sub admin 
    */
    public function store(Request $request)
    {

        $request->validate(
            [
                'name' => 'required|string|min:3|regex:/[^0-9]+/',
                'contact_number' => ['required'],
                'email' => 'required|string|email|max:255|unique:users',
                // 'username' => 'required|string|max:24|unique:users|regex:/[^0-9]+/',
                // 'profile_picture' => $request->has('hidden_profile_picture') ? 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360' : 'required|image|mimes:jpeg,png,jpg,webp|max:15360',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
                // 'status' => 'required',
                // 'role' => 'required',
            ],
        );
        try {
            $imageName = null;
            if ($request->hasFile('profile_picture') && $request->file('profile_picture') instanceof UploadedFile) {
                $profileImage = $request->file('profile_picture');
                $imageName = renameFile($profileImage->getClientOriginalName());
                Storage::disk('admin_user')->put("/{$imageName}", file_get_contents($profileImage->getRealPath()));
            }
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->contact_number = $request->input('contact_number');
            $user->user_role_id = $request->role; 
            $user->username = $request->input('username');
            $user->status = $request->input('status');
            $password = generatePassword();
            $user->password = Hash::make($password);
            $user->profile_picture = $imageName;
            $user->save();

            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $password,
                'company_logo' => 'No_profile_picture.jpeg'
            ];

            $adminInfo = User::where('user_role_id', '1')->first();
            sendEmail($user->email, $data, Config::get('constants.emailSubject.SubAdminCreateMail'), Config::get('constants.emailPageUrl.subadmincreatemail'),[], "", $adminInfo->email);
            return redirect()->route('sub-admin.index')->with([
                'success' => 'Sub admin is successfully added!'
            ]);
        } catch (Exception $e) {
            return redirect()->route('sub-admin.index')->with('success', $e->getMessage());
        }
        
    }
   /****
    * 
    * Sub Admin Details Show Page
    */
    public function show($id)
    {
        $user = User::where('id',$id)->whereNull('deleted_at')->first();
        $staffrole = UserRole::where('id',$user->user_role_id)->whereNull('deleted_at')->first();
        return view('admin.sub-admin.show', compact('user', 'staffrole'));
    }

    public function usershowhistory(Request $request, $id)
    {
        $obj1 = UserActivity::with(['module'])->where('user_id',$id);
        $sortField = '';
        $sortOrder = '';
        if (empty($request->get('order')) && empty($request->get('order')[0]) && empty($request->get('order')[0]['column']) && empty($request->get('order')[0]['dir'])) {
            $obj1->orderBy('created_at', 'DESC');
        } else {
            $sortField = $request->get('columns')[$request->get('order')[0]['column']]['name'];
            $sortOrder = strtoupper($request->get('order')[0]['dir']);
        }
        return DataTables::of($obj1)->make(true);
    }

    public function edit($id)
    {
        $user = User::where('id',$id)->whereNull('deleted_at')->first();
        $adminRole = UserRole::whereNot('role','Super Admin')->where('type','Backend')->whereNull('deleted_at')->orderBy('role','asc')->get()->toArray();
        return view('admin.sub-admin.edit', compact('user', 'adminRole'));
    }

    /**
     * Delete User
    */

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->delete()) {
                return redirect()->route('sub-admin.index')->with('success', 'Sub admin is successfully deleted.');
            }
        } catch (Exception $e) {
            return redirect()->route('sub-admin.index')->with('success', $e->getMessage());
        }
        abort(404);
    }

    /**
     * User Update
    */

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|regex:/[^0-9]+/',
            'contact_number' => ['required'],
            'email' => [
                'required',
                'email',
                \Illuminate\Validation\Rule::unique('users')->whereNull("deleted_at")->whereNot('id', $id),
            ],
            // 'username' => [
            //     'required',
            //     'string',
            //     'max:24',
            //     'regex:/[^0-9]+/',
            //     \Illuminate\Validation\Rule::unique('users')->whereNull("deleted_at")->whereNot('id', $id),
            // ],
            // 'profile_picture' => !empty($request->profile_picture) ? 'nullable|mimes:jpeg,png,jpg,webp|max:15360' : ($request->has('hidden_profile_picture') ? 'nullable|mimes:jpg,jpeg,gif,png,webp|max:15360' : 'required|mimes:jpg,jpeg,gif,png,webp|max:15360'),
            'profile_picture' => 'nullable|mimes:jpeg,png,jpg,webp|max:15360',
            // 'status' => 'required',
            // 'role' => 'required',
        ]);

        try {
            $user = User::findOrFail($id);
            $imageName = $user->profile_picture;
    
            // Remove Old Image From Directory
            if (!empty($request->input('is_profile_image_remove')) && $request->input('is_profile_image_remove') == 'yes' && !empty($imageName)) {
                if (Storage::disk('admin_user')->exists($imageName)) {
                    Storage::disk('admin_user')->delete($imageName);
                }
                $imageName = null;
            }
    
            // Upload Image At Directory
            if ($request->hasFile('profile_picture') && $request->file('profile_picture') instanceof UploadedFile) {
                $profileImage = $request->file('profile_picture');
                $imageName = renameFile($profileImage->getClientOriginalName());
    
                // Upload main image
                Storage::disk('admin_user')->put("/{$imageName}", file_get_contents($profileImage->getRealPath()));
            } elseif ($request->has('hidden_profile_picture')) {
                $imageName = $request->hidden_profile_picture;
            }
    
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->contact_number = $request->input('contact_number');
            $user->username = $request->input('username');
            $user->status = $request->input('status');
            $user->profile_picture = $imageName;
            $user->user_role_id = $request->role; 
    
            if ($user->save()) {
                return redirect()->route('sub-admin.index')->with('success', 'Sub admin is successfully updated.');
            }
        } catch (Exception $e) {
            return redirect()->route('sub-admin.index')->with('success', $e->getMessage());
        }
        abort(404);   
    }
}
