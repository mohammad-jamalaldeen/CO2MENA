<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use App\Models\{
    Permission,
    UserRole
};
use Illuminate\Support\Facades\{
    Auth,
    Route
};

class FrontendPermission
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
            $userRole = UserRole::where('type', UserRole::FRONTEND)->pluck('id')->toArray();

            if (in_array($user->user_role_id, $userRole)) {
                $route = Route::currentRouteName();
                $prefix = Str::before($route, '.');

                $userWiseAllowedPermissions = Permission::with('module')->where('user_id', $user->id)->get();

                $userHasPermission = $userWiseAllowedPermissions->some(function ($permission) use ($route, $prefix) {
                    return str_contains($route, $permission->action) && $prefix === $permission->module->module_slug;
                });

                if ($userHasPermission) {
                    return $next($request);
                }

                if(count($userWiseAllowedPermissions->toArray()) == 0)
                {
                    
                    $allowedPermissions = Permission::with('module')->where('user_role_id', $user->user_role_id)->get();
                    $hasPermission = $allowedPermissions->some(function ($permission) use ($route, $prefix) {
                        return str_contains($route, $permission->action) && $prefix === $permission->module->module_slug;
                    });
    
                    if ($hasPermission) {
                        return $next($request);
                    }
                }

                return redirect()->route('access-denied');
            }
        }

        return $next($request);
    }
}
