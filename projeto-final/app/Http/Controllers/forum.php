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

        $mensagem = DB::table('mensagem')
            ->where('forum_id', '=', $request->id)
            ->paginate(5);

        $mensagem = DB::table('mensagem', 'm')->select('m.*', 'u.nome', 'u.foto_perfil')
            ->join('utilizador as u', 'm.id_utilizador', '=', 'u.id' )
            ->where('forum_id', '=', $request->id)
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

    function create(Request $request){


        try {
            $id = uniqid() . time();
            $nomeForum = $request->input('nomeforum');
            $assuntoForum = $request->input('assuntoForum');

            $insertforum = DB::insert('insert into forum (id, topico,assunto,disciplina_id) values (?,?,?,?)'
                , [$id, $nomeForum, $assuntoForum, session('disciplina')['id']]);


            $foruns = DB::table('forum')->where('disciplina_id', '=', ['id' => session('disciplina')['id']])
                ->paginate(4);


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
            $id = uniqid() . time();
            $forumId = $request->idForum;
            $textoMensagem = $request->textoMensagem;
            $tipo = $request->mensagem;


            $insertMensagem = DB::insert('insert into mensagem (id, mensagem,data,tipo, id_utilizador, forum_id) values (?,?,?,?,?,?)'
                , [$id, $textoMensagem, now(), $tipo,session('utilizador')['id'], $forumId]);


            $mensagem = DB::table('mensagem', 'm')->select('m.*', 'u.nome', 'u.foto_perfil')
                ->join('utilizador as u', 'm.id_utilizador', '=', 'u.id' )
                ->where('forum_id', '=', $forumId)
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

}