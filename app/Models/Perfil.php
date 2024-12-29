<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    public const ADMINISTRADOR   = 1;
    public const ALUNO           = 2;
    public const PROFESSOR       = 3;
    public const SUPERINTENDENTE = 4;

    protected $fillable = [
        'perfil',
    ];

    public $timestamps = false;
}
