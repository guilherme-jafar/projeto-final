<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class sessao extends Model
{
    use HasFactory;
    protected $table = 'sessao';
    protected $filelabel = ['id','nome'];
    protected $casts = ['id'=>'string','nome'=>'string'];

    public static function find($sessao)
    {

       $id= DB::select('select * from sessao where id=:id',['id'=>$sessao]);
        return $id[0];
    }

}
