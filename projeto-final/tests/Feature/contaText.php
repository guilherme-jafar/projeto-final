<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class contaText extends TestCase
{


    public function test_login()
    {
        $response = $this->post('/loginroute', ['email' => 'aluno2@alunos.com' ,'password'=>'Estgoh2021'] , array('HTTP_X-Requested-With' => 'XMLHttpRequest'));

        echo $response->getStatusCode();
        $response->assertStatus(200);
    }


    public function text_login()
    {

    }
}
