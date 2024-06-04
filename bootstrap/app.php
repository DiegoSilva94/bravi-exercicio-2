<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(fn () => true)
            ->renderable(function (NotFoundHttpException $exception) {
                $message = match ($exception->getPrevious()?->getModel()) {
                    'App\Models\User' => 'Usuario não encontrado.',
                    'App\Models\Pessoa' => 'Pessoa não encontrada.',
                    'App\Models\Contato' => 'Contato não encontrada.',
                    default => $exception->getMessage(),
                };
                return response()->json([
                    'message' => $message,
                ], 404);
            });
//            ->render(fn (Throwable $throwable) => response()->json([ 'message' => $throwable->getMessage(), 'class' => get_class($throwable) ], 500));
    })->create();
