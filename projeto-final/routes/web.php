<?php

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

Route::get('/login', function () {
    return view('/autenticacao/login');
})->name('login')->middleware('check.logout');

Route::get('/forgotPass', function () {
    return view('/autenticacao/forgotPass');
});
Route::get('/loading', function () {
    return view('/loading');
});



//controller autenticação
Route::post('/registo/sbmProfessor', [App\Http\Controllers\ContaController::class, 'register']);
Route::post('/Confirmar/professor', [App\Http\Controllers\ContaController::class, 'confirmarProf']);
Route::post('/Confirmar/aluno', [App\Http\Controllers\ContaController::class, 'confirmarAluno']);
Route::post('/loginroute', [App\Http\Controllers\ContaController::class, 'login']);
Route::post('/recovery', [App\Http\Controllers\ContaController::class, 'ForgotPassword']);
Route::get('/logout',[App\Http\Controllers\ContaController::class, 'logout'] );







//MAILE
Route::get('/mail1', function () {
    return new \App\Mail\ConfirmMail(123);
});




//Conta professor
Route::get('/prof/dashboard', function (){return view('/prof/dashboard');})->middleware(['check.auth', 'tipo.utilizador:prof']);



//conta Aluno
Route::get('/aluno/dashboard', function (){return view('/aluno/dashboard');})->middleware(['check.auth', 'tipo.utilizador:aluno']);



//Route::group(['middleware' => ['authenticate', 'roles']], function (){
//    Route::get('/dashboard', [
//        'as' => 'dashboard',
//        'uses' => 'DashboardController@dashboard']);
//});
