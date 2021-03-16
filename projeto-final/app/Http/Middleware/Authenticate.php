<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {


        if (!$request->session()->exists('email')){
            return route('/');
        }else {
            if (request()->session()->get('tipo') == 'prof') {
                dd('dsfsd');
                return route('/prof/dashboard');
            } else {
                return route('/aluno/dashboard');
            }


//        if (! $request->expectsJson()) {
//            return route('login');
//        }
        }
    }
}
