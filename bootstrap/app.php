<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\ForceSkill;
use App\Http\Middleware\UserOnline;
use App\Http\Middleware\CheckCompetencyIsOpen;



return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth' => Authenticate::class,
            'role' => RoleMiddleware::class,
            'force.skill' => ForceSkill::class,
            'user.online' => UserOnline::class,
            'competency.open' => CheckCompetencyIsOpen::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
