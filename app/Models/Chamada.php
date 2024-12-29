<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamada extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
        'professor_id',
        'turma_id',
        'aluno_id',
        'livro',
        'falta_justificada',
        'material',
        'igreja_id',
    ];

    public $timestamps = false;

    public function aluno()
    {
        return $this->belongsTo(User::class, 'id', 'aluno_id');
    }

    public function turmas()
    {
        return $this->hasMany(Turma::class, 'id', 'tuma_id');
    }
}
