<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Quiz;

class DeleteQuizController extends Controller
{
    public function __invoke(Quiz $quiz)
    {
        $quiz->delete();
        toastr('Quiz deletado com sucesso!', 'success', 'Feito!');

        return redirect()->route('quiz.index');
    }
}
