<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    protected $table = 'disciplina';
    use HasFactory;
    protected $fillable = [''];
    protected $casts = ['id' => 'string'];
    protected $pontos = 0;
    protected $total_quizz = 0;
    protected $total_topico= 0;

    public function setPontos($pontos)
    {
        if (is_integer($pontos)){
            $this->pontos = $pontos;
        }
    }

    public function getPontos(){
        return $this->pontos;
    }

    public function getTotalTopicos(){
        return $this->total_topico;
    }

    public function setTotalTopicos($total_topico)
    {
        if (is_integer($total_topico)){
            $this->total_topico = $total_topico;
        }
    }

    public function getTotalQuizz(){
        return $this->total_quizz;
    }

    public function setTotalQuizz($total_quizz)
    {
        if (is_integer($total_quizz)){
            $this->total_quizz = $total_quizz;
        }
    }




}
