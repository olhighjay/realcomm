<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthVendor
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
        if(Auth::guest()) {
            return redirect(route('vendor.login'));
        } elseif(Auth::user()->role != 'vendor') {
            return redirect(route('vendor.login'));
        }
        return $next($request);
    }
}
