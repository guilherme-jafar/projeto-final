<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//autenticação
Route::get('/', function () {
    return view('welcome');
});

Route::get('/registo', function () {
    return view('/autenticacao/registo');
})->middleware('check.logout');

Route::get('/registo/user/{tipo}', function ($tipo) {
    return view('/autenticacao/registo_user',['tipo'=>$tipo]);
})->middleware('check.logout');

Route::get('/confirmar/{token}/{tipo}', function ($token,$tipo) {
    return view('/autenticacao/Confirmar',['token'=>$token,'tipo'=>$tipo]);
});
Route::get('/ResetPass/{token}', function ($token) {
    return view('/autenticacao/resetPass',['token'=>$token]);
});
Route::get('/login', function () {
    return view('/autenticacao/login');
})->name('login')->middleware('check.logout');

Route::get('/forgotPass', function () {
    return view('/autenticacao/forgotPass');
});




//controller autenticação
Route::post('/registo/sbmProfessor', [App\Http\Controllers\ContaController::class, 'register']);
Route::post('/Confirmar/professor', [App\Http\Controllers\ContaController::class, 'confirmarProf']);
Route::post('/Confirmar/aluno', [App\Http\Controllers\ContaController::class, 'confirmarAluno']);
Route::post('/loginroute', [App\Http\Controllers\ContaController::class, 'login']);
Route::post('/recovery', [App\Http\Controllers\ContaController::class, 'ForgotPassword']);
Route::post('/SavePass', [App\Http\Controllers\ContaController::class, 'ResetPassword']);
Route::get('/logout',[App\Http\Controllers\ContaController::class, 'logout'] );

Route::get('/editarperfil', function (){
    return view('/autenticacao/editarPerfil');
})->middleware('check.auth');

Route::post('alterarInformacao', [App\Http\Controllers\ContaController::class, 'editarPerfil']);
Route::get('/sucesso', [App\Http\Controllers\ContaController::class, 'sucesso']);





//MAILE
Route::get('/mail1', function () {
    return new \App\Mail\ConfirmMail(123);
});




//Conta professor
//Route::get('/prof/dashboard', function (){return view('/prof/dashboard');})->middleware(['check.auth', 'tipo.utilizador:prof']);



Route::group(['middleware' =>['check.auth', 'tipo.utilizador:prof']], function (){
    Route::get('/prof/dashboard',[App\Http\Controllers\Disciplina::class, 'index'])->name('prof/dashboard');
    Route::post('/prof/disciplina/create',[App\Http\Controllers\Disciplina::class, 'create']);
    Route::post('/prof/Topico/create',[App\Http\Controllers\topicos::class, 'create']);
    Route::get('/prof/Disciplina/{token}', [App\Http\Controllers\Disciplina::class, 'EnterDiscProf']);
    Route::post('/prof/getAlunos',[App\Http\Controllers\Disciplina::class,'getAlunos']);
    Route::post("/insertQuestion",[App\Http\Controllers\topicos::class,'insertQuestion']);
    Route::post("/getQuizz",[\App\Http\Controllers\Quizz::class,'listQuizz']);
    Route::post("/insertQuizz",[App\Http\Controllers\Quizz::class,'insertQuizz']);
    Route::post("/getPerguntas",[App\Http\Controllers\topicos::class,'getPerguntas']);
    Route::get("/WaitRoom/{token}/{sessionID}",[App\Http\Controllers\Quizz::class,'EnterWaitRoom']);
    Route::post("/multiQuestion",[App\Http\Controllers\topicos::class,"MultiQuestion"]);
    Route::get('/loading', function () {
        return view('/loading');
    });
    Route::delete("/prof/disciplina/delete/{id}", [App\Http\Controllers\Disciplina::class,'destroy']);
    Route::post("/prof/disciplina/{id}/editar", [App\Http\Controllers\Disciplina::class,'editar']);
    Route::get('/prof/disciplina/sucesso', [App\Http\Controllers\Disciplina::class, 'sucesso']);
});

//conta Aluno
Route::group(['middleware' =>['check.auth', 'tipo.utilizador:aluno']], function () {
    Route::get('/aluno/dashboard', [App\Http\Controllers\Disciplina::class, 'indexAluno']);

    Route::post('/aluno/disciplina/addDisciplina',[App\Http\Controllers\Disciplina::class, 'addDisciplina']);
    Route::get('/loading', function () {
        return view('/loading');
    });
    Route::get('/aluno/AlunoDisciplina/{token}', [App\Http\Controllers\Disciplina::class, 'EnterDiscAluno']);
    Route::get('/quizzTeste/{token}/{sessionID}',[App\Http\Controllers\Quizz::class ,'Enterquizz']);
    Route::post('/getRespostas',[App\Http\Controllers\Quizz::class,'getRespostas']);
    Route::post('/setResposta',[App\Http\Controllers\Quizz::class,'setResposta']);
    Route::get('/EndQuizz/{sessionId}',[App\Http\Controllers\Quizz::class,'EndQuizz']);
    Route::delete("/aluno/disciplina/delete/{id}", [App\Http\Controllers\Disciplina::class,'destroy']);


});


//Route::group(['middleware' => ['authenticate', 'roles']], function (){
//    Route::get('/dashboard', [
//        'as' => 'dashboard',
//        'uses' => 'DashboardController@dashboard']);
//});
