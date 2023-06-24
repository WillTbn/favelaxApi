<?php

namespace App\Http\Middleware;

use Silber\Bouncer\Bouncer;

use Closure;
use Illuminate\Support\Facades\Auth;

class ScopeBouncerMod
{
    /**
     * The Bouncer instance.
     *
     * @var \Silber\Bouncer\Bouncer
     */
    protected $bouncer;

    /**
     * Constructor.
     *
     * @param \Silber\Bouncer\Bouncer  $bouncer
     */
    public function __construct(Bouncer $bouncer)
    {
        $this->bouncer = $bouncer;
    }

    /**
     * Set the proper Bouncer scope for the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (!$user->isAn('admin') && !$user->isAn('mod')) {
               return response()->json(['status'=> 403, 'message'=> 'Acesso Negado.'], 403);
            }
        }

        return $next($request);
    }
}
