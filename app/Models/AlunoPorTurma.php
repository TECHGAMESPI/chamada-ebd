<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlunoPorTurma extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'turma_id',
        'igreja_id',
        'name',
    ];

    protected $appends = ['presenca'];

    public function aluno()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function turma()
    {
        return $this->hasOne(Turma::class, 'id', 'turma_id');
    }

    public function getPresencaAttribute()
    {
        return Chamada::where(['user_id' => $this->user_id, 'turma_id' => $this->turma_id, 'data' => date('Y-m-d')])->first();
    }
}
