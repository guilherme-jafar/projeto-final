<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuth
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


        if (!$request->session()->exists('utilizador') ) {

            return redirect('/login');
        }elseif ($request->session()->exists('sessao')){
            if (session('utilizador')['tipo']=='aluno'){
            return redirect('/WaitRoomStudent/'.session('sessao')['master'].'/'.
                session('sessao')['quizz']);}
        }


        return $next($request);
    }
}
