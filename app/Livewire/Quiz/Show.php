<?php

namespace App\Livewire\Quiz;

use App\Models\Quiz;
use Livewire\Component;

class Show extends Component
{
    public Quiz $quiz;

    public function render()
    {
        return view('livewire.quiz.show');
    }

    public function changeStatus()
    {
        $this->quiz->questions->count() > 0 ? $this->quiz->update([
            'is_draft' => !$this->quiz->is_draft,
        ]) : $this->addError('is_draft', 'O Quiz precisa de questões para mudar de status.');
    }
}
