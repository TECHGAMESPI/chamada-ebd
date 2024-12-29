<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Igreja extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'endereco', 'pastor', 'tipo_igreja', 'dia_ebd', 'horario'];

    public function users()
    {
        return $this->hasMany(UsuariosPorIgreja::class);
    }

    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }
}
