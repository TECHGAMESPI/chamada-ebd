<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class DeleteQuestionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $question = Question::findOrFail($request->question);

        $question->delete();

        toastr()->AddSuccess('Questão deletada com sucesso!', 'Feito!');

        return redirect()->route('quiz.show', $question->quiz);
    }
}
