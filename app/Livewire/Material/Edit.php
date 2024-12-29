<?php

namespace App\Livewire\material;

use App\Models\material;
use Illuminate\Database\QueryException;
use Livewire\Component;

class Edit extends Component
{
    public material $material;

    public array $fields = [];

    protected array $rules = [
        'fields.titulo'      => 'required',
        'fields.descricao'   => 'required',
        'fields.publicar_em' => 'required',
    ];

    protected array $messages = [
        'required' => 'Campo obrigatório',
    ];

    public function mount()
    {
        $this->fields['titulo']          = $this->material->titulo;
        $this->fields['descricao']       = $this->material->descricao;
        $this->fields['publicar_em']     = $this->material->publicar_em;
        $this->fields['material_global'] = $this->material->material_global;
    }
    public function render()
    {
        return view('livewire.material.edit');
    }

    public function update()
    {
        try {
            $this->validate();
            $this->material->update($this->fields);

            return redirect(route('material.show', $this->material->id));
        } catch (QueryException $e) {
            env('APP_ENV') == 'local' ? toastr()->addError($e->getMessage()) : toastr()->addError('Não foi possível atualizar', 'Erro!');
        }
    }

    public function changeGlobalPublish()
    {
        if ($this->fields['material_global'] == false) {
            return $this->fields['material_global'] = true;
        }

        if ($this->fields['material_global'] == true) {
            return $this->fields['material_global'] = false;
        }
    }
}
