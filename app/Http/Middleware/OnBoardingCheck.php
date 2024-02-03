<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnBoardingCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return ($this->checkCompanyDetailSaveAsDraft()) ? $next($request) :  redirect()->route('dashboard.index');
    }

    public function checkCompanyDetailSaveAsDraft()
    {
        $user = optional(\Illuminate\Support\Facades\Auth::guard('web')->user());
        $companyData = \App\Models\Company::where('user_id', $user->id)->first();

        return $companyData ? $companyData->is_draft == '1' : true;
    }
}
