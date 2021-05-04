<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class Utilizador extends Authenticatable
{
    protected $table = 'utilizador';
    use HasFactory;
    protected $fillable = ['id' ,
                         'nome' ,
                         'tipo' ,
                         'email',
                         'foto' ,
                         'instituicao'];
    protected $casts = ['id'=>'string','nome'=>'string'];

    public static function find($sessao)
    {

        $id= DB::select('select iduser from sessao where id=:id',['id'=>$sessao]);
        return $id;
    }

}
