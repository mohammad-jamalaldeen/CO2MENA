<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use App\Models\{
    Permission,
    UserRole
};
use Illuminate\Support\Facades\{
    Auth,
    Route
};

class AdminAuthMiddalware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $adminUser = Auth::guard('admin')->user();
        $userRoleIds = UserRole::where('type', UserRole::BACKEND)->pluck('id')->toArray();
        
        // if (!$adminUser || !in_array($adminUser->user_role_id, $userRoleIds)) {
        //     return redirect('admin/login');
        // }
        if ($adminUser) {
            if ($adminUser->user_role_id == 1) {
                return $next($request);
            }

            if (in_array($adminUser->user_role_id, $userRoleIds)) {
                $route = Route::currentRouteName();
                $prefix = Str::before($route, '.');
                if($prefix == 'profile')
                {
                    return $next($request);
                }
                
                $userWiseAllowedPermissions = Permission::with('module')->where('user_id', $adminUser->id)->get();

                $userHasPermission = $userWiseAllowedPermissions->some(function ($permission) use ($route, $prefix) {
                    return str_contains($route, $permission->action) && $prefix === $permission->module->module_slug;
                });

                if ($userHasPermission) {
                    return $next($request);
                }

                if (count($userWiseAllowedPermissions->toArray()) == 0) {
                    $allowedPermissions = Permission::with('module')->where('user_role_id', $adminUser->user_role_id)->get();

                    $hasPermission = $allowedPermissions->some(function ($permission) use ($route, $prefix) {
                        return str_contains($route, $permission->action) && $prefix === $permission->module->module_slug;
                    });

                    if ($hasPermission) {
                        return $next($request);
                    }
                }

                return redirect()->route('profile.edit');
            }
            return $next($request);
        } else {
            return redirect()->route('admin.login');
        }
    }
}
