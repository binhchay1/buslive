<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role && Auth::user()->role <= 3) {
            if(Auth::user()->role == 2 ) { 
                if(Auth::user()->status == 1) {
                    return $next($request);
                }
                return redirect('/error/status');
            }

            return $next($request);
        } else {
            return redirect('/error/permission');
        } 
    }
}
