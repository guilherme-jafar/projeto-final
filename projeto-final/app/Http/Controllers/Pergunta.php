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
        $respostas['multimedia'] = DB::select('SELECT * FROM multimedia WHERE perguntas_id =:id', ['id' => $request->id]);

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

    function editar(Request $request){
        dd($request);

        $pergunta = $request->pergunta;
        $tempo = $request->tempo;
        $tipo = $request->tipo;
        $pontos = $request->pontos;
        $nomeFile = null;

        try {

            switch ($pontos) {
                case "Normal":
                    $p = 1000;
                    break;
                case "Pontos duplos":
                    $p = 2000;
                    break;
                case "Sem pontos":
                    $p = 0;
                    break;
            }
            if ($tipo == "multiple") {

                $question = json_decode($request->array);
                $resposta = $request->resposta;




                for ($i = 0; $i < count($question); $i++) {

                    if ($question[$i] == $resposta) {


                    } else {

                    }

                }
            } else if ($tipo == "true/false") {

                DB::insert('insert into perguntas (id, enunciado,tempo,tipo,valor,topicos_id) values (?,?,?,?,?,?)'
                    , [$id, $pergunta, $tempo, $tipo, $p, $topico]);




            } else if ($tipo == "multiple-select") {
                $question = json_decode($request->array);
                $resposta = json_decode($request->respostas);


                for ($i = 0; $i < count($question); $i++) {



                    var_dump(in_array("re" . ($i + 1) . $topico, $resposta));

                    var_dump("re" . ($i + 1) . $topico . "/n");
                    if (in_array("re" . ($i + 1) . $topico, $resposta)) {


                    } else {

                    }

                }


            }


            if ($request->hasFile('file') != null) {
                $nomeFile = uniqid() . "." . $request->file->getClientOriginalExtension();

                $request->file->move(public_path('.\images\Pergunta\Multimedia'), $nomeFile);

            } else {



            }


            return response()->json([
                'message' => 'sucesso'
            ]);


        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        };

    }

    function destroy(Request $request){

        try{

            $perguntas_quizz = DB::select('SELECT * FROM pergunta_quizz WHERE id_pergunta=:id', ['id' => $request->id]);
            $respostas_quizz = DB::select('SELECT * FROM respostas_quizz WHERE pergunta_id=:id', ['id' => $request->id]);

            if (empty($respostas_quizz) && empty($perguntas_quizz)){
                DB::statement('call deletePergunta(?)', [$request->id]);

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
            }else{
                return response()->json([
                    'message' => 'erro',
                ]);
            }



        }catch (\Illuminate\Database\QueryException $ex) {

            return response()->json([
                'message' => 'erro',
            ]);
        } catch (\ErrorException $e) {
            return response()->json([
                'message' => 'erro2',
            ]);
        }



    }
}
