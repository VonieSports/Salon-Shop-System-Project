<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(
        except: [
            'webhooks/paymongo',
            'webhooks/paymongo/', 
        ]
    );
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'employee' => \App\Http\Middleware\EmployeeMiddleware::class,
            'customer' => \App\Http\Middleware\CustomerMiddleware::class,
            'owner' => \App\Http\Middleware\OwnerMiddleware::class,
            'setup.complete' => \App\Http\Middleware\EnsureBusinessSetup::class,
            'track.activity' => \App\Http\Middleware\TrackUserActivity::class,
        ]);
        
        $middleware->redirectGuestsTo(function ($request) {
            if ($request->is('webhooks/paymongo')) {
                return null; 
            }
            return route('login');
              });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
