<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class Pergunta extends Controller
{
    function show(Request $request){

//        return view('/prof/Disciplina', ['topico' => $topico]);

        $pergunta =  \App\Models\pergunta::find($request->id);

        if (!empty($pergunta)){
            return view('/prof/pergunta', ['pergunta' => []]);
        }else{
            return view('/prof/pergunta', ['pergunta' => []]);
        }


    }
}
