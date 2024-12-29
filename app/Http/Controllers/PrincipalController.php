<?php

namespace App\Http\Controllers;

use App\Models\{AlunoPorTurma, Chamada, Perfil, ProfessorPorTurma, Turma, User, UsuariosPorIgreja};
use Illuminate\Support\Facades\Auth;

class PrincipalController extends Controller
{
    private Chamada $chamada;

    private AlunoPorTurma $alunoPorTurma;

    public function __construct(Chamada $chamada, AlunoPorTurma $alunoPorTurma)
    {
        $this->chamada       = $chamada;
        $this->alunoPorTurma = $alunoPorTurma;
    }

    public function index()
    {
        $assiduos = UsuariosPorIgreja::where('igreja_id', User::getIgreja()->id)->get();
        $collect  = collect();
        $assiduos->map(function (UsuariosPorIgreja $user) use (&$collect) {

            if ($user->user->perfil_id == Perfil::ALUNO) {
                $name    = explode(" ", $user->user->name);
                $usuario = [
                    'name'      => $name[0],
                    'photo'     => $user->user->path_photo,
                    'presencas' => $user->user->presencasAnoCorrente(null),
                    'pontos'    => $user->user->xp->points,
                ];

                $collect->push((object) $usuario);
            }
        });

        return view('user.home', [
            'turmas'       => AlunoPorTurma::where('user_id', Auth::user()->id)->get(),
            'presencas'    => $this->chamada->where(['aluno_id' => Auth::user()->id])->whereYear('data', date('Y'))->count(),
            'jan'          => Auth::user()->perfil_id != Perfil::ADMINISTRADOR ? $this->chamada->whereMonth('data', '01')->whereYear('data', date('Y'))->where('igreja_id', User::getIgreja()->id)->count() : $this->chamada->whereMonth('data', '01')->whereYear('data', date('Y'))->count(),
            'fev'          => Auth::user()->perfil_id != Perfil::ADMINISTRADOR ? $this->chamada->whereMonth('data', '02')->whereYear('data', date('Y'))->where('igreja_id', User::getIgreja()->id)->count() : $this->chamada->whereMonth('data', '02')->whereYear('data', date('Y'))->count(),
            'mar'          => Auth::user()->perfil_id != Perfil::ADMINISTRADOR ? $this->chamada->whereMonth('data', '03')->whereYear('data', date('Y'))->where('igreja_id', User::getIgreja()->id)->count() : $this->chamada->whereMonth('data', '03')->whereYear('data', date('Y'))->count(),
            'abr'          => Auth::user()->perfil_id != Perfil::ADMINISTRADOR ? $this->chamada->whereMonth('data', '04')->whereYear('data', date('Y'))->where('igreja_id', User::getIgreja()->id)->count() : $this->chamada->whereMonth('data', '04')->whereYear('data', date('Y'))->count(),
            'mai'          => Auth::user()->perfil_id != Perfil::ADMINISTRADOR ? $this->chamada->whereMonth('data', '05')->whereYear('data', date('Y'))->where('igreja_id', User::getIgreja()->id)->count() : $this->chamada->whereMonth('data', '05')->whereYear('data', date('Y'))->count(),
            'jun'          => Auth::user()->perfil_id != Perfil::ADMINISTRADOR ? $this->chamada->whereMonth('data', '06')->whereYear('data', date('Y'))->where('igreja_id', User::getIgreja()->id)->count() : $this->chamada->whereMonth('data', '06')->whereYear('data', date('Y'))->count(),
            'jul'          => Auth::user()->perfil_id != Perfil::ADMINISTRADOR ? $this->chamada->whereMonth('data', '07')->whereYear('data', date('Y'))->where('igreja_id', User::getIgreja()->id)->count() : $this->chamada->whereMonth('data', '07')->whereYear('data', date('Y'))->count(),
            'ago'          => Auth::user()->perfil_id != Perfil::ADMINISTRADOR ? $this->chamada->whereMonth('data', '08')->whereYear('data', date('Y'))->where('igreja_id', User::getIgreja()->id)->count() : $this->chamada->whereMonth('data', '08')->whereYear('data', date('Y'))->count(),
            'set'          => Auth::user()->perfil_id != Perfil::ADMINISTRADOR ? $this->chamada->whereMonth('data', '09')->whereYear('data', date('Y'))->where('igreja_id', User::getIgreja()->id)->count() : $this->chamada->whereMonth('data', '09')->whereYear('data', date('Y'))->count(),
            'out'          => Auth::user()->perfil_id != Perfil::ADMINISTRADOR ? $this->chamada->whereMonth('data', '10')->whereYear('data', date('Y'))->where('igreja_id', User::getIgreja()->id)->count() : $this->chamada->whereMonth('data', '10')->whereYear('data', date('Y'))->count(),
            'nov'          => Auth::user()->perfil_id != Perfil::ADMINISTRADOR ? $this->chamada->whereMonth('data', '11')->whereYear('data', date('Y'))->where('igreja_id', User::getIgreja()->id)->count() : $this->chamada->whereMonth('data', '11')->whereYear('data', date('Y'))->count(),
            'dez'          => Auth::user()->perfil_id != Perfil::ADMINISTRADOR ? $this->chamada->whereMonth('data', '12')->whereYear('data', date('Y'))->where('igreja_id', User::getIgreja()->id)->count() : $this->chamada->whereMonth('data', '12')->whereYear('data', date('Y'))->count(),
            'adolescentes' => $this->alunoPorTurma->where('turma_id', 1)->count(),
            'adultos'      => $this->alunoPorTurma->where('turma_id', 2)->count(),
            'discipulado'  => $this->alunoPorTurma->where('turma_id', 3)->count(),
            'jInfancia'    => $this->alunoPorTurma->where('turma_id', 4)->count(),
            'jovens'       => $this->alunoPorTurma->where('turma_id', 5)->count(),
            'juniores'     => $this->alunoPorTurma->where('turma_id', 6)->count(),
            'primarios'    => $this->alunoPorTurma->where('turma_id', 14)->count(),
            'title'        => 'Dashboard',
            'igreja'       => UsuariosPorIgreja::where('user_id', Auth::user()->id)->first(),
            'assiduos'     => $collect->sortByDesc('pontos')->take(6),
        ]);
    }
}
