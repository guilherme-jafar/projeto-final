<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TipoUtilizador
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {



        if ($request->session()->get('utilizador')['tipo'] != $roles) {

            return redirect('/' . $request->session()->get('utilizador')['tipo'] . '/dashboard');
        }

        return $next($request);
    }
}
