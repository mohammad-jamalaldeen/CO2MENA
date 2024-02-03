<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Mail\ForgetPasswordOtpMail;
use App\Models\{
    User,
    UserSubscription,
    Company,
    Datasheet,
    StaffCompany,
    StaffRole,
    UserRole
};


class LoginController extends Controller
{
    /********
     * User Login form
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }
        return view('auth.login');
    }

    /********
     * User Login check email or username
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        $loginField = $request->input('email');
        $password = $request->input('password');
        $credentials = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? ['email' => $loginField, 'password' => $password] : ['username' => $loginField, 'password' => $password];
        $remember_me = $request->has('remember') ? true : false;
        $checkCredentials = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $userCheckData = User::where($checkCredentials, $loginField)->first();

        if ($userCheckData) {
            if ($userCheckData->trashed()) {
                return redirect('/')->with('error', 'Your account is deleted please contact admin.');
            } else {
                $userRoleIds = UserRole::where('type','Frontend')->pluck('id')->toArray();
                if(in_array($userCheckData->user_role_id,$userRoleIds)){
                    if (Auth::guard('web')->attempt($credentials, $remember_me)) {
                        $userDetails =  Auth::guard('web')->user();
                        $staffRoleId = UserRole::whereNot('role','Company Admin')->where('type','Frontend')->pluck('id')->toArray();
                        if (in_array($userDetails->user_role_id, $staffRoleId)) {
                            $companyStaffData = StaffCompany::select('id', 'user_id', 'company_id')->where('user_id', $userDetails->id)->first();
                            $subscription = UserSubscription::where('company_id', $companyStaffData->company_id)->whereNull('deleted_at')->orderBy('created_at', 'desc')->latest()->first();
                        } else {
                            $subscription = UserSubscription::where('user_id', $userDetails->id)->whereNull('deleted_at')->orderBy('created_at', 'desc')->latest()->first();
                        }
                        if (!empty($subscription)) {
                            $todaydate = strtotime(date('Y-m-d'));
                            $startDate = strtotime(date('Y-m-d', strtotime($subscription->start_date)));
                            $endDate = strtotime(date('Y-m-d', strtotime($subscription->end_date)));
                            if ($startDate <= $todaydate && $endDate >= $todaydate) {
                                if (Auth::guard('web')->user()->status == '0') {
                                    Auth::logout();
                                    return redirect()->route('web.login')->with('error', 'Your account is currently not active. Please get in touch with your administrator to have it activated.');
                                } else {
                                    if (in_array($userDetails->user_role_id, $staffRoleId)) {
                                        $staffInfo = StaffCompany::select('company_id')->where('user_id', $userDetails->id)->first();
                                        if ($staffInfo != NULL) {
                                            $company_id = $staffInfo->company_id;
                                            $companyData = Company::select('user_id', 'is_draft', 'draft_step')->where('id', $company_id)->first();
                                            if ($companyData != NULL && $companyData->is_draft == '0') {
                                                return redirect()->route('dashboard.index')->with("success", 'You have successfully logged in.');
                                            } else {
                                                Auth::logout();
                                                return redirect()->route('web.login')->with('error', 'Company onboarding process is incomplete.');
                                            }
                                        } else {
                                            Auth::logout();
                                            return redirect()->route('web.login')->with('error', 'Company is not found.');
                                        }
                                    } else {
                                        $companyData = Company::select('user_id', 'is_draft', 'draft_step')->where('user_id', $userDetails->id)->first();
                                        if ($companyData != NULL && $companyData->is_draft == '0') {
                                            return redirect()->route('dashboard.index')->with("success", 'You have successfully logged in.');
                                        }
                                        return  companyDetailPage($companyData->draft_step ?? 1);
                                    }
                                }
                            } else {
                                Auth::logout();
                                $sub_date = date('d-m-Y', strtotime($subscription->start_date));
                                if ($startDate >= $todaydate) {
                                    return redirect()->route('web.login')->with('successSubscription', "Your subscription for this $userCheckData->email will start on $sub_date.");
                                } else {
                                    return redirect()->route('web.login')->with('error', 'Your subscription has been expired.');
                                }
                            }
                        } else {
                            Auth::logout();
                            return redirect()->route('web.login')->with('error', 'Your subscription has been expired.');
                        }
                    } else {
                        return redirect('/')->with('error', 'Password is incorrect, please enter correct password.');
                    }
                }else{
                    return redirect('/')->with('error', 'Your account is not valid.');
                }
            }
        } else {
            return redirect('/')->with('error', "We couldn't find your account");
        }
    }

    /********
     * User forget password
     */

    public function forgetpasswordform()
    {
        return view('auth.forget-password');
    }

