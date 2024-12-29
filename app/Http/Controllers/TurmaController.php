<?php

namespace App\Http\Controllers;

use App\Models\{Chamada, Igreja, Turma, User};
use Exception;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    private Turma $turma;

    private User $user;

    public function __construct(Turma $turma, User $user)
    {
        $this->turma = $turma;
        $this->user  = $user;
    }

    public function index()
    {
        $turmas = $this->turma::where('igreja_id', $this->user::getIgreja()->id)->get();

        return view('user.turmas', ['turmas' => $turmas, 'title' => 'Turmas']);
    }

    public function create()
    {
        return view('user.turma', ['title' => 'Nova Turma']);
    }

    public function store(Request $request)
    {
        $request->validate(['nome_turma' => 'required|string'], ["nome_turma.required" => 'O campo é obrigatório']);
        $this->turma->create([
            'nome_turma' => $request->nome_turma,
            'igreja_id'  => $this->user::getIgreja()->id,
        ]);

        return redirect('user/turma')->with('success', 'Turma registrada com sucesso!');
    }

    public function destroy(Request $request)
    {
        try {
            $turma = $this->turma->find($request->turma_id);
            $turma->delete();
            toastr()->addSuccess('Turma apagada com sucesso!', 'Feito!');

            return redirect('user/turmas');
        } catch (Exception $e) {
            toastr()->addError('Não foi possível apagar a turma!', 'Erro!');

            return redirect()->back();
        }
    }

    public function editar($id)
    {
        $turma = $this->turma->find($id);

        if (is_null($turma)) {
            return view('user.turmas')->with('danger', 'Houve algum problema, não encontrei a turma.');
        }

        return view('user.editar-turma', ['title' => 'Editar Turma', 'turma' => $turma]);
    }

    public function update($id, Request $request)
    {
        $turma = $this->turma->find($id);

        $request->validate(['nome_turma' => 'required|string'], ["nome_turma.required" => 'O campo é obrigatório']);

        $turma->nome_turma = $request->nome_turma;
        $turma->save();

        toastr()->addSuccess('Turma atualizada com sucesso!', 'Feito!');

        return redirect()->back();
    }
}
