<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\{Question, Quiz};
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function __invoke(Quiz $quiz, Request $request)
    {
        $request->validate(
            [
                'body' => 'required',
            ]
        );
        $question = Question::create(
            [
                'body'    => $request->body,
                'quiz_id' => $quiz->id,
            ]
        );

        toastr()->AddSuccess('Questão criada com sucesso!', 'Feito!');

        return to_route('item.create', ['quiz' => $quiz->id, 'question' => $question->id]);
    }
}
