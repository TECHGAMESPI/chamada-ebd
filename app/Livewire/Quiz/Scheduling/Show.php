<?php

namespace App\Livewire\Quiz\Scheduling;

use App\Models\{Quiz, Scheduling};
use Livewire\Component;

class Show extends Component
{
    public Quiz $quiz;

    public function render()
    {
        return view('livewire.quiz.scheduling.show');
    }

    public function delete(Scheduling $scheduling)
    {
        $scheduling->delete();

        return redirect()->route('quiz.scheduling.show', $this->quiz)->with('success', 'Agendamento deletado com sucesso!');
    }

}
