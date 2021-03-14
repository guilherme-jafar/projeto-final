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

Route::get('/registo/rgsProfessor', function () {
    return view('/autenticacao/registo_professor');
});
Route::get('/confirmar/{token}/{tipo}', function ($token,$tipo) {
    return view('/autenticacao/Confirmar',['token'=>$token,'tipo'=>$tipo]);
});

/*Route::get('/confirmar',['' => 'search', 'uses' => function () {
    return view('/autenticacao/Confirmar');
}
] );*/

//controllerProfessor
Route::post('/registo/sbmProfessor', [App\Http\Controllers\ContaProfessorController::class, 'register']);
Route::post('/professorConfirmar', [App\Http\Controllers\ContaProfessorController::class, 'confirmarProf']);
//images




