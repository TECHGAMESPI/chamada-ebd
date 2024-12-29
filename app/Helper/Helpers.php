<?php

namespace App\Helper;

use App\Models\{Chamada, Perfil, ProfessorPorTurma, Turma, User, Visitante};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

trait Helpers
{
    public function getTurmas()
    {

        if (Auth::user()->perfil_id == Perfil::SUPERINTENDENTE || Auth::user()->perfil_id == Perfil::ADMINISTRADOR) {
            $turmas = Turma::where(['igreja_id' => User::getIgreja()->id, 'is_active' => true])->get();

            return $turmas;
        }

        $turmasPorProfessor = ProfessorPorTurma::where(['professor_id' => Auth::user()->id, 'igreja_id' => User::getIgreja()->id])->get();
        $collect            = new Collection();
        $turmasPorProfessor->map(function (ProfessorPorTurma $turmaPorProfessor) use (&$collect) {
            $turma = Turma::find($turmaPorProfessor->turma_id);

            $turma->is_active ? $collect->push($turma) : null;
        });
        $turmas = $collect;

        return $turmas;
    }

    public static function verificamaterial($aluno, $turma, $data)
    {
        \Log::info('Verificando material:', [
            'aluno_id' => $aluno,
            'turma_id' => $turma,
            'data' => $data
        ]);

        $presenca = Chamada::where([
            'aluno_id' => $aluno,
            'turma_id' => $turma,
            'data' => $data
        ])->first();

        return $presenca && $presenca->material ? 'checked' : '';
    }

    public static function verificaPresenca($aluno, $turma, $data)
    {
        \Log::info('Verificando presença:', [
            'aluno_id' => $aluno,
            'turma_id' => $turma,
            'data' => $data
        ]);

        $presenca = Chamada::where([
            'aluno_id' => $aluno,
            'turma_id' => $turma,
            'data' => $data
        ])->first();

        \Log::info('Resultado da consulta:', [
            'presenca_encontrada' => $presenca ? 'sim' : 'não',
            'sql' => Chamada::where([
                'aluno_id' => $aluno,
                'turma_id' => $turma,
                'data' => $data
            ])->toSql()
        ]);

        if (!$presenca) {
            return "Ausente";
        }

        return $presenca->material || !$presenca->falta_justificada ? "Presente" : "Ausente";
    }

    public static function contaVisitantes($turma_id, $data)
    {
        try {
            $dataFormatada = Carbon::parse($data)->format('Y-m-d');
            
            $visitantes = Visitante::where([
                'turma_id' => $turma_id,
                'data' => $dataFormatada
            ])->first();

            if (!$visitantes) {
                return [
                    'total' => 0,
                    'com_material' => 0
                ];
            }

            return [
                'total' => $visitantes->quantidade ?? 0,
                'com_material' => $visitantes->biblias ?? 0
            ];

        } catch (\Exception $e) {
            \Log::error('Erro ao contar visitantes: ' . $e->getMessage());
            return [
                'total' => 0,
                'com_material' => 0
            ];
        }
    }
}
