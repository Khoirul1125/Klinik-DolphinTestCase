<?php

use App\Http\Middleware\CheckMenuPermission;
use App\Http\Middleware\DynamicMenuAccess;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use barryvdh\DomPDF\Facade;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->append(\App\Http\Middleware\VerifyLicense::class);

        $middleware->alias([
            'role' => RoleMiddleware::class,
            'PDF' => Facade::class,
            'check.menu.access' => DynamicMenuAccess::class,
            \App\Http\Middleware\VerifyLicense::class, // Tambahkan middleware lisensi


        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();


