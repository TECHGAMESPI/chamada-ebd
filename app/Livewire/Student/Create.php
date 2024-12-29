<?php

namespace App\Livewire\Student;

use App\Models\{Perfil, Turma, User, UsuariosPorIgreja};
use Livewire\{Component, WithPagination};

class Create extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perpage = 5;

    public string $search = '';

    public function render()
    {
        $turmas = Turma::where(['igreja_id' => auth()->user()->getIgreja()->id, 'is_active' => true])->orderBy('nome_turma', 'ASC')->get();
        $alunos = UsuariosPorIgreja::where('igreja_id', User::getIgreja()->id)
            ->join('users', 'usuarios_por_igrejas.user_id', 'users.id')
            ->where('users.name', 'LIKE', '%' . $this->search . '%')
            ->orderBy('users.name', 'ASC')
            ->paginate($this->perpage);

        if (auth()->user()->perfil_id == Perfil::PROFESSOR) {
            $turmas = $this->getTurmas();
        }

        return view('livewire.student.create', ['turmas' => $turmas, 'alunos' => $alunos]);
    }
}
