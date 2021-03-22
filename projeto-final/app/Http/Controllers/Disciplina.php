<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Disciplina extends Controller
{

    function index(){


       // $disciplina = DB::select('select * FROM disciplina d,  prof__disciplina pd WHERE d.id = pd.disciplina_id AND pd.prof__utilizador_id = :id', ['id' =>  session('utilizador')['id']]);


        if (!empty($disciplina[0])){
            return view('/prof/dashboard', ['disciplina' => $disciplina]);
        }else{
            return view('/prof/dashboard', ['disciplina' => 'vazio']);
        }




    }

    function create(Request $request){


        $id=rand ( 0 , 1000000 )+rand ( 0 , 1000000 )+time();
        $nome_disciplina = $request->input('disciplina');
        $descricao = $request->input('descricao');
        $presenca = $request->input('presenca');

        $disciplina = DB::insert('insert into disciplina (id, nome,descricao,inscritos) values (?,?,?,?)'
            , [intval($id, 36), $nome_disciplina,$descricao,0]);

        $prf_disciplina = DB::insert('insert into prof__disciplina (prof__utilizador_id, disciplina_id) values (?,?)'
            , [session('utilizador')['id'],$id]);


       // $get_disciplina = DB::select('select * from disciplina where id = :id', ['id' => $id]);

        //dd($get_disciplina);

//        if ($disciplina){
//            return response()->json([
//                'message' => 'sucesso',
//            ]);
//        }else{
//            return response()->json([
//                'message' => 'erro',
//            ]);
//        }

    }
}
