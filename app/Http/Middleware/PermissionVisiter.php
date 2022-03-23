<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class PermissionVisiter
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
        if (Auth::check() == true && Auth::user()->role === null && Auth::user()->email_verified_at !== null) {
            return $next($request);
        }

        if (Auth::check() == true && Auth::user()->role === null && Auth::user()->email_verified_at === null) {
            return redirect('/email/verify');
        }

        if(Auth::check() == true && Auth::user()->role == 3) {
            return redirect('/error/permission');
        }

        if (Auth::check() == false or Auth::user()->role === null) {
            return $next($request);
        } else {
            return redirect('/error/permission');
        }
    }
}
