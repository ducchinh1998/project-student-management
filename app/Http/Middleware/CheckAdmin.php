<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckAdmin
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
        $check = Auth::guard('admin')->check();
        if (!$check) {
            return redirect('/admin/login');
        }
        $instance = Auth::guard('admin')->user();
        if ($instance->status == 1) {
            return $next($request);
        }
        Auth::logout();
        return redirect('/admin/login');
    }
}
