<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Quizz extends Controller
{

    function listQuizz(Request $request){


        $Quizz=DB::table('quizz')
            ->where('disciplina_id','=',session('disciplina')['id'])
            ->get();

        if (!empty($Quizz)) {
            return response()->json([
                'message' => $Quizz
            ]);


        }else{
            return response()->json([
                'message' => []
            ]);
        }
    }

    function insertQuizz(Request $request){

        $topicos=json_decode($request->array);
        $numQuestion=$request->nPerguntas;
        $comand="";
        $stack = array();
        $id=uniqid();
        try {
            for ($i = 0; $i < count($topicos); $i++) {

                if ($i == 0) {
                    $comand .= "WHERE p.topicos_id=t.id AND t.id='" . $topicos[$i] . "'";
                } else {
                    $comand .= " OR t.id='" . $topicos[$i] . "' AND p.topicos_id=t.id ";
                }
            }
            $res = DB::select("SELECT p.id AS \"pergunta_id\", p.enunciado,p.topicos_id,t.disciplina_id FROM perguntas p, topicos t " . $comand);



            if (count($res)>=$numQuestion){
                DB::insert('insert into quizz (id, nome ,tipo,numeroperguntas,disciplina_id,Descricao,visivel) values (?,?,?,?,?,?,?)'
                    , [$id, $request->titulo, $request->realtime, $numQuestion, $request->id, $request->descricao, $request->visible]);

                for ($i = 0; $i < $numQuestion; $i++) {
                while(true) {
                    $index = rand(0, count($res) - 1);

                    if (!in_array($index, $stack)) {
                        break;
                    }
                }
                array_push($stack,$index);

                DB::insert('insert into pergunta_quizz (id, enuncia ,id_pergunta,quizz_id,topico_id) values (?,?,?,?,?)'
                    , [uniqid(), $res[$index]->enunciado, $res[$index]->pergunta_id, $id, $res[$index]->topicos_id]);


            }}
            else{
                return response()->json([
                    'message' => "numero de perguntas invalido"
                ]);
            }


            return response()->json([
                'message' => "sucesso"
            ]);
        }catch (Exception $e){

            return response()->json([
                'message' => "erro"
            ]);
        }

    }



}
