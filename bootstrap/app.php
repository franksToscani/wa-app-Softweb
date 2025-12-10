<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Middleware\HandleInertiaRequests; // Assicurati che questo use sia presente

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            // Aggiunge HandleInertiaRequests al gruppo 'web'
            HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Gestisce l'eccezione di validazione per le richieste Inertia/API
        $exceptions->renderable(function (ValidationException $e, Request $request): ?RedirectResponse {
            if ($request->expectsJson() || $request->header('X-Inertia')) {
                return redirect()->back()
                    ->withInput($request->except($e->redirectTo))
                    ->withErrors($e->errors());
            }
            
            // Ritorna null se vuoi che Laravel gestisca l'eccezione normalmente altrimenti
            return null;
        });
    })->create();
