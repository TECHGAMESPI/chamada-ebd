<?php

namespace App\Livewire\Church;

use App\Models\Igreja;
use Exception;
use Illuminate\Http\Request;

class Edit extends Create
{
    public $church;

    public function mount(Request $request)
    {
        $this->church = Igreja::find($request->id);

        $this->name           = $this->church->nome;
        $this->address        = $this->church->endereco;
        $this->minister       = $this->church->pastor;
        $this->churchCategory = $this->church->tipo_igreja;
        $this->day            = $this->church->dia_ebd;
        $this->hour           = $this->church->horario;
    }
    public function render()
    {
        return view('livewire.church.edit');
    }

    public function update()
    {
        try {
            $this->church->nome        = $this->name;
            $this->church->endereco    = $this->address;
            $this->church->pastor      = $this->minister;
            $this->church->tipo_igreja = $this->churchCategory;
            $this->church->dia_ebd     = $this->day;
            $this->church->horario     = $this->hour;

            $this->church->save();

            toastr()->addSuccess('Informações atualizadas.', 'Sucesso!');

            return redirect(route('igrejas.index'));
        } catch (Exception $e) {
            toastr()->addError('Não foi possível atualizar.', 'Erro!');
        }
    }
}
