<?php

namespace App\Livewire;

use App\Helper\Helpers;
use App\Jobs\XPJob;
use App\Models\{AlunoPorTurma, Chamada as ChamadaModel, Turma, User, Visitante};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Session, DB};
use Livewire\{Component, WithPagination};

class Chamada extends Component
{
    use Helpers;
    use WithPagination;

    public $perpage = 15;

    public $data;

    public $search;

    public $turmaAtual;

    public $minhasTurmas;

    public $turmas;

    public $nomeTurma;

    public $professor;

    public $turma;

    public $livro;

    public $material;

    public $visitante_nome;
    public $visitante_quantidade;
    public $visitante_biblias;

    public $editando_visitante = false;
    public $visitante_id;

    protected function rules()
    {
        return [
            'data' => 'required',

        ];
    }

    protected $messages = ['data.required' => 'A data é obrigatória!'];

    public function mount(Request $request)
    {
        $turmas = $this->getTurmas();

        if (is_null($turmas->first())) {
            toastr()->addError('Não foi encontrado nenhuma turma', 'Erro');

            return redirect('/user/home');
        }

        $turma = $turmas->first();

        $this->minhasTurmas = $turmas;
        $this->nomeTurma    = $turma->nome_turma;
        $this->data         = date('Y-m-d');
        $this->turmaAtual   = $turma->id;
        $this->turma        = $turmas->first();

        if ($request->id) {
            $this->turmaAtual = $request->id;
            $this->turma      = Turma::find($request->id);
        }

        $this->turmas   = Turma::where(['igreja_id' => User::getIgreja()->id, 'is_active' => true])->orderBy('nome_turma', 'ASC')->get();
        $this->livro   = false;
        $this->material = true;
    }

    public function render()
    {
        return view(
            'livewire.chamada',
            [
                'alunos' => AlunoPorTurma::whereHas('user', function ($query) {
                    $query->where('is_active', true);
                })
                    ->where(['turma_id' => $this->turmaAtual])->where('name', 'like', '%' . $this->search . '%')
                    ->orderBy('name', 'ASC')
                    ->paginate($this->perpage),
            ]
        );
    }

    public function store(int $aluno_id, bool $absence = false)
    {
        $this->validate();
        $chamada = ChamadaModel::where(['aluno_id' => $aluno_id, 'data' => $this->data])->first();

        if ($chamada) {
            Session::flash('error', 'Não foi possível registrar a presença. Aluno já tem a presença em outra turma hoje.');

            return;
        }
        $chamada = ChamadaModel::create([
            'data'              => $this->data,
            'professor_id'      => Auth::user()->id,
            'turma_id'          => $this->turmaAtual,
            'aluno_id'          => $aluno_id,
            'livro'            => $this->livro,
            'falta_justificada' => $absence,
            'material'          => $this->material,
            'igreja_id'         => User::getIgreja()->id,
        ]);

        $user = User::find($aluno_id);

        if ($absence === true) {
            $this->restauraValoreslivromaterial();
            XPJob::dispatch($user, 2);
            Session::flash('warning', 'Falta justificada registrada com sucesso.');

            return;
        }

        if ($this->livro === true) {
            $this->restauraValoreslivromaterial();
            XPJob::dispatch($user, 7);

            Session::flash('warning', 'livro registrado com sucesso');

            return;
        }

        $this->restauraValoreslivromaterial();

        XPJob::dispatch($user, 10);

        Session::flash('success', 'Presença registrada com sucesso!');

    }

    public function destroy($aluno_id)
    {
        try {
            $chamada = ChamadaModel::where(['aluno_id' => $aluno_id, 'turma_id' => $this->turmaAtual, 'data' => $this->data])->first();
            $chamada->delete();
            $user = User::find($aluno_id);

            if ($chamada->livro) {
                XPJob::dispatch($user, -7);
                Session::flash('success', 'Presença apagada com sucesso!');

                return;
            }

            if ($chamada->falta_justificada) {
                XPJob::dispatch($user, -2);
                Session::flash('success', 'Presença apagada com sucesso!');

                return;
            }

            XPJob::dispatch($user, -10);

            Session::flash('success', 'Presença registrada com sucesso!');
        } catch (Exception $e) {

            Session::flash('error', 'Não foi possível excluir. Por favor, procure a superintendência.');

            return;
        }
    }

