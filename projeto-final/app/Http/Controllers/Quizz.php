<?php

namespace App\Http\Controllers;

use App\Events\AnswerQuestionStudent;
use App\Events\QuizzQuestion;
use App\Events\WaitRoom;
use App\Models\sessao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;


class Quizz extends Controller
{

    function listQuizz(Request $request)
    {

        $Quizz = DB::table('quizz')
            ->where('disciplina_id', '=', session('disciplina')['id'])
            ->paginate(5);
        // dd($Quizz[0]);


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

    function listQuizzTopico(Request $request)
    {

        $topicoQuizz = DB::select('SELECT t.id FROM topicos t, topicos_quizz tq
                                WHERE t.id = tq.topicos_id
                                AND tq.quizz_id =:id', ['id' => $request->id]);


//        dd($topicoQuizz);

        if (!empty($topicoQuizz)) {
            return response()->json([
                'message' => $topicoQuizz
            ]);


        } else {
            return response()->json([
                'message' => []
            ]);
        }
    }

    function editar(Request $request)
    {

        // dd($request);
        $topicos = json_decode($request->array);
        $numQuestion = $request->nPerguntas;
        $comand = "";
        $stack = array();
        $id = $request->id;
        $numQuestionAntigas = $request->numeroPerguntasAntigo;
        $editarPerguntas = false;
        try {

            DB::table('quizz')
                ->where('id', '=', $id)
                ->update(['nome' => $request->titulo, 'tipo' => $request->realtime, 'numeroperguntas' => $numQuestion, 'Descricao' => $request->descricao, 'visivel' => $request->visible, 'vale_pontos' => $request->pontos]);


            $topicoQuizz = DB::select('SELECT t.id FROM topicos t, topicos_quizz tq
                                WHERE t.id = tq.topicos_id
                                AND tq.quizz_id =:id', ['id' => $id]);


            if (count($topicos) == count($topicoQuizz)) {
                $mesmoTopico = 0;
                for ($i = 0; $i < count($topicos); $i++) {

                    if (in_array($topicoQuizz[$i]->id, $topicos)) {
                        $mesmoTopico++;
                    }
                }

                if ($mesmoTopico != count($topicoQuizz)) {

                    $editarPerguntas = true;

                } elseif ($numQuestionAntigas != $numQuestion) {

                    $editarPerguntas = true;

                } else {
                    return response()->json([
                        'message' => "sucesso"
                    ]);
                }
            } elseif (count($topicos) != count($topicoQuizz)) {
                $editarPerguntas = true;
            }


            if ($editarPerguntas) {
                for ($i = 0; $i < count($topicos); $i++) {

                    if ($i == 0) {
                        $comand .= "WHERE p.topicos_id=t.id AND t.id='" . $topicos[$i] . "'";
                    } else {
                        $comand .= " OR t.id='" . $topicos[$i] . "' AND p.topicos_id=t.id ";
                    }
                }
                $res = DB::select("SELECT p.id AS \"pergunta_id\", p.enunciado,p.topicos_id,t.disciplina_id FROM perguntas p, topicos t " . $comand);

                DB::delete('delete from pergunta_quizz where quizz_id=:id', ['id' => $id]);
                DB::delete('delete from topicos_quizz where quizz_id=:id', ['id' => $id]);

                if (count($res) >= $numQuestion) {

                    for ($i = 0; $i < $numQuestion; $i++) {
                        while (true) {
                            $index = rand(0, count($res) - 1);

                            if (!in_array($index, $stack)) {
                                break;
                            }
                        }
                        array_push($stack, $index);

                        DB::insert('insert into pergunta_quizz (id,enuncia,id_pergunta,quizz_id,topico_id, PergIndex) value (?,?,?,?,?,?)',
                            [uniqid(), $res[$index]->enunciado, $res[$index]->pergunta_id, $id, $res[$index]->topicos_id, $i + 1]);


                    }
                } else {
                    return response()->json([
                        'message' => "numero de perguntas invalido"
                    ]);
                }

                for ($i = 0; $i < count($topicos); $i++) {
                    DB::insert('insert into topicos_quizz (quizz_id, topicos_id) values(?,?)', [$id, $topicos[$i]]);
                }

                return response()->json([
                    'message' => "sucesso"
                ]);
            }


        } catch (Exception $e) {

            return response()->json([
                'message' => "erro"
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
                DB::insert('insert into quizz (id, nome ,tipo,numeroperguntas,disciplina_id,Descricao,visivel, vale_pontos,tentativas) values (?,?,?,?,?,?,?,?,?)'
                    , [$id, $request->titulo, $request->realtime, $numQuestion, $request->id, $request->descricao, $request->visible, $request->pontos, $request->numeroAvaliaçoes]);

                for ($i = 0; $i < $numQuestion; $i++) {
                    while (true) {
                        $index = rand(0, count($res) - 1);

                        if (!in_array($index, $stack)) {
                            break;
                        }
                    }
                    array_push($stack, $index);

                    DB::insert('insert into pergunta_quizz (id,enuncia,id_pergunta,quizz_id,topico_id, PergIndex) value (?,?,?,?,?,?)',
                        [uniqid(), $res[$index]->enunciado, $res[$index]->pergunta_id, $id, $res[$index]->topicos_id, $i + 1]);


                }
            } else {
                return response()->json([
                    'message' => "numero de perguntas invalido"
                ]);
            }

            for ($i = 0; $i < count($topicos); $i++) {
                DB::insert('insert into topicos_quizz (quizz_id, topicos_id) values(?,?)', [$id, $topicos[$i]]);
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
        $session = $request->sessionID;


        $quizz = DB::select('SELECT p.id ,p.enunciado ,p.tempo ,p.valor , p.tipo , q.numeroperguntas ,q.nome,q.tipo AS "quizzTipo",m.link
                                   FROM quizz q, pergunta_quizz pq, perguntas p,multimedia m
                                   WHERE q.id = pq.quizz_id
                                   AND p.id = pq.id_pergunta
                                   AND m.perguntas_id=p.id
                                   AND q.id  = :id', ['id' => $id]);

        $check = DB::select('select * from sessao where id = :id', ['id' => $session]);


        if (!empty($quizz)) {
            if (empty($check)) {
                DB::insert('insert into sessao (id, nomequizz ,tipo,quizz_id,iduser,tipoUser) values (?,?,?,?,?,?)'
                    , [$session, $quizz[0]->nome, $quizz[0]->quizzTipo, $id, session('utilizador')['id'], session('utilizador')['tipo']]);

                return view('/quizz/perguntaQuizz', ['quizz' => $quizz, 'session' => $session]);

            } else {
                return view('/quizz/perguntaQuizz', ['quizz' => $quizz, 'session' => $session]);
            }

        } else {

            return view('/welcome');
        }


    }


    function getRespostas(Request $request)
    {

        $id = $request->id;

        $res = DB::select('SELECT *
                                FROM respostas r
                                WHERE r.perguntas_id= :id', ['id' => $id]);

        if (!empty($res)) {

            return response()->json([
                'message' => $res
            ]);

        } else {
            return response()->json([
                'message' => 'erro'
            ]);

        }
    }

    function setResposta(Request $request)
    {


        var_dump($request->resposta);

        DB::insert('insert into respostas_quizz (id, resposta ,resultado,tipo,sessao_id,aluno_utilizador_id,pergunta_id) values (?,?,?,?,?,?,?)'
            , [uniqid(), $request->resposta, $request->resultado, $request->tipo, $request->sessioId, session('utilizador')['id'], $request->id]);


    }

    function EndQuizz(Request $request)
    {

        $query = DB::select('SELECT SUM(rq.resultado) AS "res" ,s.nomequizz AS "nome" , s.quizz_id AS "id"
FROM sessao s ,respostas_quizz rq ,utilizador u
WHERE s.id= :sessionId
AND s.id=rq.sessao_id
AND  u.id= :id
GROUP BY s.quizz_id ,s.nomequizz', ['id' => session('utilizador')['id'], 'sessionId' => $request->sessionId]);

        DB::insert('insert into historico (id, disciplina,quizz,nota,idquizz,tipo,disciplina_id,sessaoId) values(?,?,?,?,?,?,?,?)'
            , [uniqid(), session('disciplina')['nome'], $query[0]->nome, $query[0]->res,
                $query[0]->id, session('utilizador')['tipo'], session('disciplina')['id'], $request->sessionId]);

        DB::table('disciplina_aluno')->where('aluno_utilizador_id', '=', ['id' => session('utilizador')['id']])->increment('pontos', $query[0]->res);

        return view('/quizz/EndQuizz', ['res' => $query[0]->res, 'nome' => $query[0]->nome]);

    }

    function CreateWaitRoom(Request $request)
    {


        $id = $request->id;
        $session = uniqid();

        $quizz = DB::select('SELECT p.id ,p.enunciado ,p.tempo ,p.valor , p.tipo ,q.numeroperguntas, q.nome ,q.tipo AS "quizzTipo", m.link
                                   FROM quizz q, pergunta_quizz pq, perguntas p,multimedia m
                                   WHERE q.id = pq.quizz_id
                                   AND p.id = pq.id_pergunta
                                   AND m.perguntas_id=p.id
                                   AND q.id  = :id', ['id' => $id]);


        if (!empty($quizz)) {

            if (empty(session()->get('sessao'))) {
                session()->put('sessao', ["id" => $session, "nomeQuizz" => $quizz[0]->nome, 'idQuizz' => $id, 'type' => 'master']);
                DB::insert('insert into sessao (id, nomequizz ,tipo,quizz_id,iduser,tipoUser, masterActive) values (?,?,?,?,?,?,?)'
                    , [$session, $quizz[0]->nome, $quizz[0]->quizzTipo, $id, session('utilizador')['id'], session('utilizador')['tipo'], 1]);


                broadcast(new WaitRoom(session('utilizador')['nome'], $session, 'master', session('utilizador')['id']))->toOthers();

                return redirect('/InsideRoomProf');
            } else {

                broadcast(new WaitRoom(session('utilizador')['nome'], session('sessao')['id'], 'master', session('utilizador')['id']))->toOthers();
                return redirect('/InsideRoomProf');
            }


        }

        return view('/welcome');

    }

    function EnterWaitRoom(Request $request)
    {
        $id = $request->id;
        $quizzId = $request->quizzId;
        $session = uniqid();
        $quizz = [];
        $Cheek = [];

        $quizz = DB::select('SELECT p.id ,p.enunciado ,p.tempo ,p.valor , p.tipo ,q.numeroperguntas, q.nome ,q.tipo AS "quizzTipo", m.link,tentativas
                                   FROM quizz q, pergunta_quizz pq, perguntas p,multimedia m
                                   WHERE q.id = pq.quizz_id
                                   AND p.id = pq.id_pergunta
                                   AND m.perguntas_id=p.id
                                   AND q.id  = :id
                                   Order by pq.PergIndex', ['id' => $quizzId]);


        Cache::put('quizz', $quizz);

        $Cheek = DB::select('select id from sessao where id=:id and masterActive= 1 and quizz_id=:idQuizz', ['id' => $id, 'idQuizz' => $quizzId]);
        // dd($Cheek);

        if (!empty($quizz) && !empty($Cheek) && !isset(session('sessao')['check'])) {

            $users = DB::select('select id from sessao where sessaoMaster=:id  and quizz_id=:idQuizz', ['id' => $id, 'idQuizz' => $quizzId]);
            session()->put('sessao', ["id" => $session, "nomeQuizz" => $quizz[0]->nome, "check" => 'yes', 'users' => count($users), 'master' => $id, "quizz" => $quizzId, 'type' => 'student', 'tentativas' => $quizz[0]->tentativas]);

            DB::insert('insert into sessao (id, nomequizz ,tipo,quizz_id,iduser,tipoUser,sessaoMaster) values (?,?,?,?,?,?,?)'
                , [$session, $quizz[0]->nome, $quizz[0]->quizzTipo, $quizzId, session('utilizador')['id'], session('utilizador')['tipo'], $id]);
            event(new WaitRoom(session('utilizador')['nome'], $id, 'student', session('utilizador')['id']));

            return redirect('WaitRoomStudent/' . $session . '/' . $id);

        } else if (!empty($quizz) && !empty($Cheek)) {
            $users = DB::select('select id from sessao where sessaoMaster=:id  and quizz_id=:idQuizz', ['id' => $id, 'idQuizz' => $quizzId]);
            session('sessao')['users'] = count($users);
            event(new WaitRoom(session('utilizador')['nome'], $id, 'student', session('utilizador')['id']));
            return redirect('WaitRoomStudent/' . $session . '/' . $id);
        } else {
            return view('/welcome');
        }


    }

    function leave()
    {
        if (isset(session()->get('sessao')['id'])) {

            if (session('sessao')['type'] == "master") {

                broadcast(new WaitRoom(session('utilizador')['nome'], session('sessao')['id'], 'leaveMaster', session('utilizador')['id']))->toOthers();
                DB::table('sessao')
                    ->where('id', session('sessao')['id'])
                    ->where('iduser', session('utilizador')['id'])
                    ->update(['masterActive' => 0]);

            }
            if (session('sessao')['type'] == "student") {

                DB::table('sessao')->where('id', '=', ['id' => session('sessao')['id']])->delete();
                broadcast(new WaitRoom(session('utilizador')['nome'], session('sessao')['master'], 'leavestudent', session('utilizador')['id']))->toOthers();
            }


        }
        session()->forget('sessao');

        return redirect('/login');
    }

    function startQuizz(Request $request)
    {

        DB::table('sessao')
            ->where('id', session('sessao')['id'])
            ->where('iduser', session('utilizador')['id'])
            ->update(['masterActive' => 0]);

        $quizz = DB::select('SELECT p.id as "pId" ,p.enunciado ,p.tempo ,p.valor , p.tipo ,q.numeroperguntas, q.nome ,q.tipo AS "quizzTipo", m.link ,pq.PergIndex
                                   FROM quizz q, pergunta_quizz pq, perguntas p,multimedia m
                                   WHERE q.id = pq.quizz_id
                                   AND p.id = pq.id_pergunta
                                   AND m.perguntas_id=p.id
                                   AND q.id  = :id
                                   Order by pq.PergIndex', ['id' => session('sessao')['idQuizz']]);

        $res = DB::select('select *
                                 from respostas r
                                 where r.perguntas_id=:id', ['id' => $quizz[0]->pId]);

        Cache::put('quizz', $quizz);

        broadcast(new QuizzQuestion(session('utilizador')['nome'], session('sessao')['id'], 'startQuizz', session('utilizador')['id'], $quizz[0], $res, []))->toOthers();

        return response()->json([
            'message' => count($quizz),
            'quizz'=>$quizz[0],
            'res'=>$res

        ]);
    }

    function setRespostaQuizz(Request $request)
    {


        var_dump($request->resposta);


        DB::insert('insert into respostas_quizz (id, resposta ,resultado,tipo,sessao_id,aluno_utilizador_id,pergunta_id) values (?,?,?,?,?,?,?)'
            , [uniqid(), $request->resposta, $request->resultado, $request->tipo, $request->sessioId, session('utilizador')['id'], $request->id]);


        broadcast(new AnswerQuestionStudent(session('utilizador')['nome'], session('sessao')['master'], 'NextQuestion', session('utilizador')['id'], $request->resultado, $request->resposta, $request->tipo))->toOthers();

    }

    function nextQuestionQuizz(Request $request)
    {

        $index = $request->index;
        $users = $request->users;
        $points = $request->points;

        $users = explode(',', $users);
        $points = explode(',', $points);
        $quizz = Cache::get('quizz');
        $newArray = [];
        if (count($users) > 5) {
            $users = array_chunk($users, 5);
            $points = array_chunk($points, 5);
        }

        for ($i = 0; $i < count($users); $i++) {
            $newArray += [$users[$i] => $points[$i]];

        }
        asort($newArray);
        $newArray = array_reverse($newArray);
        foreach ($quizz as $value) {

            if ($value->PergIndex == $index) {
                $res = DB::select('select *
                                 from respostas r
                                 where r.perguntas_id=:id', ['id' => $value->pId]);



                broadcast(new QuizzQuestion(session('utilizador')['nome'], session('sessao')['id'], 'NewQuestion', session('utilizador')['id'], $value, $res, $newArray));


            }


        }

    }

    function stopQuestionQuizz(Request $request)
    {
        broadcast(new QuizzQuestion(session('utilizador')['nome'], session('sessao')['id'], 'stop', session('utilizador')['id'], [], [], []))->toOthers();


    }

    function EndQuizzRealTime(Request $request)
    {
        $users = $request->users;
        $points = $request->points;
        $users = explode(',', $users);
        $points = explode(',', $points);

        $newArray = [];
        if (count($users) > 5) {
            $users = array_chunk($users, 5);
            $points = array_chunk($points, 5);
        }

        for ($i = 0; $i < count($users); $i++) {
            $newArray += [$users[$i] => $points[$i]];

        }
        asort($newArray);
        $newArray = array_reverse($newArray);

        if (session('utilizador')['tipo'] == 'prof') {
            broadcast(new QuizzQuestion(session('utilizador')['tipo'], session('sessao')['id'], 'EndQuizz', session('utilizador')['id'], [], [], $newArray))->toOthers();
        } else {
            broadcast(new QuizzQuestion(session('utilizador')['nome'], session('sessao')['id'], 'EndQuizzAluno', session('utilizador')['id'], [], [], $newArray))->toOthers();
        }
    }

    function CloseQuizzProf()
    {

        DB::insert('insert into historico (id, disciplina,quizz,idquizz,tipo,disciplina_id,sessaoId) values(?,?,?,?,?,?,?)'
            , [uniqid(), session('disciplina')['nome'], session('sessao')['nomeQuizz'],
                session('sessao')['idQuizz'], session('utilizador')['tipo'], session('disciplina')['id'], session('sessao')['id']]);


        session()->forget('sessao');
    }

    function CloseQuizzAluno(Request $request)
    {

        if ($request->tipo == "aluno") {

            DB::insert('insert into historico (id, disciplina,quizz,nota,idquizz,tipo,disciplina_id,sessaoId,tipoAvaliação) values(?,?,?,?,?,?,?,?,?)'
                , [uniqid(), session('disciplina')['nome'], session('sessao')['nomeQuizz'], $request->nota,
                    session('sessao')['quizz'], session('utilizador')['tipo'], session('disciplina')['id'], session('sessao')['id'], "normal"]);

        } else {

            $count = DB::select('SELECT COUNT(*) AS "count"
                                FROM historico h,quizz q ,aluno a, disciplina d,disciplina_aluno da
                                WHERE q.id=h.idquizz
                                AND da.aluno_utilizador_id=a.utilizador_id
                                AND d.id=da.disciplina_id
                                AND d.id=h.disciplina_id
                                AND q.id=?
                                AND a.utilizador_id=?
                                AND d.id=?
                                AND h.`tipoAvaliação`=\'avaliacao\'', [session('sessao')['quizz'], session('utilizador')['id'], session('disciplina')['id']]);


            if (session('sessao')['tentativas'] <= $count[0]->count) {
                DB::insert('insert into historico (id, disciplina,quizz,nota,idquizz,tipo,disciplina_id,sessaoId,tipoAvaliação) values(?,?,?,?,?,?,?,?,?)'
                    , [uniqid(), session('disciplina')['nome'], session('sessao')['nomeQuizz'], $request->nota,
                        session('sessao')['quizz'], session('utilizador')['tipo'], session('disciplina')['id'], session('sessao')['id'], "normal"]);

            } else {
                DB::insert('insert into historico (id, disciplina,quizz,nota,idquizz,tipo,disciplina_id,sessaoId,tipoAvaliação) values(?,?,?,?,?,?,?,?,?)'
                    , [uniqid(), session('disciplina')['nome'], session('sessao')['nomeQuizz'], $request->nota,
                        session('sessao')['quizz'], session('utilizador')['tipo'], session('disciplina')['id'], session('sessao')['id'], "avaliacao"]);

                DB::table('disciplina_aluno')->where('aluno_utilizador_id', '=', ['id' => session('utilizador')['id']])->increment('pontos', $request->nota);

            }

        }
        session()->forget('sessao');
    }


    ////////////////////////////////////////////////////////editar//////////////////////////////////////


    function ocultarQuizz(Request $request)
    {
        try {

            DB::table('quizz')->where('id', '=', ['id' => $request->id])->update(['visivel' => 'false']);

            $quizz = DB::select('select visivel, id from quizz where id = ?', [$request->id]);

            return response()->json([
                'message' => $quizz
            ]);

        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'message' => 'erro'
            ]);
        }
    }

    function tornarVisivel(Request $request)
    {

        try {

            DB::table('quizz')->where('id', '=', ['id' => $request->id])->update(['visivel' => 'true']);

            $quizz = DB::select('select visivel, id from quizz where id = ?', [$request->id]);

            return response()->json([
                'message' => $quizz
            ]);

        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'message' => 'erro'
            ]);
        }


    }

    function destroy(Request $request)
    {

        try {

            DB::statement('call deleteQuizz(?)', [$request->id]);

            $quizz = DB::table('quizz')
                ->where('disciplina_id', '=', session('disciplina')['id'])
                ->paginate(5);

            return response()->json([
                'message' => $quizz
            ]);

        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json([
                'message' => 'erro'
            ]);
        }
    }

}
