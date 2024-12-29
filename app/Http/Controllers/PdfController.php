<?php

namespace App\Http\Controllers;

use App\Models\{AlunoPorTurma, Quiz, Turma};
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function __construct(protected Turma $turma, protected AlunoPorTurma $alunos)
    {
    }

    public function alunosPorTurma(Request $request)
    {
        \Log::info('Data recebida:', ['data' => $request->data]);

        try {
            // Primeiro converte para Carbon
            $data = Carbon::parse($request->data);
            // Depois formata para Y-m-d para o banco de dados
            $dataFormatada = $data->format('Y-m-d');
            // Formata para exibição
            $dataExibicao = $data->format('d/m/Y');
        } catch (\Exception $e) {
            \Log::error('Erro ao formatar data:', ['error' => $e->getMessage()]);
            $dataFormatada = date('Y-m-d');
            $dataExibicao = date('d/m/Y');
        }

        $pdf = Pdf::loadView(
            'relatorios.aluno-por-turma',
            [
                'turma'  => $this->turma->find($request->turma),
                'alunos' => $this->alunos->where('turma_id', $request->turma)->orderBy('name')->get(),
                'data'   => $dataExibicao
            ]
        );
       
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'chroot' => public_path(),
            'defaultFont' => 'DejaVu Sans'
        ]);
        
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('relatorio-' . $dataFormatada . '.pdf');
    }

    public function quiz(Quiz $quiz)
    {
        $pdf = Pdf::loadView(
            'relatorios.quiz',
            [
                'quiz' => $quiz,
            ]
        )->setPaper('a4')->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'chroot' => public_path()]);

        return $pdf->stream();
    }
}
