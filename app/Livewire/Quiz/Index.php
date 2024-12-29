<?php

namespace App\Livewire\Quiz;

use App\Models\{Perfil, Quiz};
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;

    public int $perpage = 5;

    public string $search = '';

    public function render()
    {
        $quizzes = Quiz::where('igreja_id', getChurch()->id);

        if (auth()->user()->perfil_id == Perfil::ALUNO) {
            $quizzes->where('is_draft', false);
        }

        if (auth()->user()->perfil_id == Perfil::PROFESSOR) {
            $quizzes->where('is_draft', false)->orWhere('owner_id', auth()->user()->id);
        }

        return view('livewire.quiz.index', [
            'quizzes' => $quizzes->where('title', 'LIKE', '%' . $this->search . '%')->paginate($this->perpage),
        ]);
    }
}
