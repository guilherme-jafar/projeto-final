<?php

namespace App\Http\Controllers;

use App\Models\sessao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Quizz extends Controller
{

    function listQuizz(Request $request)
    {

        $Quizz = DB::table('quizz')
            ->where('disciplina_id', '=', session('disciplina')['id'])
            ->get();



        if (!empty($Quizz)) {
            return response()->json([
                'message' => $Quizz
            ]);


        } else {
            return response()->json([
                'message' => []
            ]);
        }
    }

    function insertQuizz(Request $request)
    {

        $topicos = json_decode($request->array);
        $numQuestion = $request->nPerguntas;
        $comand = "";
        $stack = array();
        $id = uniqid();
        try {
            for ($i = 0; $i < count($topicos); $i++) {

                if ($i == 0) {
                    $comand .= "WHERE p.topicos_id=t.id AND t.id='" . $topicos[$i] . "'";
                } else {
                    $comand .= " OR t.id='" . $topicos[$i] . "' AND p.topicos_id=t.id ";
                }
            }
            $res = DB::select("SELECT p.id AS \"pergunta_id\", p.enunciado,p.topicos_id,t.disciplina_id FROM perguntas p, topicos t " . $comand);


            if (count($res) >= $numQuestion) {
                DB::insert('insert into quizz (id, nome ,tipo,numeroperguntas,disciplina_id,Descricao,visivel) values (?,?,?,?,?,?,?)'
                    , [$id, $request->titulo, $request->realtime, $numQuestion, $request->id, $request->descricao, $request->visible]);

                for ($i = 0; $i < $numQuestion; $i++) {
                    while (true) {
                        $index = rand(0, count($res) - 1);

                        if (!in_array($index, $stack)) {
                            break;
                        }
                    }
                    array_push($stack, $index);

                    DB::insert('insert into pergunta_quizz (id,enuncia,id_pergunta,quizz_id,topico_id, PergIndex) value (?,?,?,?,?,?)',
                                [uniqid(),$res[$index]->enunciado, $res[$index]->pergunta_id, $id, $res[$index]->topicos_id,$i+1]);


                }
            } else {
                return response()->json([
                    'message' => "numero de perguntas invalido"
                ]);
            }


            return response()->json([
                'message' => "sucesso"
            ]);
        } catch (Exception $e) {

            return response()->json([
                'message' => "erro"
            ]);
        }

    }


    function EnterQuizz(Request $request)
    {

        $id = $request->token;
        $session=$request->sessionID;



        $quizz = DB::select('SELECT p.id ,p.enunciado ,p.tempo ,p.valor , p.tipo , q.numeroperguntas ,q.nome,q.tipo AS "quizzTipo",m.link
                                   FROM quizz q, pergunta_quizz pq, perguntas p,multimedia m
                                   WHERE q.id = pq.quizz_id
                                   AND p.id = pq.id_pergunta
                                   AND m.perguntas_id=p.id
                                   AND q.id  = :id', ['id' => $id]);

                $check=DB::select('select * from sessao where id = :id',['id' => $session]);


        if (!empty($quizz)) {
            if (empty($check)) {
                DB::insert('insert into sessao (id, nomequizz ,tipo,quizz_id,iduser,tipoUser) values (?,?,?,?,?,?)'
                    , [$session, $quizz[0]->nome, $quizz[0]->quizzTipo, $id, session('utilizador')['id'], session('utilizador')['tipo']]);

                return view('/quizz/perguntaQuizz', ['quizz' => $quizz, 'session' => $session]);

            }
            else {
                return view('/quizz/perguntaQuizz', ['quizz' => $quizz, 'session' => $session]);
            }

        }

        else{

            return view('/welcome');
        }


    }


    function getRespostas(Request $request){

        $id = $request->id;

        $res= DB::select('SELECT *
                                FROM respostas r
                                WHERE r.perguntas_id= :id', ['id' => $id]);

        if (!empty($res)) {

            return response()->json([
                'message' => $res
            ]);

        }else{
            return response()->json([
                'message' => 'erro'
            ]);

        }
    }

    function setResposta(Request $request){


        var_dump($request->resposta);

        DB::insert('insert into respostas_quizz (id, resposta ,resultado,tipo,sessao_id,aluno_utilizador_id,pergunta_id) values (?,?,?,?,?,?,?)'
            , [uniqid(), $request->resposta, $request->resultado, $request->tipo, $request->sessioId, session('utilizador')['id'],$request->id]);


    }

    function EndQuizz(Request $request){

      $query=  DB::select('SELECT s.nomequizz AS "nome" , SUM(rq.resultado) AS "res"
FROM sessao s ,respostas_quizz rq ,utilizador u
WHERE s.id= :sessionId
AND s.id=rq.sessao_id
AND  u.id= :id
GROUP BY s.nomequizz',['id' => session('utilizador')['id'] ,'sessionId'=> $request->sessionId]);

        return view('/quizz/EndQuizz', ['res' =>$query[0]->res ,'nome'=>$query[0]->nome]);

    }


    function CreateWaitRoom(Request $request)
    {


        $id = $request->id;
        $session=uniqid();

        $quizz = DB::select('SELECT p.id ,p.enunciado ,p.tempo ,p.valor , p.tipo ,q.numeroperguntas, q.nome ,q.tipo AS "quizzTipo", m.link
                                   FROM quizz q, pergunta_quizz pq, perguntas p,multimedia m
                                   WHERE q.id = pq.quizz_id
                                   AND p.id = pq.id_pergunta
                                   AND m.perguntas_id=p.id
                                   AND q.id  = :id', ['id' => $id]);


        Cache::put('quizz',$quizz);

        if (!empty($quizz)) {
                    session()->put('sessao',["id"=>$session]);
//                DB::insert('insert into sessao (id, nomequizz ,tipo,quizz_id,iduser,tipoUser) values (?,?,?,?,?,?)'
//                    , [$session, $quizz[0]->nome, $quizz[0]->quizzTipo, $id, session('utilizador')['id'], session('utilizador')['tipo']]);
                broadcast(new \App\Events\WaitRoom(0,$session))->toOthers();

                return view('/quizz/waitRoom', ['quizz' => $quizz[0], 'session' => $session]);


        }else{
            return view('/');
        }
    }

    function EnterWaitRoom(Request $request)
    {
        $id = $request->id;
        $session = uniqid();

        $quizz = DB::select('SELECT p.id ,p.enunciado ,p.tempo ,p.valor , p.tipo ,q.numeroperguntas, q.nome ,q.tipo AS "quizzTipo", m.link
                                   FROM quizz q, pergunta_quizz pq, perguntas p,multimedia m
                                   WHERE q.id = pq.quizz_id
                                   AND p.id = pq.id_pergunta
                                   AND m.perguntas_id=p.id
                                   AND q.id  = :id', ['id' => $id]);

        Cache::put('quizz', $quizz);

        if (!empty($quizz)) {

            session()->put('sessao', ["id" => $session]);
            broadcast(new \App\Events\WaitRoom(0,$session))->toOthers();
//                DB::insert('insert into sessao (id, nomequizz ,tipo,quizz_id,iduser,tipoUser) values (?,?,?,?,?,?)'
//                    , [$session, $quizz[0]->nome, $quizz[0]->quizzTipo, $id, session('utilizador')['id'], session('utilizador')['tipo']]);
            //broadcast(new \App\Events\WaitRoom(0, $session))->toOthers();
            return view('/quizz/waitRoomAluno', ['quizz' => $quizz[0], 'session' => $session]);

        } else {
            return view('/');
        }

    }

}
