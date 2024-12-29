<?php

namespace App\Livewire\Quiz;

use App\Models\Quiz;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public $title;

    public $type;

    protected $rules = [
        'title' => 'required',
        'type'  => 'required',
    ];

    protected $messages = [
        'title.required' => 'O campo título é obrigatório.',
        'type.required'  => 'O campo tipo é obrigatório.',
    ];

    public function render()
    {
        return view('livewire.quiz.create');
    }

    public function store()
    {
        $this->validate();

        $quiz = Quiz::create([
            'title'     => $this->title,
            'type'      => $this->type,
            'igreja_id' => getChurch()->id,
            'slug'      => Str::slug($this->title),
            'is_draft'  => true,
            'owner_id'  => auth()->user()->id,
        ]);

        toastr()->AddSuccess('Quiz criado com sucesso!', 'Feito!');

        return redirect()->route('question.create', ['quiz' => $quiz->id]);
    }
}
