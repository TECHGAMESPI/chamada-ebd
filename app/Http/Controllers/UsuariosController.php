<?php

namespace App\Http\Controllers;

use App\Models\{AlunoPorTurma, Chamada, Perfil, ProfessorPorTurma, Turma, User, UsuariosPorIgreja};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{
    private Turma $turma;

    private User $user;

    private Perfil $perfil;

    private Chamada $chamada;

    private ProfessorPorTurma $professorPorTurma;

    private AlunoPorTurma $alunoPorTurma;

    public function __construct(
        Turma $turma,
        User $user,
        Perfil $perfil,
        Chamada $chamada,
        ProfessorPorTurma $professorPorTurma,
        AlunoPorTurma $alunoPorTurma
    ) {
        $this->turma             = $turma;
        $this->user              = $user;
        $this->perfil            = $perfil;
        $this->chamada           = $chamada;
        $this->professorPorTurma = $professorPorTurma;
        $this->alunoPorTurma     = $alunoPorTurma;
    }

    public function index()
    {
        $turma  = $this->turma->find(Auth::user()->turma_id);
        $perfil = $this->perfil;

        if (Auth::user()->perfil_id == Perfil::ADMINISTRADOR) {
            $usuarios = $this->user->all();
        } else {
            $usuarios = UsuariosPorIgreja::where('igreja_id', $this->user::getIgreja()->id)
                ->join('users', 'usuarios_por_igrejas.user_id', '=', 'users.id')
                ->orderBy('users.name', 'ASC')
                ->select('users.*')
                ->get();
        }

        //dd($usuarios);

        return view('user.usuarios', ['turma' => $turma, 'usuarios' => $usuarios, 'title' => 'Usuários', 'perfil' => $perfil]);
    }

    public function destroy($id)
    {
        try {
            $usuario   = $this->user->find($id);
            $professor = $this->professorPorTurma->where('professor_id', $usuario->id)->get();

            if ($professor->count() > 0) {

                $this->excluirProfessorPorTurma($professor);
            }

            $igreja = UsuariosPorIgreja::where('user_id', $id)->first();
            $igreja->delete();

            $alunosPorTurma = $this->alunoPorTurma->where('user_id', $usuario->id)->get();

            $this->deletaAlunoPorTurma($alunosPorTurma);

            $chamadas = $this->chamada->where('aluno_id', $usuario->id)->get();

            $this->excluirChamada($chamadas);

            $usuario->delete();

            return redirect()->back()->with('success', 'Usuário excluido com sucesso.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Não foi possível excluir');
        }
    }

    public function editarUsuario($id)
    {
        $usuario = $this->user->find($id);
        $perfil  = $this->perfil->find($usuario->perfil_id);
        $perfis  = $this->perfil->all();

        return view('user.editar-usuario', [
            'title'       => 'Editar Usuários',
            'usuario'     => $usuario,
            'perfis'      => $perfis,
            'perfilAtual' => $perfil,

            'telefone' => $usuario->telefone,
        ]);
    }

    public function update($id, Request $request)
    {
        $usuario = $this->user->find($id);

        $usuario->name            = $request->name;
        $usuario->email           = $request->email;
        $usuario->perfil_id       = $request->perfil_id;
        $usuario->data_nascimento = $request->data_nascimento;
        $usuario->estado_civil    = $request->estado_civil;
        $usuario->telefone        = $request->telefone;

        $usuario->save();

        return redirect()->back()->with('success', 'Usuário atualizado com sucesso!');
    }

    protected function excluirProfessorPorTurma($professores): void
    {
        foreach ($professores as $professor) {
            $professor->delete();
        }
    }

    protected function excluirChamada($chamadas): void
    {
        if ($chamadas->count() < 1) {
            return;
        }

        foreach ($chamadas as $chamada) {
            $chamada->delete();
        }
    }

    /**
     * @param $alunosPorTurma
     */
    protected function deletaAlunoPorTurma($alunosPorTurma): void
    {
        if ($alunosPorTurma->count() < 1) {
            return;
        }

        foreach ($alunosPorTurma as $alunoPorTurma) {
            $alunoPorTurma->delete();
        }
    }

    protected function atualizaAlunoPorTurma($usuario_id, $turma_id)
    {
        $alunoPorTurma = $this->alunoPorTurma;

        if (count($alunoPorTurma->where([
            'user_id'  => $usuario_id,
            'turma_id' => $turma_id,
        ])->get()) === 1) {
            // retorna nada caso o usuario já esteja associado a turma
            return false;
        }

        $alunoPorTurma->create([
            'user_id'  => $usuario_id,
            'turma_id' => $turma_id,
            'name'     => $this->user->find($usuario_id)->name,
        ]);

        return true;
    }
}
