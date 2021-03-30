<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class topicos extends Controller
{

    function create(Request $request){


        $id=uniqid();
        $nome_topico = $request->input('topico');
        $descricao = $request->input('descricao');
        $disciplina=$request->id;

        $insert_Topicos = DB::insert('insert into topicos (id, nome,descricao,disciplina_id) values (?,?,?,?)'
            , [$id, $nome_topico,$descricao,$disciplina]);


        $topicos= DB::select('select * FROM topicos WHERE  disciplina_id = :id', ['id' => $disciplina ]);


        if ($insert_Topicos){
            return response()->json([
                'message' => $topicos,
            ]);
        }else{
            return response()->json([
                'message' => 'erro',
            ]);
        }

    }
}
