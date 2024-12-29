<?php

namespace App\Livewire\Quiz\Question;

use App\Models\{Question, Quiz};
use Livewire\Component;

class Show extends Component
{
    public Quiz $quiz;

    public Question $question;
    public function render()
    {
        return view('livewire.quiz.question.show');
    }
}
