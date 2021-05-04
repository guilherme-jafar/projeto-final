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

    public function setPontos($pontos)
    {
        if (is_integer($pontos)){
            $this->pontos = $pontos;
        }
    }

    public function getPontos(){
        return $this->pontos;
    }


}
