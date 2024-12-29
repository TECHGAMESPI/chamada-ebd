<?php

namespace App\Livewire\Quiz\Question;

use App\Models\Quiz;
use Livewire\Component;

class Create extends Component
{
    public Quiz $quiz;

    public function render()
    {
        return view('livewire.quiz.question.create');
    }
}
