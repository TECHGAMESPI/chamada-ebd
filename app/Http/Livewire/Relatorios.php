<?php

namespace App\Http\Livewire;

use App\Models\Igreja;
use App\Models\Turma;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class Relatorios extends Component
{
    public $igreja_id;
    public $turma_id;
    public $data;
    public $turmas = [];
    public $igrejas;

    public function mount()
    {
        $this->igrejas = Igreja::all();
    }

    public function recuperaTurmas()
    {
        if ($this->igreja_id) {
            $this->turmas = Turma::where('igreja_id', $this->igreja_id)->get();
        }
    }

    public function renderPdf()
    {
        $this->validate([
            'igreja_id' => 'required',
            'turma_id' => 'required',
            'data' => 'required|date'
        ]);

        $turma = Turma::with(['alunos.aluno'])->find($this->turma_id);
        
        // Usando exatamente a data selecionada, sem modificações
        $dataFormatada = $this->data; // Já vem no formato Y-m-d do input date
        $dataExibicao = Carbon::parse($this->data)->format('d/m/Y');

        $alunos = $turma->alunos;

        $pdf = Pdf::loadView('relatorios.aluno-por-turma', [
            'turma' => $turma,
            'alunos' => $alunos,
            'data' => $dataExibicao,
            'dataFormatada' => $dataFormatada // Usando exatamente a data selecionada
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'relatorio-turma-' . $this->turma_id . '-' . $dataFormatada . '.pdf');
    }

    public function render()
    {
        return view('livewire.relatorios');
    }
} 