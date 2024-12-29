<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    protected $fillable = [
        'turma_id',
        'data',
        'quantidade',
        'biblias',
        'igreja_id'
    ];

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
} 