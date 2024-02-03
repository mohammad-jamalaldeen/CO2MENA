<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServerHeaderMiddalware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Modify the Server header
        $response->header('Server', $request->server('SERVER_NAME'));
        $response->header("pragma", "private");
        $response->header('Cache-Control', 'no-cache, must-revalidate, private, max-age=86400, stale-while-revalidate=604800');
        
        return $response;
    }
}
