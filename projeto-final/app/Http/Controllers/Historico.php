<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Historico extends Controller
{
    function getHistoricosProf(Request $request)
    {

//        $historico = DB::table('sessao')->select('*, count(sessaoMaster)')->where('quizz_id', '=', $request->id)->where('sessaoMaster', '!=', 'NULL')->groupBy('sessaoMaster')->paginate(5);

        $historico = DB::table('sessao')->select(DB::raw('sessaoMaster, count(sessaoMaster)'))->whereRaw('quizz_id =:id and sessaoMaster != \'NULL\'', ['id' => $request->id])->groupBy('sessaoMaster')->paginate(5);


        if (!empty($historico)) {
            return response()->json([
                'message' => $historico
            ]);


        } else {
            return response()->json([
                'message' => []
            ]);
        }

    }

    function getHistoricoSessaoProf(Request $request)
    {
        $sessoes = DB::select('SELECT respostas_quizz.aluno_utilizador_id, utilizador.nome, respostas_quizz.sessao_id , COUNT(respostas_quizz.aluno_utilizador_id) AS num_respostas, SUM(respostas_quizz.resultado) AS soma_resultado FROM respostas_quizz, utilizador WHERE respostas_quizz.aluno_utilizador_id = utilizador.id and respostas_quizz.sessao_id IN (SELECT id FROM sessao  WHERE sessaoMaster = :id) GROUP BY respostas_quizz.aluno_utilizador_id ', ['id' => $request->id]);

        $respostas = [];

        foreach ($sessoes as $key=>$sessao){
            $respostas['respostas'][$key] = DB::select('SELECT * FROM respostas_quizz rq ,pergunta_quizz p
            WHERE sessao_id IN(SELECT id FROM sessao s  WHERE sessaoMaster = :idSessao )
            AND aluno_utilizador_id = :alunoId
            AND rq.pergunta_id=p.id_pergunta
            '
                ,

                ['idSessao' => $request->id, 'alunoId' => $sessao->aluno_utilizador_id]);
            $respostas['alunos'][$key] = $sessao;
        }



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

    function getHistoricosAluno(Request $request)
    {

        $historico = DB::table('sessao')->select(DB::raw('sessaoMaster, count(sessaoMaster)'))->whereRaw('quizz_id =:id and  idUser =:idAluno and sessaoMaster != \'NULL\'', ['id' => $request->id, 'idAluno' => session('utilizador')['id']])->groupBy('sessaoMaster')->paginate(5);


        if (!empty($historico)) {
            return response()->json([
                'message' => $historico
            ]);


        } else {
            return response()->json([
                'message' => []
            ]);
        }

    }

    function getHistoricoSessaoAluno(Request $request)
    {
        $respostas = [];

        $respostas['aluno'] = DB::select('SELECT respostas_quizz.aluno_utilizador_id, utilizador.nome, respostas_quizz.sessao_id , COUNT(respostas_quizz.aluno_utilizador_id) AS num_respostas, SUM(respostas_quizz.resultado) AS soma_resultado FROM respostas_quizz, utilizador WHERE respostas_quizz.aluno_utilizador_id = utilizador.id and respostas_quizz.sessao_id IN (SELECT id FROM sessao  WHERE sessaoMaster = :id) and respostas_quizz.aluno_utilizador_id = :idAluno', ['id' => $request->id, 'idAluno' =>  session('utilizador')['id']]);


        $respostas['respostas'] = DB::select('SELECT * FROM respostas_quizz WHERE sessao_id IN(SELECT id FROM sessao s  WHERE sessaoMaster = :idSessao )AND aluno_utilizador_id = :alunoId', ['idSessao' => $request->id, 'alunoId' =>session('utilizador')['id']]);

        foreach($respostas['respostas'] as $key=>$resposta){
            $respostas['respostas'][$key]->perguntas = DB::select('SELECT * FROM respostas , perguntas WHERE respostas.perguntas_id = perguntas.id AND perguntas.id =:id',
                ['id' => $resposta->pergunta_id]);
        }

//        dd($respostas);


        if (!empty($respostas)) {
            return response()->json([
                'message' => $respostas
            ]);


        } else {
            return response()->json([
                'message' => []
            ]);
        }



    }

    function question(Request $request){
        $respostas = [];

        $respostas=DB::select('SELECT pq.enuncia AS "enunciado",r.resposta AS "resposta", r.resultado AS "res" ,rq.resposta AS "trueResposta"
FROM respostas r  , sessao s  ,pergunta_quizz pq ,respostas_quizz rq
        WHERE s.id = :idSessao
        AND rq.aluno_utilizador_id = :idAluno
        AND pq.PergIndex= :idPerg
        AND rq.sessao_id=s.id
        AND r.perguntas_id=rq.pergunta_id
        AND rq.pergunta_id=pq.id_pergunta
        GROUP BY r.id' ,['idSessao' => $request->id, 'idAluno' => $request->userId ,'idPerg'=>$request->pId] );



        if (!empty($respostas)) {
            return response()->json([
                'message' => $respostas
            ]);


        } else {
            return response()->json([
                'message' => []
            ]);
        }

    }


}
