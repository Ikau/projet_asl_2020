<?php

namespace App\Http\Middleware;

use App\Utils\Constantes;
use Closure;
use Illuminate\Support\Facades\Gate;

class VerifieEstEnseignant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Gate::authorize(Constantes::GATE_ROLE_ENSEIGNANT);

        return $next($request);
    }
}
