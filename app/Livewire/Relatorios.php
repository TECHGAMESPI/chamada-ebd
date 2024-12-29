<?php

namespace App\Livewire;

use App\Models\{AlunoPorTurma, Igreja, Turma};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Livewire\Component;
use Carbon\Carbon;

class Relatorios extends Component
{
    public $turmas = [];

    public $igrejas;

    public $igreja_id;

    public $turma_id;

    public $data;

    public array $rules = [
        'igreja_id' => 'required',
        'turma_id'  => 'required',
        'data' => 'required|date'
    ];

    public function mount()
    {
        $this->data = date('Y-m-d');
        $this->igrejas = Igreja::all();
        $this->turmas = [];
    }
    
    public function render()
    {
        return view('livewire.relatorios');
    }

    public function renderPdf()
    {
        $this->validate([
            'igreja_id' => 'required',
            'turma_id' => 'required',
            'data' => 'required|date'
        ]);

        try {
            $dataFormatada = Carbon::parse($this->data)->format('d/m/Y');
        } catch (\Exception $e) {
            $dataFormatada = date('d/m/Y');
        }

        $turma = Turma::find($this->turma_id);
        $alunos = AlunoPorTurma::where('turma_id', $this->turma_id)
            ->orderBy('name')
            ->get();

        $pdf = Pdf::loadView('relatorios.aluno-por-turma', [
            'turma'  => $turma,
            'alunos' => $alunos,
            'data'   => $dataFormatada
        ]);
       
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true, 
            'isPhpEnabled' => true,
            'defaultFont' => 'DejaVu Sans',
            'charset' => 'utf-8',
            'enable_remote' => true,
            'enable_css_float' => true,
            'enable_javascript' => false,
            'is_remote_enabled' => true
        ]);
        
        $pdf->setPaper('A4', 'portrait');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'relatorio-' . date('d-m-Y', strtotime($this->data)) . '.pdf');
    }

    public function recuperaTurmas()
    {
        if (!$this->igreja_id) {
            $this->turmas = [];
            return;
        }
        
        $this->turmas = Turma::where('igreja_id', $this->igreja_id)->get();
    }
}
