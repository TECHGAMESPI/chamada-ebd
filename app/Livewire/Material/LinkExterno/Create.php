<?php

namespace App\Livewire\material\LinkExterno;

use App\Models\material;
use Illuminate\Database\QueryException;
use Livewire\Component;

class Create extends Component
{
    public material $material;

    public $title = '';

    public $link;

    protected $rules = [
        'title' => 'required',
        'link'  => 'required|url',
    ];

    protected $messages = [
        'required' => 'Campo obrigatório',
        'url'      => 'O link precisa ser uma url válida',
    ];

    public function render()
    {
        return view('livewire.material.link-externo.create');
    }

    public function store()
    {
        try {
            $this->validate();
            $data           = [];
            $data['titulo'] = $this->title;
            $data['url']    = $this->link;
            $this->material->links_externos()->create($data);

            toastr()->addSuccess('Link inserido', 'Sucesso');

            return redirect(route('material.show', $this->material->id));
        } catch (QueryException $e) {
            env('APP_ENV') == 'local' ? toastr()->addError($e->getMessage()) : toastr()->addError('Não foi possível cadastrar', 'Erro!');
        }
    }
}
