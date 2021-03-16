<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmMail;
use App\Models\utilizador_nao_confirmado;
use Facade\Ignition\DumpRecorder\Dump;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Psr\Log\NullLogger;

class ContaController extends Controller
{
    public function register(Request $request){

        $name=$request->input('name');
        $pass=$request->input('pass');
        $email=$request->input('email');
        $tipo=$request->input('tipo');
        $sexo=$request->input('sexo');
        $user=DB::table('utilizador')
            ->where('email','like','%'.$email.'%')
            ->get();

        $user2=DB::table('utilizador_nao_confirmado')
            ->where('email','like','%'.$email.'%')
            ->get();

        if (strlen($pass)<8) {

            return response()->json([
                'message' => ' ',
                'password' => 'a password e muito pequena',
                'email' => ' '
            ]);
        }
        elseif(!preg_match("#[0-9]+#",$pass)) {
            return response()->json([
                'message' => ' ',
                'password' => 'a password não tem numeros',
                'email' => ' '
            ]);
        }
        elseif(!preg_match("#[A-Z]+#",$pass)) {
            return response()->json([
                'message' => ' ',
                'password' => 'a password não tem letras maiusculas',
                'email' => ' '
            ]);
        }
        elseif(!preg_match("#[a-z]+#",$pass)) {
            return response()->json([
                'message' => ' ',
                'password' => 'a password não tem letras minusculas',
                'email' => ' '
            ]);
        }elseif(!$user->isEmpty() || !$user2->isEmpty()) {
            return response()->json([
                'message' => ' ',
                'password' => ' ',
                'email' => 'o email ja esta em uso'
            ]);
        }
        else {
            $hashed = Hash::make($pass, [
                'rounds' => 12,
            ]);


            $id=rand ( 0 , 1000000 )+rand ( 0 , 1000000 )+time();
            $token=rand ( 0 , 1000000 )+time();
            DB::insert('insert into utilizador_nao_confirmado (id, nome,email,password,tipo,token,sexo) values (?,?,?,?,?,?,?)'
                , [intval($id, 36), $name,$email,$hashed,$tipo,intval($token, 36),$sexo]);

            if ($tipo=="prof")
                $ticket='http://127.0.0.1:8000/confirmar/token='.$token.'/prof';
            else
                $ticket='http://127.0.0.1:8000/confirmar/token='.$token.'/aluno';
            Mail::to($email)->send(new ConfirmMail($ticket));
            return response()->json([
                'message' => 'sucesso',
                'password' => ' ',
                'email' => ' '
            ]);
        }



    }

    public function confirmarProf(Request $request){
            $token=$request->id;


        $user=DB::table('utilizador_nao_confirmado')
            ->where('utilizador_nao_confirmado.token','=',$token)
            ->value('id');

        if (empty($user)){
            return response()->json([
                'message' => 'error'
            ]);
        }
        else {
            $newID=intval("p".time().$token, 36);
            DB::statement('call inProf(?)',[$token]);
            DB::insert('insert into prof_ (id,utilizador_id) values (?,?)'
                , ["p".$newID,$user]);


           return response()->json([
                'message' => 'sucesso'
            ]);

        }
    }


    public function confirmarAluno(Request $request){
        $token=$request->id;


        $user=DB::table('utilizador_nao_confirmado')
            ->where('utilizador_nao_confirmado.token','=',$token)
            ->value('id');

        if (empty($user)){
            return response()->json([
                'message' => 'error'
            ]);
        }
        else {
            $newID=intval("p".time().$token, 36);
            DB::statement('call inProf(?)',[$token]);
            DB::insert('insert into aluno (id,utilizador_id) values (?,?)'
                , ["p".$newID,$user]);


            return response()->json([
                'message' => 'sucesso'
            ]);

        }
    }

    public function login(Request $request){



    }


}
