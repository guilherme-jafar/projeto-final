<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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





//Route::get('/prof/dashboard', function (){return view('/prof/dashboard');})->middleware(['check.auth', 'tipo.utilizador:prof']);


//Conta professor
Route::group(['middleware' =>['check.auth', 'tipo.utilizador:prof']], function (){
    Route::get('/prof/dashboard',[App\Http\Controllers\Disciplina::class, 'index'])->name('prof/dashboard');
    Route::post('/prof/disciplina/create',[App\Http\Controllers\Disciplina::class, 'create']);
    Route::post('/prof/Topico/create',[App\Http\Controllers\topicos::class, 'create']);
    Route::get('/prof/Disciplina/{token}', [App\Http\Controllers\Disciplina::class, 'EnterDiscProf']);
    Route::get('/prof/listTopicos', [App\Http\Controllers\topicos::class, 'listTopicos']);
    Route::get('/prof/alunos/{id}',[App\Http\Controllers\Disciplina::class,'getAlunos']);
    Route::post("/insertQuestion",[App\Http\Controllers\topicos::class,'insertQuestion']);
    Route::get("/getQuizz",[\App\Http\Controllers\Quizz::class,'listQuizz']);
    Route::post("/insertQuizz",[App\Http\Controllers\Quizz::class,'insertQuizz']);
    Route::post("/getPerguntas",[App\Http\Controllers\topicos::class,'getPerguntas']);

    Route::post("/multiQuestion",[App\Http\Controllers\topicos::class,"MultiQuestion"]);
    Route::delete("/prof/topico/delete/{id}", [App\Http\Controllers\topicos::class,'destroy']);
    Route::delete("/prof/pergunta/delete/{id_topico}/{id}", [App\Http\Controllers\Pergunta::class,'destroy']);
    Route::get('/loading', function () {return view('/loading');});
    Route::get('/prof/pergunta/{id}',  [App\Http\Controllers\Pergunta::class,'show']);
    Route::get('/WaitRoom/{id}',[App\Http\Controllers\Quizz::class,'CreateWaitRoom']);
    Route::delete("/prof/disciplina/delete/{id}", [App\Http\Controllers\Disciplina::class,'destroy']);
    Route::get('/prof/getRespostas/{id}',[App\Http\Controllers\Pergunta::class,'getRespostas']);
    Route::get('/prof/getMultimedia/{id}',[App\Http\Controllers\Pergunta::class,'getMultimedia']);
    Route::get('/prof/getTopicoQuizz/{id}',[App\Http\Controllers\Quizz::class,'listQuizzTopico']);
    Route::post("/prof/topico/{id}/editar", [App\Http\Controllers\topicos::class,'editar']);
    Route::post("/prof/disciplina/{id}/editar", [App\Http\Controllers\Disciplina::class,'editar']);
    Route::post("/prof/quizz/{id}/editar", [App\Http\Controllers\Quizz::class,'editar']);


    Route::post("prof/pergunta/{id}/editar", [App\Http\Controllers\Pergunta::class,'editar']);


    Route::get('/prof/disciplina/sucesso', [App\Http\Controllers\Disciplina::class, 'sucesso']);
    Route::post('/prof/quizz/ocultarquizz/{id}', [App\Http\Controllers\Quizz::class, 'ocultarQuizz']);
    Route::post('/prof/quizz/tornarvisivel/{id}', [App\Http\Controllers\Quizz::class, 'tornarVisivel']);
    Route::delete('/prof/quizz/delete/{id}', [App\Http\Controllers\Quizz::class, 'destroy']);


    Route::get('/prof/historico/{id}', [App\Http\Controllers\Historico::class, 'showProf'] );
    Route::get('/prof/historico/sessao/{id}', [App\Http\Controllers\Historico::class, 'indexProf'] );


});

