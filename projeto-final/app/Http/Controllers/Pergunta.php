<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Pergunta extends Controller
{
    function show(Request $request){

//        return view('/prof/Disciplina', ['topico' => $topico]);

        //$pergunta =  \App\Models\pergunta::find($request->id);

        $pergunta = DB::select('SELECT * FROM topicos t ,perguntas p WHERE t.id=p.topicos_id AND t.id=:id', ['id' => $request->id]);
//        $pergunta = DB::table('topicos')
//            ->join('perguntas', 'perguntas.topicos_id', '=', 'topicos.id')
//            ->where("topicos.id", "=" ,  $request->id)
//            ->paginate(5);
//        dd($pergunta);

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
