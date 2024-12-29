<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $question = Question::find($request->question);

        $request->validate(
            [
                'body'       => 'required',
                'is_correct' => 'required',
            ]
        );

        $question->items()->create(
            [
                'body'       => $request->body,
                'is_correct' => $request->is_correct,
            ]
        );

        toastr()->AddSuccess('Alternativa criada com sucesso!', 'Feito!');

        return to_route('item.create', ['quiz' => $question->quiz->id, 'question' => $question->id]);
    }
}
