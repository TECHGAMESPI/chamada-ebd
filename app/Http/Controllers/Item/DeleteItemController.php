<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class DeleteItemController extends Controller
{
    public function __invoke(Request $request)
    {
        $item = Item::find($request->item);
        $item->delete();

        toastr()->addSuccess('Item deletado com sucesso!', 'Feito!');

        return redirect()->route('question.show', ['question' => $item->question_id, 'quiz' => $request->quiz]);
    }
}
