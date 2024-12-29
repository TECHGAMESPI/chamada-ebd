<?php

namespace App\Http\Controllers;

use App\Models\{AlunoPorTurma, Chamada, Turma, User, UsuariosPorIgreja};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisualizarChamadasController extends Controller
{
    private Chamada $chamada;

    private User $user;

    private Turma $turma;

    private AlunoPorTurma $alunoPorTurma;

    public function __construct(Chamada $chamada, User $user, Turma $turma, AlunoPorTurma $alunoPorTurma)
    {
        $this->chamada       = $chamada;
        $this->user          = $user;
        $this->turma         = $turma;
        $this->alunoPorTurma = $alunoPorTurma;
    }

    public function create()
    {
        $chamadas  = $this->chamada->where('aluno_id', Auth::user()->id)->whereYear('data', date('Y'))->get();
        $presencas = [];

        foreach ($chamadas as $chamada) {
            if ($chamada->livro == true) {
                $tipoPresenca = "livro";
            } else {
                $tipoPresenca = "Normal";
            }
            $i = [
                'data'          => date("d/m/Y", strtotime($chamada->data)),
                'turma'         => $this->turma->find($chamada->turma_id)->nome_turma,
                'tipo_presenca' => $tipoPresenca,
                'professor'     => $this->user->find($chamada->professor_id)->name,
            ];
            array_push($presencas, (object)$i);
        }

        return view('user.presencas', ['title' => 'Minhas Presenças', 'chamadas' => $presencas]);
    }

    public function chamadas(Request $request)
    {
        $alunos       = UsuariosPorIgreja::where('igreja_id', User::getIgreja()->id)->get();
        $presencas    = $this->chamada->where('livro', false)->where('igreja_id', User::getIgreja()->id)->whereYear('data', date('Y'))->count();
        $livros      = $this->chamada->where('livro', true)->where('igreja_id', User::getIgreja()->id)->whereYear('data', date('Y'))->count();
        $justificadas = $this->chamada->where('falta_justificada', true)->where('igreja_id', User::getIgreja()->id)->whereYear('data', date('Y'))->count();

        if ($request->id) {
            $alunos = $this->alunoPorTurma->where([
                'turma_id' => $request->id,
            ])->get();
            $presencas    = $this->chamada->where('livro', false)->where(['turma_id' => $request->id])->whereYear('data', date('Y'))->count();
            $livros      = $this->chamada->where('livro', true)->where(['turma_id' => $request->id])->whereYear('data', date('Y'))->count();
            $justificadas = $this->chamada->where('falta_justificada', true)->where(['turma_id' => $request->id])->whereYear('data', date('Y'))->count();
        }

        return view('user.chamadas-turmas', [
            'turma_id'     => $request->id ? $request->id : null,
            'title'        => 'Chamadas Por Turma',
            'alunos'       => $alunos,
            'usuarios'     => $alunos->count(),
            'presencas'    => $presencas,
            'livros'      => $livros,
            'justificadas' => $justificadas,
            'turmas'       => $this->turma->where('igreja_id', User::getIgreja()->id)->get(),
            'jan'          => $request->id ? $this->chamada->where(['turma_id' => $request->id, 'igreja_id' => User::getIgreja()->id])->whereMonth('data', '01')->whereYear('data', date('Y'))->count() : $this->chamada->where('igreja_id', User::getIgreja()->id)->whereMonth('data', '01')->whereYear('data', date('Y'))->count(),
            'fev'          => $request->id ? $this->chamada->where(['turma_id' => $request->id, 'igreja_id' => User::getIgreja()->id])->whereMonth('data', '02')->whereYear('data', date('Y'))->count() : $this->chamada->where('igreja_id', User::getIgreja()->id)->whereMonth('data', '02')->whereYear('data', date('Y'))->count(),
            'mar'          => $request->id ? $this->chamada->where(['turma_id' => $request->id, 'igreja_id' => User::getIgreja()->id])->whereMonth('data', '03')->whereYear('data', date('Y'))->count() : $this->chamada->where('igreja_id', User::getIgreja()->id)->whereMonth('data', '03')->whereYear('data', date('Y'))->count(),
            'abr'          => $request->id ? $this->chamada->where(['turma_id' => $request->id, 'igreja_id' => User::getIgreja()->id])->whereMonth('data', '04')->whereYear('data', date('Y'))->count() : $this->chamada->where('igreja_id', User::getIgreja()->id)->whereMonth('data', '04')->whereYear('data', date('Y'))->count(),
            'mai'          => $request->id ? $this->chamada->where(['turma_id' => $request->id, 'igreja_id' => User::getIgreja()->id])->whereMonth('data', '05')->whereYear('data', date('Y'))->count() : $this->chamada->where('igreja_id', User::getIgreja()->id)->whereMonth('data', '05')->whereYear('data', date('Y'))->count(),
            'jun'          => $request->id ? $this->chamada->where(['turma_id' => $request->id, 'igreja_id' => User::getIgreja()->id])->whereMonth('data', '06')->whereYear('data', date('Y'))->count() : $this->chamada->where('igreja_id', User::getIgreja()->id)->whereMonth('data', '06')->whereYear('data', date('Y'))->count(),
            'jul'          => $request->id ? $this->chamada->where(['turma_id' => $request->id, 'igreja_id' => User::getIgreja()->id])->whereMonth('data', '07')->whereYear('data', date('Y'))->count() : $this->chamada->where('igreja_id', User::getIgreja()->id)->whereMonth('data', '07')->whereYear('data', date('Y'))->count(),
            'ago'          => $request->id ? $this->chamada->where(['turma_id' => $request->id, 'igreja_id' => User::getIgreja()->id])->whereMonth('data', '08')->whereYear('data', date('Y'))->count() : $this->chamada->where('igreja_id', User::getIgreja()->id)->whereMonth('data', '08')->whereYear('data', date('Y'))->count(),
            'set'          => $request->id ? $this->chamada->where(['turma_id' => $request->id, 'igreja_id' => User::getIgreja()->id])->whereMonth('data', '09')->whereYear('data', date('Y'))->count() : $this->chamada->where('igreja_id', User::getIgreja()->id)->whereMonth('data', '09')->whereYear('data', date('Y'))->count(),
            'out'          => $request->id ? $this->chamada->where(['turma_id' => $request->id, 'igreja_id' => User::getIgreja()->id])->whereMonth('data', '10')->whereYear('data', date('Y'))->count() : $this->chamada->where('igreja_id', User::getIgreja()->id)->whereMonth('data', '10')->whereYear('data', date('Y'))->count(),
            'nov'          => $request->id ? $this->chamada->where(['turma_id' => $request->id, 'igreja_id' => User::getIgreja()->id])->whereMonth('data', '11')->whereYear('data', date('Y'))->count() : $this->chamada->where('igreja_id', User::getIgreja()->id)->whereMonth('data', '11')->whereYear('data', date('Y'))->count(),
            'dez'          => $request->id ? $this->chamada->where(['turma_id' => $request->id, 'igreja_id' => User::getIgreja()->id])->whereMonth('data', '12')->whereYear('data', date('Y'))->count() : $this->chamada->where('igreja_id', User::getIgreja()->id)->whereMonth('data', '12')->whereYear('data', date('Y'))->count(),
        ]);
    }
}
