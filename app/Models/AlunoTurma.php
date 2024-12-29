<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlunoTurma extends Model
{
    protected $table = 'aluno_turma';

    protected $fillable = [
        'aluno_id',
        'turma_id',
        'igreja_id'
    ];

    public function aluno()
    {
        return $this->belongsTo(User::class, 'aluno_id');
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function igreja()
    {
        return $this->belongsTo(Igreja::class);
    }
} 