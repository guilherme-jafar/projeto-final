<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class contaText extends TestCase
{


    public function test_login()
    {
        $server = array('HTTP_X-Requested-With' => 'XMLHttpRequest');
        $request= new Request();
        $response = $this->postJson('http://127.0.0.1:8000/loginroute', ['email' => 'aluno2@alunos.com' ,'password'=>'Estgoh2021'],$server);
       // $response= $this->call('get','/logout');
        $response ->assertStatus(200)
            ->assertJson([ 'message' => 'sucesso']);
    }




    public function test_logout()
    {

        $user2 = [
            'id' =>'1',
            'nome' =>'nome',
            'tipo' =>'aluno',
            'email' => 'aluno2@ggg',
            'foto' => 'null',
            'instituicao' => 'null'
        ];


        session()->put('utilizador', $user2);
        $response= $this->get('/logout');
        $response ->assertStatus(200);


    }


    public function text_login()
    {

    }
}
