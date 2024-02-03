<?php
namespace App\Http\Controllers\Admin\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
  
class AuthController extends Controller
{
   
    public function index()
    {  
        if (Auth::guard('admin')->check() == true) {
            return redirect('admin/dashboard');
        }
        return view('admin.auth.login');
    }  
          
    public function registration()
    {
        return view('register');
    }
      
    public function postLogin(Request $request)
    {
        if($request->isMethod('get'))
        {
            if(Route::currentRouteName() === 'admin.loginpost')
            {
                return redirect('/admin');
            } else
            {
                return redirect('/');
            }
        }
        
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $login = $request->input('email');
 
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $password = $request->input('password');
        $credentials = [
            $fieldType => $login,
            'password' => $password,
        ];
        $userDetails = User::where($fieldType,$request->email)->first();
        if(!empty($userDetails)){
            $userRoleArr = UserRole::where('type','Backend')->whereNull('deleted_at')->get()->pluck('id')->toArray();
            if($userDetails->deleted_at != ""){
                return redirect()->route('admin.login')->with('error',"We couldn't find your account.");
            }else{
                if(in_array($userDetails->user_role_id ,$userRoleArr)){
                    if($userDetails->status == '1'){
                        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
                            return redirect('admin/dashboard')
                                ->with("success",'You have successfully logged in.');
                        }else{
                            return redirect()->route('admin.login')->with('error','Opps! You have entered invalid credentials.');                    
                        }
                    } else {
                        return redirect()->route('admin.login')->with('error','You are not a active user.');            
                    }
                }else{
                    return redirect()->route('admin.login')->with('error',"You are not a valid user.");    
                }
            }
        }else{
            return redirect()->route('admin.login')->with('error',"We couldn't find your account.");
        }  
        
    }

    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
        
        return redirect("dashboard")->withSuccess('Great! You have successfully logged in.');
    }
        
    public function dashboard()
    {
        if(Auth::check()){
            return view('admin/dashboard');
        }  
        return redirect("admin/")->withSuccess("Sorry! you don't have permission to access.");
    }
    
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }
        
    public function logout(Request $request)
    {

        if(Auth::guard('admin')->check()) // this means that the admin was logged in.
        {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->with("success", 'Admin has been successfully logged out.');
        }
    }    
}