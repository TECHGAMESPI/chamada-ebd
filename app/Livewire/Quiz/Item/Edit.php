<?php

namespace App\Livewire\Quiz\Item;

use App\Models\{Item, Question, Quiz};
use Livewire\Component;

class Edit extends Component
{
    public Quiz $quiz;

    public Question $question;

    public Item $item;

    public $body;

    public $is_correct;

    protected $rules = [
        'item.title'       => 'required|string',
        'item.description' => 'required|string',
    ];

    public function mount()
    {
        $this->body       = $this->item->body;
        $this->is_correct = $this->item->is_correct;
    }

    public function render()
    {
        return view('livewire.quiz.item.edit');
    }
}
