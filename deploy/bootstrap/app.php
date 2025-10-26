<?php

use App\Http\Middleware\InProgressStudentsMiddleware;
use App\Http\Middleware\PassStudentsMiddleware;
use Illuminate\Foundation\Application;
use App\Http\Middleware\RoleAccessMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'restrict_admin'=> \App\Http\Middleware\RestrictSpecificAdmin::class,
            'role' => RoleAccessMiddleware::class,
            'pass' => PassStudentsMiddleware::class,
            'In_progress' => InProgressStudentsMiddleware::class
        ]);
        //   $middleware->alias(['pass' => PassStudentsMiddleware::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
