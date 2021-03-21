<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Disciplina extends Controller
{

    function index(){


        $disciplina = DB::table('disciplina')
            ->where('id','=', session('utilizador')['id'])
            ->get();

        if (!empty($disciplina[0])){
            return view('/prof/dashboard', ['disciplina' => $disciplina]);
        }else{
            return view('/prof/dashboard', ['disciplina' => 'vazio']);
        }




    }
}
