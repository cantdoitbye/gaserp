<?php

namespace App\Http\Middleware;

use App\Models\AdminPermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Adminrole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $user = Auth::guard('admin')->user();
        if($user->role === 1){
            return $next($request);

        }
        $routeName = $request->route()->getName();
if ($routeName === 'admin.logout' || 'admin.dashboard') {
    return $next($request);
}
        $permissions = AdminPermission::where('admin_id', $user->id)->pluck('permissions');
        // $permissions = 

        if ($user && $user->role === 2) {
            // $segments = $request->segments();
            $segment1 = request()->segment(1);
            $segment2 = request()->segment(2);
            // $secondSegment = isset($segments[2]) ? $segments[2] : null;

        
            if ($permissions->contains($segment2)) {
                return $next($request);

            }
            abort(404);
        }
    }
}
