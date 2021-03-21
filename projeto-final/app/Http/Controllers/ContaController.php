<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmMail;
use App\Mail\resetPass;
use App\Models\Utilizador;
use App\Models\utilizador_nao_confirmado;
use DateTime;
use Facade\Ignition\DumpRecorder\Dump;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Psr\Log\NullLogger;
use function PHPUnit\Framework\isEmpty;

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
                'password' => 'a password tem menos de oito carateres',
                'email' => ' '
            ]);
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return response()->json([
                'message' => ' ',
                'password' => ' ',
                'email' => 'email invalido '
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
            DB::insert('insert into utilizador_nao_confirmado (id, nome,email,password,tipo,token,sexo,foto_perfil) values (?,?,?,?,?,?,?,?)'
                , [intval($id, 36), $name,$email,$hashed,$tipo,intval($token, 36),$sexo],'default.png');

            if ($tipo=="prof")
                $ticket= $request->root() . '/confirmar/token='.$token.'/prof';
            else
                $ticket= $request->root() . '/confirmar/token='.$token.'/aluno';
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



        $email = $request->input('email');
        $password = $request->input('password');

         $user =  DB::table('utilizador')->where('email','=',$email)->get();




         if (!empty($user[0])){

             if (Hash::check($password, $user[0]->password)){

                 var_dump(strcmp('prof', $user[0]->tipo));
                 var_dump($user[0]->tipo);

                 $user2 = [
                     'id' =>$user[0]->id,
                     'nome' =>$user[0]->nome,
                     'tipo' =>$user[0]->tipo,
                     'email' => $user[0]->email,
                     'foto' => $user[0]->foto_perfil,
                 ];

                 $request->session()->put('utilizador', $user2);

                 Auth::login(new Utilizador($user2));

                 return response()->json([
                     'message' => 'sucess'
                 ]);

             }else{

                 return response()->json([
                     'message' => 'erro'
                 ]);
             }

         }else{
             return response()->json([
                 'message' => 'erro'
             ]);
         }





    }

    public function logout(Request $request){

       // dd($request->user());

         $request->session()->flush();

        return redirect('/');

    }

    public function ForgotPassword(Request $request){

        $email=$request->email;
        $user=DB::table('utilizador')
            ->where('email','like','%'.$email.'%')
            ->get();


        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'message' => 'formato invalido'
            ]);
        }else if($user->isEmpty()){
            return response()->json([
                'message' => 'Não exite nenhum utilizador com este email'
            ]);
        }else{
            $token=rand ( 0 , 1000000 )+time();

            date_default_timezone_set(date_default_timezone_get());
            $date = date('Y-m-d h:i:s ', time());
            DB::insert('insert into password_resets (email,token,created_at) values (?,?,?)'
                , [$email,intval($token,24),$date]);
            $ticket= $request->root() . '/ResetPass/token='.$token;
            Mail::to($email)->send(new resetPass($ticket));
            return response()->json([
                'message' => 'sucesso'
            ]);
        }



    }



    public function ResetPassword(Request $request){

        $pass=$request->pass;
        $token=$request->token;
        $user=DB::table('password_resets')
            ->where('token','like','%'.$token.'%')
            ->get();

        if (strlen($pass)<8) {

            return response()->json([
                'message' => 'a password tem menos de oito carateres',
            ]);
        }
        elseif(!preg_match("#[0-9]+#",$pass)) {
            return response()->json([
                'message' => 'a password não tem numeros',

            ]);
        }
        elseif(!preg_match("#[A-Z]+#",$pass)) {
            return response()->json([
                'message' => 'a password não tem letras maiusculas ',

            ]);
        }
        elseif(!preg_match("#[a-z]+#",$pass)) {
            return response()->json([
                'message' => 'a password não tem letras minusculas',
            ]);
        }elseif ($user->isEmpty()) {

            return response()->json([
                'message' => 'não foi possivel mudar a password',
            ]);
        }else{

            $hashed = Hash::make($pass, [
                'rounds' => 12,
            ]);
            DB::table('utilizador')
                ->where('email','like','%'.$user[0]->email.'%')
                ->update(['password' => $hashed]);

            DB::table('password_resets')
                ->where('token','like','%'.$token.'%')
                ->delete();
            return response()->json([
                'message' => 'sucesso',
            ]);

        }




    }
}