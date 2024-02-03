<?php
namespace App\Http\Controllers\Admin\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\PasswordResetTokens;
use Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPasswordOtpMail;
use App\Models\UserRole;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Response;
use Illuminate\Support\Facades\Validator;
  
class ForgotPasswordController extends Controller
{
   
    public function index()
    {
        return view('admin.auth.forgot_password');
    } 

    public function otpFormView($userId)
    {
        if($userId == ""){
            return redirect()->route('admin.forgotpassword')->with(['success' => 'User is not found.']);
        }
        try {
            $data = Crypt::decrypt($userId);
            $userId = $data['id'];
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->route('admin.forgotpassword')->with(['error' => 'Invalid user.']);
        }
        $user = User::where('id', $userId)->where('status','1')->first();
        if (!$user) {
            return redirect()->route('admin.forgotpassword')->with(['success' => 'User is not found.']);
        }
        return view('admin.auth.otp_verification')->with(['user' => $user]);
    }

    public function resetPaswordView($token)
    {   
        $email = Request('email');
        return view('admin.auth.reset_password',['token' => $token, 'email' =>$email]);
    }  
    public function setNewPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[^A-Za-z0-9]/',
            'password_confirmation' => 'required'
        ]);    
        if ($validator->passes()) {
            $update = PasswordResetTokens::where(['email' => $request->email, 'token' => $request->token])->first();
        
            if(!$update){
                return Response::json(['invalid' => 'Invalid token!']);
            }

            $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

            PasswordResetTokens::where(['email'=> $request->email])->delete();
            return Response::json(['success' => 'Your password has been reset!']); 
        }
        return Response::json(['errors' => $validator->errors()]);               
    }
    public function sentOtpEmail(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|email',
            ]);
    
            $user = User::where('email', $request->email)->where('status','1')->first();
            if (!$user) {            
                return redirect()->back()->withErrors(['email' => 'Enter a correct email address.']);
            }
            if ($user) {
                $userRoleIds = UserRole::where('type','Backend')->pluck('id')->toArray();
                if(!in_array($user->user_role_id, $userRoleIds)){
                    return redirect()->back()->withErrors(['email' => 'Enter a correct email address.']);
                }
            }        
           
            if ($this->sendEmailOTP($user)) {
                $parameter =[
                    'id' => $user->id,
                ];
                $id= Crypt::encrypt($parameter);
                return redirect('admin/otp-verification/'.$id)->with([
                                "success" => 'OTP has been sent to your email address please check your email for the OTP.'
                            ]);
            } else {
                return redirect()->back()->with(['danger' => 'Network error occurred. Please try again.']);
            }
        } catch(\Exception $e) 
        {
            print_R($e->getMessage());
            exit;
            return redirect()->back()->with(['danger' => 'Network error occurred. Please try again.']);
        }
        
        
    }   

    private function sendEmailOTP($user)
    {
        // $recentOTPCount = $recentOTPCount + 1;
        $otp = rand(111111,999999);
        $email = $user->email;
        $expiryMinutes = 15;
        $expiryTime = Carbon::now()->addMinutes($expiryMinutes);
        $expiryFormatted = $expiryTime->format('Y-m-d H:i:s');
        User::where('email', $email)
            ->update([
                'otp' => $otp,
                //'otp_attempts_count' => $recentOTPCount,
                'sent_otp_datetime' => $expiryFormatted
            ]);
        
        try {
            $data = [
                'username'=>$user->username,
                'otp' => $otp,
                'company_logo' => asset('assets/images/logo.png')
            ];        
            Mail::to($email)->send(new ForgetPasswordOtpMail($data));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function resentOtpEmail($id)
    {        
        if($id == ""){
            return response()->json(['status'=>'false', 'message' => 'Invalid user!']);
        }
        $user = User::where('id', $id)->where('status','1')->first();
        if (!$user) {
            return response()->json(['status'=>'false', 'message' => 'Invalid user!']);
        }
        if ($user) {
            $userRoleIds = UserRole::where('type','Backend')->pluck('id')->toArray();
            if(!in_array($user->user_role_id, $userRoleIds)){
                return redirect()->back()->withErrors(['email' => 'Enter a correct email address.']);
            }
        }
        
        if ($this->sendEmailOTP($user)) {
            return response()->json(['status'=>'true', 'message' => 'OTP has been sent to your email address please check your email for the OTP.']);
        } else {
            return response()->json(['status'=>'false', 'message' => 'Network error occurred. Please try again.']);
        }
        
    }  

    public function verifyOTP(Request $request)
    {
        if ($request->email == "") {
            return redirect()->back()->with(['danger' => 'User is not found.']);
        }
        $otp='';
        foreach($request->otp as $item)
        {
            $otp .= $item;
        }
        $otpEnteredByUser = $otp; 
        
        $user = User::where('email', $request->email)->where('status','1')->first();        
        if (!$user) {
            return redirect()->back()->with(['danger' => 'User is not found.']);
        }
        $storedOtp = $user->otp;
        $storedExpiry = $user->sent_otp_datetime;
        if ($otpEnteredByUser === $storedOtp && Carbon::now()->lt($storedExpiry)) {
            PasswordResetTokens::where('email', $user->email)->delete();
            
            $PasswordResetTokens = new PasswordResetTokens;
            $PasswordResetTokens->email = $user->email;
            $PasswordResetTokens->token = Str::random(60);
            $PasswordResetTokens->created_at = Carbon::now();
            $PasswordResetTokens->save();
            
            $tokenData = PasswordResetTokens::where('email', $user->email)->first();
            $email = $tokenData->token.'?email='.urlencode($user['email']);
            return redirect('admin/reset-password/'.$email)->with(['success' => 'OTP is verified! Please set new password.']);
        } else {
            return redirect()->back()->with('danger','OTP is invalid or expired, resend OTP and try again.');
        }
    }
        
}