<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sessao extends Model
{
    use HasFactory;
    protected $table = 'sessao';
    protected $filelabel = ['id','nome'];
    protected $casts = ['id'=>'string','nome'=>'string'];

}
