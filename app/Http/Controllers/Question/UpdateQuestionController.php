<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class UpdateQuestionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate(
            [
                'body' => 'required',
            ]
        );

        $question = Question::findOrFail($request->question);

        $question->update(
            [
                'body' => $request->body,
            ]
        );

        toastr()->AddSuccess('Questão atualizada com sucesso!', 'Feito!');

        return redirect()->route('question.show', [$question->quiz, $question]);
    }
}
