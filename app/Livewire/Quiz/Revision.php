<?php

namespace App\Livewire\Quiz;

use App\Models\Quiz;
use Livewire\{Component, WithPagination};

class Revision extends Component
{
    use WithPagination;

    public Quiz $quiz;

    public function render()
    {
        $questions = $this->quiz->questions()->with('items')->paginate(1);

        return view('livewire.quiz.revision', compact('questions'));
    }

    public function answer($question, $item)
    {
        session()->put("quiz.{$this->quiz->id}.{$question}", $item);
    }

    public function answered($question, $item): bool
    {
        return session()->has("quiz.{$this->quiz->id}.{$question}") && session()->get("quiz.{$this->quiz->id}.{$question}") == $item;
    }

    public function countQuestions()
    {
        $session = session()->has("quiz.{$this->quiz->id}") ? count(session()->get("quiz.{$this->quiz->id}")) : 0;

        return $this->quiz->questions()->count() == $session;
    }
}
