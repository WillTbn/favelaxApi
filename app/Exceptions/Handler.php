<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
    {
        //Symfony\\Component\\HttpKernel\\Exception\\AccessDeniedHttpException
        //Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException

        if ($exception instanceof AuthorizationException || $exception instanceof AccessDeniedHttpException) {
            return response()->json(['error' => 'Não tem autorização para tal.'], 403);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['error' => 'Rota não encontrada, verifique se o verbo esta correto.'], 403);
        }
        return parent::render($request, $exception);
    }
}
