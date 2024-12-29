<?php

namespace App\Http\Controllers;

use App\Models\{Igreja, Perfil, ProfessorPorTurma, Turma, User, UsuariosPorIgreja};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessorPorTurmaController extends Controller
{
    private ProfessorPorTurma $professorPorTurma;

    private Turma $turma;

    private User $user;

    public function __construct(ProfessorPorTurma $professorPorTurma, Turma $turma, User $user)
    {
        $this->professorPorTurma = $professorPorTurma;
        $this->turma             = $turma;
        $this->user              = $user;
    }

    public function index()
    {

        return view('user.professor-por-turma', [
            'professores' => $this->professorPorTurma::where('igreja_id', $this->user::getIgreja()->id)->get(),
            'title'       => 'Professor por turma',
        ]);
    }

    public function create()
    {
        $turmas = $this->turma->where(['igreja_id' => $this->user::getIgreja()->id, 'is_active' => true])->get();

        $professores = UsuariosPorIgreja::where('igreja_id', $this->user::getIgreja()->id)
            ->join('users', 'usuarios_por_igrejas.user_id', '=', 'users.id')
            ->orderBy('users.name', 'ASC')
            ->select('users.*')
            ->where('perfil_id', '!=', Perfil::ALUNO)
            ->get();

        return view(
            'user.novo-professor-por-turma',
            [
                'turmas'      => $turmas,
                'professores' => $professores,
                'title'       => 'Associar Professor',
            ]
        );
    }

    public function store(Request $request)
    {
        $professorPorTurma = $this->professorPorTurma;

        if (count($professorPorTurma->where([
            'professor_id' => $request->professor,
            'turma_id'     => $request->turma,
        ])->get()) == 1) {
            return redirect()->back()->withErrors('Professor já associado nessa turma!');
        }

        $professorPorTurma->create([
            'professor_id' => $request->professor,
            'turma_id'     => $request->turma,
            'igreja_id'    => $this->user::getIgreja()->id,
        ]);

        return redirect()->back()->with('success', 'Professor associado com sucesso!');
    }

    public function atualizaTurma(Request $request)
    {
        $usuario = $this->user->find(Auth::user()->id);

        $usuario->update([
            'turma_id' => $request->id,
        ]);

        return redirect('user/home')->with('success', 'Turma atualizada com sucesso!');
    }

    public function destroy(Request $request)
    {

        $turma     = $request->turma_id;
        $professor = $request->professor_id;

        $professorPorTurma = $this->professorPorTurma->where(['professor_id' => $professor, 'turma_id' => $turma])->get()->first();

        $professorPorTurma->delete();

        return redirect()->back()->with('success', 'Professor desassociado com sucesso!');
    }
}