//conta Aluno
Route::group(['middleware' =>['check.auth', 'tipo.utilizador:aluno']], function () {
    Route::get('/aluno/dashboard', [App\Http\Controllers\Disciplina::class, 'indexAluno']);
    Route::get('/WaitRoomAluno/{id}',[App\Http\Controllers\Quizz::class,'CreateWaitRoom']);
    Route::post('/aluno/disciplina/addDisciplina',[App\Http\Controllers\Disciplina::class, 'addDisciplina']);
    Route::get('/loading', function () {return view('/loading');});
    Route::get('/aluno/AlunoDisciplina/{token}', [App\Http\Controllers\Disciplina::class, 'EnterDiscAluno']);
    Route::get('/quizzTeste/{token}/{sessionID}',[App\Http\Controllers\Quizz::class ,'Enterquizz']);
    Route::post('/getRespostas',[App\Http\Controllers\Quizz::class,'getRespostas']);
    Route::post('/setResposta',[App\Http\Controllers\Quizz::class,'setResposta']);
    Route::get('/EndQuizz/{sessionId}',[App\Http\Controllers\Quizz::class,'EndQuizz']);
    Route::get('/InsideRoomStudent/{id}/{quizzId}',[\App\Http\Controllers\Quizz::class,'EnterWaitRoom']);
    // Route::get('/loading', function () {return view('/loading');});
    Route::delete("/aluno/disciplina/delete/{id}", [App\Http\Controllers\Disciplina::class,'destroy']);

//    Route::get('/getForum', [App\Http\Controllers\forum::class, 'index']);

    Route::get('/aluno/historico/{id}', [App\Http\Controllers\Historico::class, 'showAluno'] );
    Route::get('/aluno/historico/sessao/{id}', [App\Http\Controllers\Historico::class, 'indexAluno'] );

});

Route::group(['middleware' =>['check.auth']], function () {

    Route::get('/forum', [App\Http\Controllers\forum::class, 'index']);
    Route::post('/forum/create', [App\Http\Controllers\forum::class, 'create']);
    Route::delete('/forum/delete', [App\Http\Controllers\forum::class, 'destroy']);
    Route::post('/forum/editar/{id}', [App\Http\Controllers\forum::class, 'editar']);


    Route::get('/mensagens/{id}', [App\Http\Controllers\forum::class, 'indexMensagens']);
    Route::post('/mensagens/create', [App\Http\Controllers\forum::class, 'createMensagem']);
    Route::post('/mensagens/pontos/{id}', [App\Http\Controllers\forum::class, 'pontos']);
    Route::delete('/mensagens/eliminar', [App\Http\Controllers\forum::class, 'destroy']);


    Route::get('/respostasMensagem/{idforum}/{idmensagem}', [App\Http\Controllers\forum::class, 'indexRespostas']);
    Route::post('/respostasMensagem/create', [App\Http\Controllers\forum::class, 'createResposta']);


});

Route::group(['middleware' =>'quizz.session'], function () {
    Route::get('/WaitRoomStudent/{id}/{quizzId}', function (Request $request) {
        return view('/quizz/WaitRoomAluno',
            ['session' => session('sessao')['id'], 'id' => session('sessao')['master'], 'users' => session('sessao')['users']]);
    });
    Route::get('/InsideRoomProf', function (Request $request) {
        return view('/quizz/WaitRoom',
            ['session' => session('sessao')['id']]);
    });
    Route::post('/GiveResults',[\App\Http\Controllers\Quizz::class,'GiveResults']);
    Route::post('/NextQuestionQuizz',[\App\Http\Controllers\Quizz::class,'nextQuestionQuizz']);
    Route::post('/setRespostaQuizz',[App\Http\Controllers\Quizz::class,'setRespostaQuizz']);
    Route::post('/startQuizz',[\App\Http\Controllers\Quizz::class,'startQuizz']);
    Route::post('/StopQuestionQuizz',[\App\Http\Controllers\Quizz::class,'stopQuestionQuizz']);
    Route::get('/leaveRoom',[App\Http\Controllers\Quizz::class,'leave']);
    Route::post('/EndQuizz',[\App\Http\Controllers\Quizz::class, 'EndQuizzRealTime']);
    Route::post('/EndRealTimeQuizz',[\App\Http\Controllers\Quizz::class,'CloseQuizzProf']);
    Route::post('/EndRealTimeQuizzAluno',[\App\Http\Controllers\Quizz::class,'CloseQuizzAluno']);
});




