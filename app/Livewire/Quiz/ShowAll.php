<?php

namespace App\Livewire\Quiz;

use App\Models\Quiz;
use Livewire\Component;

class ShowAll extends Component
{
    public Quiz $quiz;

    public function render()
    {
        return view('livewire.quiz.show-all');
    }
}
