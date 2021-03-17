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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/registo', function () {
    return view('/autenticacao/registo');
});

Route::get('/registo/user/{tipo}', function ($tipo) {
    return view('/autenticacao/registo_user',['tipo'=>$tipo]);
});
Route::get('/confirmar/{token}/{tipo}', function ($token,$tipo) {
    return view('/autenticacao/Confirmar',['token'=>$token,'tipo'=>$tipo]);
});


Route::get('/login', function () {
    return view('/autenticacao/login');
})->name('login');

Route::post('/loginroute', [App\Http\Controllers\ContaController::class, 'login']);

//controller
Route::post('/registo/sbmProfessor', [App\Http\Controllers\ContaController::class, 'register']);
Route::post('/Confirmar/professor', [App\Http\Controllers\ContaController::class, 'confirmarProf']);
Route::post('/Confirmar/aluno', [App\Http\Controllers\ContaController::class, 'confirmarAluno']);
//images




Route::get('/loading', function () {
    return view('/loading');
});

Route::get('/logout',[App\Http\Controllers\ContaController::class, 'logout'] );


//MAILE
Route::get('/mail1', function () {
    return new \App\Mail\ConfirmMail(123);
});

Route::get('/prof/dashboard', [App\Http\Controllers\ContaController::class, 'teste'])->middleware('auth');



//Route::group(['middleware' => ['authenticate', 'roles']], function (){
//    Route::get('/dashboard', [
//        'as' => 'dashboard',
//        'uses' => 'DashboardController@dashboard']);
//});
