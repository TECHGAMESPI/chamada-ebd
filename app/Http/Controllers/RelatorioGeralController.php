<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use App\Models\User;
use App\Models\Chamada;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RelatorioGeralController extends Controller
{
    public function index()
    {
        $dataAtual = Carbon::now()->format('Y-m-d');
        
        return $this->gerarRelatorio(new Request(['data' => $dataAtual]));
    }

    public function gerarRelatorio(Request $request)
    {
        $request->validate([
            'data' => 'required|date'
        ]);

        try {
            $dataFormatada = Carbon::parse($request->data)->format('Y-m-d');
            $dataExibicao = Carbon::parse($request->data)->format('d/m/Y');

            $turmas = Turma::where('igreja_id', User::getIgreja()->id)
                ->with(['alunos.aluno'])
                ->get();

            return view('relatorios.relatorio-geral', [
                'turmas' => $turmas,
                'dataFormatada' => $dataFormatada,
                'dataExibicao' => $dataExibicao
            ]);

        } catch (\Exception $e) {
            \Log::error('Erro ao processar data:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Erro ao processar a data selecionada');
        }
    }
} 