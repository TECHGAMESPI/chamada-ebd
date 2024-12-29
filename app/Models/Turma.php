<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome_turma',
        'descricao',
        'igreja_id',
    ];

    public static function storeClass(Igreja $igreja)
    {
        Turma::create(
            [
                'nome_turma' => "Adolescentes",
                'igreja_id'  => $igreja->id,
            ]
        );

        Turma::create(
            [
                'nome_turma' => "Adultos",
                'igreja_id'  => $igreja->id,
            ]
        );

        Turma::create(
            [
                'nome_turma' => "Crianças",
                'igreja_id'  => $igreja->id,
            ]
        );

        Turma::create(
            [
                'nome_turma' => "Casais",
                'igreja_id'  => $igreja->id,
            ]
        );
        Turma::create(
            [
                'nome_turma' => "Discipulado",
                'igreja_id'  => $igreja->id,
            ]
        );

        Turma::create(
            [
                'nome_turma' => "Jovens",
                'igreja_id'  => $igreja->id,
            ]
        );

        Turma::create(
            [
                'nome_turma' => "Juniores",
                'igreja_id'  => $igreja->id,
            ]
        );

        Turma::create(
            [
                'nome_turma' => "Primários",
                'igreja_id'  => $igreja->id,
            ]
        );
    }

    public function alunos()
    {
        return $this->hasMany(AlunoPorTurma::class, 'turma_id');
    }

    public function igreja()
    {
        return $this->belongsTo(Igreja::class);
    }
}
