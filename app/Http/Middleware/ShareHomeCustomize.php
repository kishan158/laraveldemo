<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\HomeCustomize;

class ShareHomeCustomize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Fetch the HomeCustomize data
        $Images = HomeCustomize::first();
        $title = $Images ? json_decode($Images->title, true) : null;

        // Share the title data with all views
        view()->share('title', $title);

        return $next($request);
    }
}
