<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class quizzSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->exists('sessao')) {


            return redirect('/' . $request->session()->get('utilizador')['tipo'] . '/dashboard');
        }


        return $next($request);
    }
}
