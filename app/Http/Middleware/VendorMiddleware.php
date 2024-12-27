<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class VendorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
       
        if (Auth::guard('vendor')->check() && Auth::guard('vendor')->user()->role === 'vendor') {
            return $next($request);
        }
        // Redirect if not vendor
        return redirect()->route('vendor.login')->with('error', 'Access Denied!');
    }
}
