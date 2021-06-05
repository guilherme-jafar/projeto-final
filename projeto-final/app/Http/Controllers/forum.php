<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class forum extends Controller
{

    function index(Request $request){

        $forum = DB::table('forum')
            ->where('disciplina_id', '=', session('disciplina')['id'])
            ->paginate(5);

        if (!empty($forum)) {
            return response()->json([
                'message' => $forum
            ]);


        } else {
            return response()->json([
                'message' => []
            ]);
        }

    }

    function indexMensagens(Request $request){

        $mensagem = DB::table('mensagem', 'm')->select('m.*', 'u.nome', 'u.foto_perfil', 'u.tipo')
            ->join('utilizador as u', 'm.id_utilizador', '=', 'u.id' )
            ->where('forum_id', '=', $request->id)
            ->where('m.tipo', '=', 'true')
            ->orderBy('data','asc')
            ->paginate(5);


        if (!empty($mensagem)) {
            return response()->json([
                'message' => $mensagem
            ]);


        } else {
            return response()->json([
                'message' => []
            ]);
        }

    }

    function indexRespostas(Request $request){


        $respostas = DB::table('mensagem', 'm')->select('m.*', 'u.nome', 'u.foto_perfil', 'u.tipo')
            ->join('utilizador as u', 'm.id_utilizador', '=', 'u.id' )
            ->where('forum_id', '=', $request->idforum)
            ->where('m.tipo', '=', 'false')
            ->where('m.id_mensagem', '=', $request->idmensagem)
            ->orderBy('data','asc')
            ->paginate(5);



//        dd($respostas);
        return response()->json([
            'message' => $respostas
        ]);
//        if (!empty($mensagem)) {
//            return response()->json([
//                'message' => $mensagem
//            ]);
//
//
//        } else {
//            return response()->json([
//                'message' => $mensagem
//            ]);
//        }

    }

    function create(Request $request){


        try {
            $id = time();
            $nomeForum = $request->input('nomeforum');
            $assuntoForum = $request->input('assuntoForum');

            $insertforum = DB::insert('insert into forum (id, topico,assunto,disciplina_id) values (?,?,?,?)'
                , [$id, $nomeForum, $assuntoForum, session('disciplina')['id']]);


            $foruns = DB::table('forum')->where('disciplina_id', '=', ['id' => session('disciplina')['id']])
                ->paginate(5);


            if ($insertforum) {
                return response()->json([
                    'message' => $foruns,
                ]);
            } else {
                return response()->json([
                    'message' => 'erro',
                ]);
            }

        }catch (\Illuminate\Database\QueryException $ex){
            return response()->json([
                'message' => 'erro'
            ]);
        }
    }

    function createMensagem(Request $request){

        try {
            $id =  time();
            $forumId = $request->idForum;
            $textoMensagem = $request->textoMensagem;



            $insertMensagem = DB::insert('insert into mensagem (id, mensagem,data,tipo, id_utilizador, forum_id) values (?,?,?,?,?,?)'
                , [$id, $textoMensagem, now(), 'true',session('utilizador')['id'], $forumId]);


            $mensagem = DB::table('mensagem', 'm')->select('m.*', 'u.nome', 'u.foto_perfil', 'u.tipo')
                ->join('utilizador as u', 'm.id_utilizador', '=', 'u.id' )
                ->where('forum_id', '=', $forumId)
                ->where('m.tipo', '=', 'true')
                ->orderBy('data','asc')
                ->paginate(5);




            if ($insertMensagem) {
                return response()->json([
                    'message' => $mensagem,
                ]);
            } else {
                return response()->json([
                    'message' => 'erro',
                ]);
            }

        }catch (\Illuminate\Database\QueryException $ex){
            return response()->json([
                'message' => 'erro'
            ]);
        }
    }

    function createResposta(Request $request){

        try {
            $id = time();
            $forumId = $request->idForum;
            $textoMensagem = $request->textoResposta;
            $mensagemId = $request->idMensagem;


            $insertResposta = DB::insert('insert into mensagem (id, mensagem,data,tipo, id_utilizador, forum_id, id_mensagem) values (?,?,?,?,?,?,?)'
                , [$id, $textoMensagem, now(), 'false',session('utilizador')['id'], $forumId, $mensagemId]);


            $respostas = DB::table('mensagem', 'm')->select('m.*', 'u.nome', 'u.foto_perfil', 'u.tipo')
                ->join('utilizador as u', 'm.id_utilizador', '=', 'u.id' )
                ->where('forum_id', '=', $forumId)
                ->where('m.tipo', '=', 'false')
                ->where('m.id_mensagem', '=', $mensagemId)
                ->orderBy('data','asc')
                ->paginate(5);


            if ($insertResposta) {
                return response()->json([
                    'message' => $respostas,
                ]);
            } else {
                return response()->json([
                    'message' => 'erro',
                ]);
            }

        }catch (\Illuminate\Database\QueryException $ex){
            return response()->json([
                'message' => 'erro'
            ]);
        }
    }

    function pontos(Request $request){
        try {


//            dd($request->id, $request);

            DB::table('mensagem')
                ->where('id', '=', $request->id)
                ->update(['pontos' => $request->pontos]);


            return response()->json([
                'message' => 'sucesso',
            ]);

        }catch (\Illuminate\Database\QueryException $ex){
            return response()->json([
                'message' => 'erro'
            ]);
        }


    }

}
