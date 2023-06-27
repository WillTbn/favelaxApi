<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

class AdminMiddleware
{

    public function handle($request, Closure $next)
    {

        if ($request->user() && $request->user()->role == 'admin' ) {
            return $next($request);
        }
        throw new AuthenticationException('Acesso não autorizado.');
    }
}
