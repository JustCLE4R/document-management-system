<?php

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\NoCache;
use App\Http\Middleware\IsSuperadmin;
use Illuminate\Foundation\Application;
use App\Http\Middleware\SecurityHeader;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'no-cache' => NoCache::class,
            'is-admin' => IsAdmin::class,
            'is-superadmin' => IsSuperadmin::class,
            'security-header' => SecurityHeader::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
