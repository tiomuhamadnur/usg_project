<?php

use Illuminate\Foundation\Application;
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
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'isAssigned' => \App\Http\Middleware\isAssigned::class,
            'superAdmin' => \App\Http\Middleware\superAdmin::class,
            'Admin' => \App\Http\Middleware\Admin::class,
            'Dokter' => \App\Http\Middleware\Dokter::class,
            'Suster' => \App\Http\Middleware\Suster::class,
            'Kasir' => \App\Http\Middleware\Kasir::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
