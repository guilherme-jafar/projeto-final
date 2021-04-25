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


    function insertQuestion(Request $request){

        $id=uniqid();
        $topico=$request->topico;
        $pergunta=$request->pergunta;
        $tempo=$request->tempo;
        $tipo=$request->tipo;
        $pontos=$request->pontos;
        $nomeFile=null;

        try {





        switch ($pontos){
            case "Normal":
               $p=1000;
               break;
            case "Pontos duplos":
                $p=2000;
                break;
            case "Sem pontos":
                $p=0;
                break;
        }
        if ($tipo=="multiple"){
            $question=json_decode($request->array);
            $resposta=$request->resposta;

            DB::insert('insert into perguntas (id, enunciado,tempo,tipo,valor,topicos_id) values (?,?,?,?,?,?)'
                , [$id,$pergunta,$tempo,$tipo,$p,$topico]);

//            dd($question);
            for( $i=0;$i<count($question);$i++){
                $idRes=time().uniqid();
                if ($question[$i]==$resposta) {
                    DB::insert('insert into respostas (id,resposta,resultado,perguntas_id) values (?,?,?,?)'
                        , [$idRes, $question[$i], 1, $id]);

                }else{
                    DB::insert('insert into respostas (id,resposta,resultado,perguntas_id) values (?,?,?,?)'
                        , [$idRes, $question[$i], 0, $id]);
                }

            }
        }else if($tipo=="true/false"){
            DB::insert('insert into perguntas (id, enunciado,tempo,tipo,valor,topicos_id) values (?,?,?,?,?,?)'
                , [$id,$pergunta,$tempo,$tipo,$p,$topico]);
            $idRes=time().uniqid();
            DB::insert('insert into respostas (id,resposta,resultado,perguntas_id) values (?,?,?,?)'
                , [$idRes, $request->resposta, 1, $id]);


        }

            if ($request->hasFile('file') != null ){
                $nomeFile=uniqid().".".$request->file->getClientOriginalExtension();
                $idMulti=uniqid().time();
                $request->file->move(public_path('.\images\Pergunta\Multimedia'),$nomeFile );
                DB::insert('insert into multimedia (id, link,perguntas_id) values (?,?,?)'
                    , [$idMulti,$nomeFile,$id]);
            }else{
                $idMulti=uniqid().time();
                DB::insert('insert into multimedia (id,perguntas_id) values (?,?)'
                    , [$idMulti,$id]);

            }


            return response()->json([
                'message' => 'sucesso'
            ]);


        }catch (\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ]);
        };
    }


    function getPerguntas(Request $request){

       $res= DB::select('SELECT *
FROM topicos t ,perguntas p
WHERE t.id=p.topicos_id
AND t.id=:id',['id'=>$request->id]);


        if (!empty($res)){
            return response()->json([
                'message' => $res,
            ]);
        }else{
            return response()->json([
                'message' => [],
            ]);
        }


    }
}
