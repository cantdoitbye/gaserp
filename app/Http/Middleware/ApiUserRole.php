<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Exception;

class ApiUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $token = JWTAuth::getToken();
        
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = JWTAuth::parseToken()->authenticate();
        if ($user && ($user instanceof \App\Models\User)) {
            // The user belongs to either the "users" or "riders" table
            return $next($request);
        }

        // Unauthorized if the user doesn't belong to the specified tables
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
