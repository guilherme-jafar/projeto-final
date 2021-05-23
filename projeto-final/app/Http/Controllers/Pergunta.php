<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Pergunta extends Controller
{
    function show(Request $request)
    {

//        return view('/prof/Disciplina', ['topico' => $topico]);

        $pergunta = \App\Models\pergunta::find($request->id);


        if (!empty($pergunta)) {
            return view('/prof/pergunta', ['pergunta' => $pergunta]);
        } else {
            return view('/prof/pergunta', ['pergunta' => []]);
        }


    }

    function getRespostas(Request $request)
    {

        $respostas = DB::select('SELECT * FROM respostas WHERE perguntas_id =:id', ['id' => $request->id]);
//        $respostas['multimedia'] = DB::select('SELECT * FROM multimedia WHERE perguntas_id =:id', ['id' => $request->id]);

        if (!empty($respostas)) {
            return response()->json([
                'message' => $respostas,
            ]);
        } else {
            return response()->json([
                'message' => [],
            ]);
        }

    }

    function getMultimedia(Request $request)
    {
        $multimedia = DB::select('SELECT * FROM multimedia WHERE perguntas_id =:id', ['id' => $request->id]);

        if (!empty($multimedia)) {
            return response()->json([
                'message' => $multimedia,
            ]);
        } else {
            return response()->json([
                'message' => [],
            ]);
        }
    }

    function editar(Request $request)
    {


        $pergunta = $request->pergunta;
        $tempo = $request->tempo;
        $tipo = $request->tipo;
        $pontos = $request->pontos;
        $nomeFile = null;
        $respostasId = json_decode($request->respostasId);
        $tipoInicial = $request->tipoInicial;
//        $topico = $request->topicoId;
        $multimedia = json_decode($request->multimedia);
        $youtubeLink = $request->file;

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


            if ($tipoInicial !== $tipo){


                DB::delete('delete from respostas where perguntas_id=:id', ['id' => $request->id]);
                $id = $request->id;
                if ($tipo == "multiple") {

                    $question = json_decode($request->array);
                    $resposta = $request->resposta;



                    for ($i = 0; $i < count($question); $i++) {
                        $idRes = time() . uniqid();
                        if ($question[$i] == $resposta) {
                            DB::insert('insert into respostas (id,resposta,resultado,perguntas_id) values (?,?,?,?)'
                                , [$idRes, $question[$i], 1, $id]);

                        } else {
                            DB::insert('insert into respostas (id,resposta,resultado,perguntas_id) values (?,?,?,?)'
                                , [$idRes, $question[$i], 0, $id]);
                        }

                    }
                } else if ($tipo == "true/false") {


                    $idRes = time() . uniqid();
                    DB::insert('insert into respostas (id,resposta,resultado,perguntas_id) values (?,?,?,?)'
                        , [$idRes, $request->resposta, 1, $id]);


                } else if ($tipo == "multiple-select") {
                    $question = json_decode($request->array);
                    $resposta = json_decode($request->respostas);


                    for ($i = 0; $i < count($question); $i++) {
                        $idRes = time() . uniqid();


                        if (in_array("rem" . ($i + 1) . $request->id, $resposta)) {
                            DB::insert('insert into respostas (id,resposta,resultado,perguntas_id) values (?,?,?,?)'
                                , [$idRes, $question[$i], 1, $id]);

                        } else {
                            DB::insert('insert into respostas (id,resposta,resultado,perguntas_id) values (?,?,?,?)'
                                , [$idRes, $question[$i], 0, $id]);
                        }

                    }


                }

            }else{
                if ($tipo == "multiple") {

                    $question = json_decode($request->array);
                    $resposta = $request->resposta;


                    if (count($respostasId) == count($question)) {
                        for ($i = 0; $i < count($respostasId); $i++) {

                            if ($question[$i] == $resposta) {
                                DB::table('respostas')
                                    ->where('id', '=', $respostasId[$i]->id)
                                    ->update(['resposta' => $question[$i], 'resultado' => 1]);

                            } else {
                                DB::table('respostas')
                                    ->where('id', '=', $respostasId[$i]->id)
                                    ->update(['resposta' => $question[$i], 'resultado' => 0]);
                            }

                        }
                    } elseif (count($respostasId) > count($question)) {

                        for ($i = 0; $i < count($respostasId); $i++) {

                            if ($i < count($question)){

                                if ($question[$i] == $resposta) {
                                    DB::table('respostas')
                                        ->where('id', '=', $respostasId[$i]->id)
                                        ->update(['resposta' => $question[$i], 'resultado' => 1]);

                                } else {
                                    DB::table('respostas')
                                        ->where('id', '=', $respostasId[$i]->id)
                                        ->update(['resposta' => $question[$i], 'resultado' => 0]);
                                }

                            }else{
                                DB::table('respostas')
                                    ->where('id', '=', $respostasId[$i]->id)
                                    ->update(['resposta' => "", 'resultado' => 0]);
                            }



                        }

                    }elseif (count($respostasId) < count($question)){


                        for ($i = 0; $i < count($question); $i++) {

                            if ($i < count($respostasId)){

                                if ($question[$i] == $resposta) {
                                    DB::table('respostas')
                                        ->where('id', '=', $respostasId[$i]->id)
                                        ->update(['resposta' => $question[$i], 'resultado' => 1]);

                                } else {
                                    DB::table('respostas')
                                        ->where('id', '=', $respostasId[$i]->id)
                                        ->update(['resposta' => $question[$i], 'resultado' => 0]);
                                }

                            }else{
                                $idRes = time() . uniqid();
                                if ($question[$i] == $resposta) {
                                    DB::insert('insert into respostas (id,resposta,resultado,perguntas_id) values (?,?,?,?)'
                                        , [$idRes, $question[$i], 1, $request->id]);

                                } else {
                                    DB::insert('insert into respostas (id,resposta,resultado,perguntas_id) values (?,?,?,?)'
                                        , [$idRes, $question[$i], 0, $request->id]);
                                }
                            }



                        }

                    }





                } else if ($tipo == "true/false") {



                    DB::table('respostas')
                        ->where('id', '=', $respostasId[0]->id)
                        ->update(['resposta' => $request->resposta]);



                } else if ($tipo == "multiple-select") {
                    $question = json_decode($request->array);
                    $resposta = json_decode($request->respostas);


                    if (count($respostasId) == count($question)) {
                        for ($i = 0; $i < count($question); $i++) {

                            if (in_array("rem" . ($i + 1) . $request->id, $resposta)){
                                DB::table('respostas')
                                    ->where('id', '=', $respostasId[$i]->id)
                                    ->update(['resposta' => $question[$i], 'resultado' => 1]);

                            } else {
                                DB::table('respostas')
                                    ->where('id', '=', $respostasId[$i]->id)
                                    ->update(['resposta' => $question[$i], 'resultado' => 0]);
                            }
                        }

                    }else if(count($respostasId) > count($question)){
                        for ($i = 0; $i < count($respostasId); $i++) {

                            if ($i < count($question)){

                                if (in_array("rem" . ($i + 1) . $request->id, $resposta)) {
                                    DB::table('respostas')
                                        ->where('id', '=', $respostasId[$i]->id)
                                        ->update(['resposta' => $question[$i], 'resultado' => 1]);

                                } else {
                                    DB::table('respostas')
                                        ->where('id', '=', $respostasId[$i]->id)
                                        ->update(['resposta' => $question[$i], 'resultado' => 0]);
                                }

                            }else{
                                DB::table('respostas')
                                    ->where('id', '=', $respostasId[$i]->id)
                                    ->update(['resposta' => "", 'resultado' => 0]);
                            }



                        }
                    }elseif (count($respostasId) < count($question)) {
//                    dd($question, $respostasId);

                        for ($i = 0; $i < count($question); $i++) {

                            if ($i < count($respostasId)) {

                                if (in_array("rem" . ($i + 1) . $request->id, $resposta)) {
                                    DB::table('respostas')
                                        ->where('id', '=', $respostasId[$i]->id)
                                        ->update(['resposta' => $question[$i], 'resultado' => 1]);

                                } else {
                                    DB::table('respostas')
                                        ->where('id', '=', $respostasId[$i]->id)
                                        ->update(['resposta' => $question[$i], 'resultado' => 0]);
                                }

                            } else {
                                $idRes = time() . uniqid();
                                if (in_array("rem" . ($i + 1) . $request->id, $resposta)) {
                                    DB::insert('insert into respostas (id,resposta,resultado,perguntas_id) values (?,?,?,?)'
                                        , [$idRes, $question[$i], 1, $request->id]);

                                } else {
                                    DB::insert('insert into respostas (id,resposta,resultado,perguntas_id) values (?,?,?,?)'
                                        , [$idRes, $question[$i], 0, $request->id]);
                                }
                            }


                        }

                    }


                }
            }


            if ($request->hasFile('file') != null) {
                $nomeFile = uniqid() . "." . $request->file->getClientOriginalExtension();
                $idMulti = uniqid() . time();
                $request->file->move(public_path('.\images\Pergunta\Multimedia'), $nomeFile);

                DB::table('multimedia')
                    ->where('id', '=', $multimedia[0]->id)
                    ->update(['link' => $nomeFile]);



            }else if ($youtubeLink != null){
                DB::table('multimedia')
                    ->where('id', '=', $multimedia[0]->id)
                    ->update(['link' => $youtubeLink]);
            }

            DB::table('perguntas')
                ->where('id', '=', $request->id)
                ->update(['tempo' => $tempo, 'tipo' => $request->tipo, 'enunciado' => $pergunta, 'valor' => $p]);
            return response()->json([
                'message' => 'sucesso'
            ]);


        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        };

    }

    function destroy(Request $request)
    {

        try {

            $perguntas_quizz = DB::select('SELECT * FROM pergunta_quizz WHERE id_pergunta=:id', ['id' => $request->id]);
            $respostas_quizz = DB::select('SELECT * FROM respostas_quizz WHERE pergunta_id=:id', ['id' => $request->id]);

            if (empty($respostas_quizz) && empty($perguntas_quizz)) {
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
            } else {
                return response()->json([
                    'message' => 'erro',
                ]);
            }


        } catch (\Illuminate\Database\QueryException $ex) {

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
