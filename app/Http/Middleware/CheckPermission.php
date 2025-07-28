<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $module
     * @param  string  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $module, $permission)
    {
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return redirect()->route('login');
        }

        // Fetch the user's permissions
        $permissions = json_decode($user->permissions, true);

        // Check if the user has the specified module and permission
        if (isset($permissions[$module]) && in_array($permission, $permissions[$module])) {
            return $next($request);
        }

        // If permission is not granted, redirect or abort
        return abort(403, 'Unauthorized action.');
    }
}
