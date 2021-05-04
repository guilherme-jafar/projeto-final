<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'utilizador';
    use HasFactory;
    protected $fillable = ['id' ,
        'nome' ,
        'tipo' ,
        'email',
        'foto' ,
        'instituicao'];
    protected $casts = ['id'=>'string','nome'=>'string'];
}
