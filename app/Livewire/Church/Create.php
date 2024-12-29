<?php

namespace App\Livewire\Church;

use App\Models\{Igreja, Turma};
use Livewire\Component;

class Create extends Component
{
    public $name;

    public $address;

    public $minister;

    public $churchCategory;

    public $day;

    public $hour;

    protected $rules = [
        'name'           => 'required',
        'address'        => 'required',
        'minister'       => 'required',
        'churchCategory' => 'required',
        'day'            => 'required',
        'hour'           => 'required',
    ];

    protected $messages = [
        'name.required'           => 'O campo Nome é obrigatório.',
        'address.required'        => 'O campo Nome é obrigatório.',
        'minister.required'       => 'O campo Nome é obrigatório.',
        'churchCategory.required' => 'O campo Nome é obrigatório.',
        'day.required'            => 'O campo Nome é obrigatório.',
        'hour.required'           => 'O campo Nome é obrigatório.',
    ];
    public function render()
    {
        return view('livewire.church.create');
    }

    public function store()
    {

        $this->validate();

        $igreja = Igreja::create([
            'nome'        => $this->name,
            'endereco'    => $this->address,
            'pastor'      => $this->minister,
            'tipo_igreja' => $this->churchCategory,
            'dia_ebd'     => $this->day,
            'horario'     => $this->hour,
        ]);

        Turma::storeClass($igreja);

        toastr()->addSuccess('Igreja adicionada com sucesso!', 'Feito!');

        return redirect(route('igrejas.index'));
    }
}
