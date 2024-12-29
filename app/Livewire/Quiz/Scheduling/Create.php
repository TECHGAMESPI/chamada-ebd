<?php

namespace App\Livewire\Quiz\Scheduling;

use App\Models\{Quiz, Turma};
use Livewire\Component;

class Create extends Component
{
    public Quiz $quiz;

    public $classes;

    public $class;

    public $start_date;

    public $end_date;

    protected array $rules = [
        'class'      => 'required',
        'start_date' => 'required',
        'end_date'   => 'required',
    ];

    protected array $messages = [
        'required' => 'Campo obrigatório',
    ];

    public function mount()
    {
        $this->classes = Turma::where('igreja_id', getChurch()->id)->get();
    }

    public function render()
    {
        return view('livewire.quiz.scheduling.create');
    }

    public function store()
    {
        $this->validate();

        if ($this->class == 'allClasses') {

            foreach ($this->classes as $class) {
                $this->quiz->schedulings()->create([
                    'user_id'    => auth()->user()->id,
                    'igreja_id'  => getChurch()->id,
                    'turma_id'   => $class->id,
                    'start_date' => $this->start_date,
                    'end_date'   => $this->end_date,
                ]);
            }

            return redirect()->route('quiz.scheduling.create', $this->quiz->id)->with('success', 'Agendamento criado com sucesso');
        }

        $this->quiz->schedulings()->create([
            'user_id'    => auth()->user()->id,
            'igreja_id'  => getChurch()->id,
            'turma_id'   => $this->class,
            'start_date' => $this->start_date,
            'end_date'   => $this->end_date,
        ]);

        return redirect()->route('quiz.scheduling.index', $this->quiz->id)->with('success', 'Agendamento criado com sucesso');
    }
}