    /********
     * User forget password mail
     */
    public function forgetPasswordMail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ], [
            'required' => "Please enter email",
            'email.exists' => 'This email address is invalid',
        ]);

        $userDetails = User::where('email', $request->email)->first();
        if (!empty($userDetails)) {
            $slug = Str::random(60);
            $otp = rand(111111, 999999);
            $otpTime =  \Carbon\Carbon::now()->addMinutes(15);
            $userDetails->otp = $otp;
            $userDetails->sent_otp_datetime = $otpTime->format('Y-m-d H:i:s');
            $userDetails->save();
            DB::table('password_reset_tokens')->where('email', $userDetails->email)->delete();
            DB::table('password_reset_tokens')->insert([
                'email' => $userDetails->email,
                'token' => $slug,
                'created_at' => Carbon::now()
            ]);
            $tokenData = DB::table('password_reset_tokens')->where('email', $userDetails->email)->first();
            $companyLogo = asset('assets/images/logo.png');
            if($userDetails->user_role_id == 6)
            {
                $companyData = Company::select('user_id', 'company_logo')->where('user_id', $userDetails->id)->first();
                $companyLogo = $companyData->company_logo;
            } else 
            {
                $companyData = StaffCompany::with('company')->where('user_id', $userDetails->id)->first();
                if(isset($companyData->company->company_logo))
                {
                    $companyLogo = $companyData->company->company_logo;
                }
            }
            $data = [
                'username' => $userDetails->username,
                'otp' => $otp,
                'company_logo' => $companyLogo
            ];
            
            Mail::to($userDetails->email)->send(new ForgetPasswordOtpMail($data));
            return redirect()->route('web.forgetpassword.otp', $slug)->with("success", "OTP has been sent to your email address please check your email for the OTP.");
        } else {
            return redirect()->route('web.login')->with("error", "User does not exists.");
        }
    }

    public function forgetpasswordotp($slug)
    {
        return view('auth.otp', compact('slug'));
    }

    public function otpCheck(Request $request, $slug)
    {
        $Otp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4 . $request->otp5 . $request->otp6;
        $tokenData = DB::table('password_reset_tokens')->where('token', $slug)->first();
        $userDetails = User::where('email', $tokenData->email)
            ->where('sent_otp_datetime', '>', \Carbon\Carbon::now()->format('Y-m-d H:i:s'))
            ->orderBy('created_at', 'asc')
            ->first();
        if (empty($userDetails) && !isset($userDetails)) {
            return redirect()->back()->with('error', "The otp has been expired, please resend a new code.");
        } else if ($userDetails->otp != $Otp) {
            return redirect()->back()->with('error', "Please enter correct OTP.");
        } else {
            $userDetails->otp = null;
            $userDetails->sent_otp_datetime = null;
            $userDetails->forgot_password_string = null;
            $userDetails->save();
            return redirect()->route('web.reset.password', $tokenData->token)->with("success", "Your OTP is verified.");
        }
    }

    /****
     * Resend Otp this email
     */
    public function resendOtp($slug)
    {
        $tokenData = DB::table('password_reset_tokens')->where('token', $slug)->first();
        $userDetails = User::where('email', $tokenData->email)->first();
        if (!empty($userDetails)) {

            $otp = rand(111111, 999999);
            $otpTime =  \Carbon\Carbon::now()->addMinutes(1);
            $userDetails->otp = $otp;
            $userDetails->forgot_password_string = $slug;
            $userDetails->sent_otp_datetime = $otpTime->format('Y-m-d H:i:s');
            $userDetails->save();
            $data = [
                'username' => $userDetails->username,
                'otp' => $otp
            ];
            Mail::to($userDetails->email)->send(new ForgetPasswordOtpMail($data));
            return response()->json(['status' => 'true', 'message' => 'OTP has been sent to your email address please check your email for the OTP.']);
        } else {
            return response()->json(['status' => 'false', 'message' => 'Network error occurred. Please try again.']);
        }
    }
    /******
     * Reset password Form
     */
    public function resetpassword($token)
    {
        $passwordToken = DB::table('password_reset_tokens')->where('token', $token)->first();
        if (!empty($passwordToken)) {
            return view('auth.reset-password', compact('token'));
        } else {
            return redirect()->route('web.login')->withErrors('error', 'Network error occurred. Please try again.');
        }
    }

    /******
     * Reset password Form submit
     */
    public function resetpasswordsubmit(Request $request, $token)
    {
        $request->validate([
            'password' => 'required|string|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[^A-Za-z0-9]/',
            // 'confirm_passwod' => 'required'
            // 'password' => 'required|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/m|min:8',
            'confirm_passwod' => 'required|same:password|min:8'
        ]);
        $password = $request->password;
        $tokenData = DB::table('password_reset_tokens')->where('token', $token)->first();
        if (empty($tokenData)) {
            return redirect()->route('web.forget.password')->with('error', 'Network error occurred. Please try again.');
        }
        $user = User::where('email', $tokenData->email)->first();
        if (empty($user)) {
            return redirect()->route('web.forget.password')->with('error', 'The email address provided could not be found in our records.');
        }
        $user->password = Hash::make($password);
        $user->save();
        if ($user->save()) {
            DB::table('password_reset_tokens')->where('token', $token)->delete();
            Session::flash('success', 'Your password has been successfully reset.');
            return response()->json(["success" => true]);
        } else {
            Session::flash('error', 'An error occurred.');
            return response()->json(["success" => false]);
        }
    }   

    public function logout()
    {
        Auth::logout();
        return redirect()->route('web.login')->with("success", 'User has been successfully logged out.');
    }
}
