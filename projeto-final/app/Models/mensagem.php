<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mensagem extends Model
{
    use HasFactory;
    protected $table = 'forum';
    protected $fillable = [''];
    protected $casts = ['id' => 'string'];

}
