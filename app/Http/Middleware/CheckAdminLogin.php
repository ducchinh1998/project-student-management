<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckAdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('/admin/login');
        }
        $admin = Auth::guard('admin')->user();
        if ($admin->status == 1) {
            return $next($request);
        }
        Auth::logout();
        return redirect('/admin/login');
    }
}
