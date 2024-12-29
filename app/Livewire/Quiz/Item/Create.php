<?php

namespace App\Livewire\Quiz\Item;

use App\Models\{Question, Quiz};
use Livewire\Component;

class Create extends Component
{
    public Quiz $quiz;

    public Question $question;

    public function render()
    {

        return view('livewire.quiz.item.create');
    }
}
