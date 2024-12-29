<?php

namespace App\Livewire\Church;

use App\Models\Igreja;
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perpage = 5;

    public string $search = '';

    public function render()
    {
        return view('livewire.church.index', ['igrejas' => Igreja::where('nome', 'like', '%' . $this->search . '%')->orderBy('nome')->paginate($this->perpage)]);
    }

    public function destroy(Igreja $igreja)
    {
        try {
            $igreja->delete();

            toastr()->addSuccess('Igreja apagada com sucesso!', 'Feito');
        } catch (\Exception $e) {
            toastr()->addError('Não foi possível excluir Igreja pois existem registro associados a ela!', 'Erro');
        }
    }
}
