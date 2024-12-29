<?php

namespace App\Livewire;

use App\Helper\Helpers;
use App\Jobs\XPJob;
use App\Models\{AlunoPorTurma, Chamada as ChamadaModel, Turma, User, Visitante};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Session};
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

    public $turma_id;

    protected function rules()
    {
        return [
            'data' => 'required',

        ];
    }

    protected $messages = ['data.required' => 'A data é obrigatória!'];

    public function mount($turma_id = null)
    {
        $this->turma_id = $turma_id;
        $this->data = date('Y-m-d');
        if ($this->turma_id) {
            $this->loadTurma();
        }
    }

    protected function loadTurma()
    {
        if ($this->turma_id) {
            $this->turma = \App\Models\Turma::find($this->turma_id);
        }
    }

    public function render()
    {
        $this->loadTurma();
        $visitantes = [];
        $turma = null;
        
        if ($this->turma) {
            $visitantes = Helpers::contaVisitantes($this->turma->id, $this->data);
            $turma = $this->turma;
        }
        
        return view('livewire.chamada', [
            'visitantes' => $visitantes,
            'turma' => $turma
        ]);
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

    protected function resetFields()
    {
        $this->visitante_quantidade = null;
        $this->visitante_biblias = null;
    }

    public function storeVisitantes()
    {
        $this->validate([
            'visitante_quantidade' => 'required|numeric|min:1',
            'visitante_biblias' => 'required|numeric|min:0|lte:visitante_quantidade',
        ]);

        Visitante::create([
            'turma_id' => $this->turma->id,
            'data' => date('Y-m-d', strtotime($this->data)),
            'quantidade' => $this->visitante_quantidade,
            'biblias' => $this->visitante_biblias,
            'igreja_id' => User::getIgreja()->id,
        ]);

        $this->resetFields();
        $this->dispatch('closeModal');
        session()->flash('message', 'Visitantes registrados com sucesso!');
    }

    public function editVisitantes()
    {
        $this->loadTurma();
        if (!$this->turma) {
            session()->flash('error', 'Turma não encontrada');
            return;
        }

        $visitante = Visitante::where([
            'turma_id' => $this->turma->id,
            'data' => date('Y-m-d', strtotime($this->data))
        ])->first();

        if ($visitante) {
            $this->visitante_quantidade = $visitante->quantidade;
            $this->visitante_biblias = $visitante->biblias;
        } else {
            $this->visitante_quantidade = 0;
            $this->visitante_biblias = 0;
        }
    }

    public function updateVisitantes()
    {
        $this->validate([
            'visitante_quantidade' => 'required|numeric|min:1',
            'visitante_biblias' => 'required|numeric|min:0|lte:visitante_quantidade',
        ]);

        Visitante::updateOrCreate(
            [
                'turma_id' => $this->turma->id,
                'data' => date('Y-m-d', strtotime($this->data))
            ],
            [
                'quantidade' => $this->visitante_quantidade,
                'biblias' => $this->visitante_biblias,
                'igreja_id' => User::getIgreja()->id,
            ]
        );

        $this->resetFields();
        $this->dispatch('closeVisitantesModal');
        session()->flash('message', 'Visitantes atualizados com sucesso!');
    }

    public function incrementVisitantes()
    {
        $this->visitante_quantidade++;
    }

    public function decrementVisitantes()
    {
        if ($this->visitante_quantidade > 1) {
            $this->visitante_quantidade--;
            if ($this->visitante_biblias > $this->visitante_quantidade) {
                $this->visitante_biblias = $this->visitante_quantidade;
            }
        }
    }

    public function incrementBiblias()
    {
        if ($this->visitante_biblias < $this->visitante_quantidade) {
            $this->visitante_biblias++;
        }
    }

    public function decrementBiblias()
    {
        if ($this->visitante_biblias > 0) {
            $this->visitante_biblias--;
        }
    }
}