    public function registralivro(): void
    {

        if ($this->livro == false) {

            $this->livro = true;

            return;
        }

        if ($this->livro == true) {
            $this->livro = false;

            return;
        }
    }

    public function registramaterial()
    {

        if ($this->material == true) {
            $this->material = false;

            return;
        }

        if ($this->material == false) {
            $this->material = true;

            return;
        }
    }

    public function restauraValoreslivromaterial()
    {
        $this->livro   = false;
        $this->material = true;
    }

    public function verificaPresenca($user_id)
    {
        try {
            return ChamadaModel::where(['aluno_id' => $user_id, 'turma_id' => $this->turmaAtual, 'data' => $this->data])->first();
        } catch (Exception $e) {

            Session::flash('error', 'Ocorreu um erro! Verifique se a data está preenchida normalmente');

            return;
        }
    }

    public function resetFields()
    {
        $this->visitante_quantidade = null;
        $this->visitante_biblias = null;
        $this->editando_visitante = false;
    }

    public function storeVisitantes()
    {
        $this->validate([
            'visitante_quantidade' => 'required|numeric|min:1',
            'visitante_biblias' => 'required|numeric|min:0|lte:visitante_quantidade',
        ]);

        $visitante = Visitante::create([
            'turma_id' => $this->turma->id,
            'data' => date('Y-m-d', strtotime($this->data)),
            'quantidade' => (int)$this->visitante_quantidade,
            'biblias' => (int)$this->visitante_biblias,
            'igreja_id' => User::getIgreja()->id,
        ]);

        \Log::info('Visitantes registrados:', [
            'quantidade' => $visitante->quantidade,
            'biblias' => $visitante->biblias,
            'turma' => $visitante->turma_id,
            'data' => $visitante->data
        ]);

        $this->resetFields();
        $this->dispatch('closeModal');
        session()->flash('message', 'Visitantes registrados com sucesso!');
        return redirect(request()->header('Referer'));
    }

    public function editarVisitantes($turma_id, $data)
    {
        $visitante = Visitante::where([
            'turma_id' => $turma_id,
            'data' => $data
        ])->first();

        if ($visitante) {
            $this->visitante_id = $visitante->id;
            $this->visitante_quantidade = $visitante->quantidade;
            $this->visitante_biblias = $visitante->biblias;
            $this->editando_visitante = true;
        }
    }

    public function updateVisitantes()
    {
        $this->validate([
            'visitante_quantidade' => 'required|numeric|min:1',
            'visitante_biblias' => 'required|numeric|min:0|lte:visitante_quantidade',
        ]);

        try {
            DB::beginTransaction();
            
            $visitante = Visitante::where([
                'turma_id' => $this->turma->id,
                'data' => date('Y-m-d', strtotime($this->data))
            ])->first();
            
            if (!$visitante) {
                throw new \Exception('Registro de visitantes não encontrado');
            }

            $visitante->quantidade = (int)$this->visitante_quantidade;
            $visitante->biblias = (int)$this->visitante_biblias;
            $visitante->save();

            DB::commit();

            \Log::info('Visitantes atualizados com sucesso:', [
                'id' => $visitante->id,
                'quantidade' => $visitante->quantidade,
                'biblias' => $visitante->biblias,
                'turma' => $visitante->turma_id,
                'data' => $visitante->data
            ]);

            $this->resetFields();
            $this->dispatch('closeModal');
            session()->flash('message', 'Visitantes atualizados com sucesso!');
            return redirect(request()->header('Referer'));

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erro ao atualizar visitantes:', [
                'error' => $e->getMessage(),
                'turma_id' => $this->turma->id,
                'data' => $this->data
            ]);
            session()->flash('error', 'Erro ao atualizar visitantes');
            return null;
        }
    }
}
