<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Company;
use Illuminate\Support\Str;
use App\Models\StaffCompany;
use Illuminate\Support\Facades\{
    Auth,
    Route
};
use App\Models\{
    Permission,
    UserRole
};



class CompanyOnBoradingProcessCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('web')->user();
        
        if ($user) {
            $staffRoleId = UserRole::whereNot('role','Company Admin')->where('type','Frontend')->pluck('id')->toArray();
            if (in_array($user->user_role_id,$staffRoleId)) {
                $staffInfo = StaffCompany::select('company_id')->where('user_id', $user->id)->first();
                $company_id = $staffInfo->company_id;
                $company = Company::select('user_id', 'is_draft', 'draft_step')->where('id', $company_id)->first();
                if ($company != NULL && $company->is_draft == '0') {
                    return $next($request);
                } else {
                    Auth::logout();
                    return redirect()->route('web.login')->with('error', 'Company onboarding process is incomplete.');
                }
            }
            $company = Company::where('user_id', $user->id)
                ->first(['id', 'is_draft', 'draft_step']);

            if ($company === null || $company->is_draft === '1') {
                return companyDetailPage($company->draft_step ?? 1);
            }
        }
        return $next($request);
    }
}
