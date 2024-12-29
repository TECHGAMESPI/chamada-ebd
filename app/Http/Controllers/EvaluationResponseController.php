<?php

namespace App\Http\Controllers;

use App\Models\{Quiz, ResponseQuiz};
use Illuminate\Http\Request;

class EvaluationResponseController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Quiz $quiz)
    {
        ResponseQuiz::create(
            [
                'quiz_id'     => $quiz->id,
                'user_id'     => auth()->user()->id,
                'template'    => session()->get("quiz.{$quiz->id}") ?? [],
                'score'       => $this->result($quiz),
                'is_finished' => true,
            ]
        );

        return view('livewire.quiz.evaluation');
    }

    protected function result(Quiz $quiz): int
    {
        $template = session()->get("quiz.{$quiz->id}");
        $score    = 0;

        foreach ($template as $question => $item) {
            if ($quiz->questions()->find($question)->items()->where('id', $item)->first()->is_correct) {
                $score++;
            }
        }

        return $score;
    }
}
