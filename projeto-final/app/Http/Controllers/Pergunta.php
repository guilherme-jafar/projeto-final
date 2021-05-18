<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Pergunta extends Controller
{
    function show(Request $request){

//        return view('/prof/Disciplina', ['topico' => $topico]);

        $pergunta =  \App\Models\pergunta::find($request->id);


        if (!empty($pergunta)) {
            return view('/prof/pergunta', ['pergunta' => $pergunta]);
        } else {
            return view('/prof/pergunta', ['pergunta' => []]);
        }


    }

    function getRespostas(Request $request){

        $respostas = DB::select('SELECT * FROM respostas WHERE perguntas_id =:id', ['id' => $request->id]);
       // dd($respostas);
        if (!empty($respostas)){
            return response()->json([
                'message' => $respostas,
            ]);
        }else{
            return response()->json([
                'message' =>[],
            ]);
        }

    }

    function destroy(Request $request){


        DB::statement('call deletePergunta(?)', [$request->id]);
//        $pergunta =  \App\Models\pergunta::find($request->id_topico);
        $pergunta = DB::select('SELECT *
            FROM topicos t ,perguntas p
            WHERE t.id=p.topicos_id
            AND t.id=:id', ['id' => $request->id_topico]);

        if (!empty($pergunta)) {
            return response()->json([
                'message' => $pergunta,
            ]);
        } else {
            return response()->json([
                'message' => [],
            ]);
        }
    }
}
