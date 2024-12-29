<?php

namespace App\Livewire\Quiz;

use App\Models\Quiz;
use Illuminate\Support\Str;
use Livewire\Component;

class Edit extends Component
{
    public $title;

    public $type;

    public Quiz $quiz;

    protected $rules = [
        'title' => 'required',
        'type'  => 'required',
    ];

    protected $messages = [
        'title.required' => 'O campo título é obrigatório.',
        'type.required'  => 'O campo tipo é obrigatório.',
    ];

    public function mount()
    {
        $this->title = $this->quiz->title;
        $this->type  = $this->quiz->type;
    }

    public function render()
    {
        return view('livewire.quiz.edit');
    }

    public function update()
    {
        $this->validate();
        $this->quiz->update([
            'title' => $this->title,
            'type'  => $this->type,
            'slug'  => Str::slug($this->title),
        ]);

        toastr()->AddSuccess('Quiz atualizado com sucesso!', 'Feito!');

        return redirect()->route('quiz.show', $this->quiz);
    }
}
