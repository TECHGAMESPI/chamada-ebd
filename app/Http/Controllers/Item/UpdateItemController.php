<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class UpdateItemController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $question = Question::find($request->question);
        $item     = $question->items()->find($request->item);

        $request->validate(
            [
                'body'       => 'required',
                'is_correct' => 'required',
            ]
        );

        $item->update(
            [
                'body'       => $request->body,
                'is_correct' => $request->is_correct,
            ]
        );

        toastr()->AddSuccess('Item atualizado com sucesso!', 'Feito!');

        return redirect()->route('question.show', ['question' => $item->question_id, 'quiz' => $question->quiz_id]);
    }
}
