<?php

namespace App\Http\Controllers;

use App\Helper\Helpers;
use App\Models\{AlunoPorTurma, Perfil, ProfessorPorTurma, Turma, User, UsuariosPorIgreja};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlunosPorTurmaController extends Controller
{
    use Helpers;

    private User $user;

    private AlunoPorTurma $alunoPorTurma;

    private Turma $turma;

    private ProfessorPorTurma $professorPorTurma;

    public function __construct(User $user, AlunoPorTurma $alunoPorTurma, Turma $turma, ProfessorPorTurma $professorPorTurma)
    {
        $this->user              = $user;
        $this->alunoPorTurma     = $alunoPorTurma;
        $this->turma             = $turma;
        $this->professorPorTurma = $professorPorTurma;
    }

    public function index()
    {
        $alunosPorTurma = $this->alunoPorTurma::where('igreja_id', User::getIgreja()->id)->get();
        $usuario        = $this->user;
        $turma          = $this->turma;

        return view('user.aluno-por-turma', ['turma' => $turma, 'usuario' => $usuario, 'title' => 'Alunos Por Turma', 'alunosPorTurma' => $alunosPorTurma]);
    }

    public function create()
    {
        $turmas = $this->turma->where(['igreja_id' => User::getIgreja()->id, 'is_active' => true])->get();

        $alunos = $this->user->all();
        $alunos = UsuariosPorIgreja::where('igreja_id', User::getIgreja()->id)->get();

        if (Auth::user()->perfil_id == Perfil::PROFESSOR) {
            $turmas = $this->getTurmas();
        }

        return view('user.novo-aluno-por-turma', ['turmas' => $turmas, 'alunos' => $alunos, 'title' => 'Aluno por turma']);
    }

    public function store(Request $request)
    {
        $alunoPorTurma = $this->alunoPorTurma;

        if ($alunoPorTurma->where([
            'user_id'  => $request->aluno,
            'turma_id' => $request->turma,
        ])->first()) {
            toastr()->addError('Aluno já está associado a essa turma', 'Erro');

            return redirect()->back();
        }

        $user = User::find($request->aluno);
        $alunoPorTurma->create([
            'user_id'   => $request->aluno,
            'turma_id'  => $request->turma,
            'igreja_id' => (UsuariosPorIgreja::where('user_id', $user->id)->first()->igreja)->id,
            'name'      => $user->name,
        ]);
        toastr()->addSuccess('Aluno associado com sucesso!', 'Feito!');

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        try {
            $turma = $request->turma_id;
            $aluno = $request->aluno_id;

            $alunoPorTurma = $this->alunoPorTurma->where(['user_id' => $aluno, 'turma_id' => $turma])->get()->first();

            $alunoPorTurma->delete();

            toastr()->addSuccess('Aluno desassociado com sucesso!', 'Feito!');

            return redirect()->back();
        } catch (Exception $e) {
            toastr()->addError('Erro ao tentar desassociar aluno', 'Erro');

            return redirect()->back();
        }
    }
}
