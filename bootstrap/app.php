<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\VendorMiddleware;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\ShareHomeCustomize;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'vendor' => VendorMiddleware::class,
            'PreventBackHistory' =>PreventBackHistory::class,
            'ShareHomeCustomize'=>ShareHomeCustomize::class,
          
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
