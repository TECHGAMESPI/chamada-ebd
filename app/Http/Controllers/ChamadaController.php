<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Turma;

class ChamadaController extends Controller
{
    public function index($turma_id)
    {
        $turma = \App\Models\Turma::findOrFail($turma_id);
        
        return view('user.chamada', [
            'turma' => $turma,
            'nomeTurma' => $turma->nome_turma
        ]);
    }
} 