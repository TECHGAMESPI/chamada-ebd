<?php

namespace App\Livewire\Quiz;

use App\Models\{Item, Quiz};
use Livewire\Component;

class Response extends Component
{
    public Quiz $quiz;

    public $score = 0;

    public $template;

    public function mount()
    {
        $this->template = session()->get("quiz.{$this->quiz->id}");
        $this->result();
    }

    public function render()
    {
        return view('livewire.quiz.response');
    }

    public function result()
    {

        if (!$this->template) {

            return redirect()->route('quiz.show', ['quiz' => $this->quiz->id]);
        }

        foreach ($this->template as $question => $item) {
            if ($this->quiz->questions()->find($question)->items()->where('id', $item)->first()->is_correct) {
                $this->score++;
            }
        }

        //session()->forget("quiz.{$this->quiz->id}");
    }

    public function wrongAnswer($question, $item): bool
    {
        $item = Item::find($item);

        return $this->template[$question] == $item->id && !$item->is_correct;
    }
}
