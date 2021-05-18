<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pergunta extends Model
{
    use HasFactory;
    protected $table = 'perguntas';
    protected $fillable = [''];
    protected $casts = ['id' => 'string'];
    protected $respostas = [];

    public function setRespostas($respostas)
    {

        $this->respostas = $respostas;

    }

    public function getRespostas(){
        return $this->respostas;
    }
}
