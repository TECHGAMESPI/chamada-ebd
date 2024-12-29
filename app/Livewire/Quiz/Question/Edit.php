<?php

namespace App\Livewire\Quiz\Question;

use App\Models\{Question, Quiz};
use Livewire\Component;

class Edit extends Component
{
    public Quiz $quiz;

    public Question $question;

    public $body;

    public function mount()
    {
        $this->body = $this->question->body;
    }

    public function render()
    {
        return view('livewire.quiz.question.edit');
    }
}
