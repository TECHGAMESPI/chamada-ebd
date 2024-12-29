<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\{AlunoPorTurma, Igreja, Perfil, ProfessorPorTurma, Turma, User, UsuariosPorIgreja};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    private $turma;

    private $perfil;

    private $alunoPorTurma;

    private $professorPorTurma;

    private UsuariosPorIgreja $igreja;

    public function __construct(
        Turma $turma,
        Perfil $perfil,
        AlunoPorTurma $alunoPorTurma,
        ProfessorPorTurma $professorPorTurma,
        UsuariosPorIgreja $igreja
    ) {
        $this->turma             = $turma;
        $this->perfil            = $perfil;
        $this->alunoPorTurma     = $alunoPorTurma;
        $this->professorPorTurma = $professorPorTurma;
        $this->igreja            = $igreja;
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $turmas = $this->turma::all();
        $perfis = $this->perfil::all();

        return view('auth.registrar', ['turmas' => $turmas, 'perfis' => $perfis, 'title' => 'Novo usuário']);
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function registrarAluno()
    {
        $repositorioTurmas = $this->turma;
        $turmas            = $this->professorPorTurma->where('professor_id', Auth::user()->id)->get();

        return view('auth.registrar-aluno', ['turmas' => $turmas, 'title' => 'Novo aluno', 'repositorioTurmas' => $repositorioTurmas]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'perfil_id'       => ['required'],
            'estado_civil'    => ['required', 'string'],
            'data_nascimento' => ['required', 'date'],
            'turma_id'        => ['required'],
            'password'        => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            $user = User::create([
                'name'            => $request->name,
                'email'           => $request->email,
                'perfil_id'       => $request->perfil_id,
                'estado_civil'    => $request->estado_civil,
                'data_nascimento' => $request->data_nascimento,
                'turma_id'        => $request->turma_id,
                'password'        => Hash::make($request->password),
                'telefone'        => $request->telefone,
            ]);

            //Associando primera turma do aluno
            $this->alunoPorTurma->create([
                'user_id'  => $user->id,
                'turma_id' => $request->turma_id,
                'name'     => $user->name,
            ]);

            $this->igreja->create(['user_id' => $user->id, 'igreja_id' => User::getIgreja()->id]);
        } catch (Exception $e) {
            return back()->with('error', 'Não foi possível incluir o usuário');
        }

        return redirect()
            ->back()
            ->with('success', 'Usuário inserido com sucesso');
    }
}
