<?php

namespace App\Livewire\material;

use App\Models\{Avaliacaomaterial, material};
use Livewire\Component;

class Votes extends Component
{
    protected array $data = [];

    public $vote;

    public $votes;

    public material $material;

    public function mount()
    {
        $this->getVote();
        $this->votes = Avaliacaomaterial::where('material_id', $this->material->id)
            ->first();
    }

    public function getVote()
    {
        $this->vote = Avaliacaomaterial::where(['user_id' => auth()->user()->id, 'material_id' => $this->material->id])->first();
    }

    public function render()
    {
        return view('livewire.material.votes');
    }

    protected function store(array $data)
    {
        if ($this->vote) {
            $this->vote->update($data);
            $this->getVote();
            toastr()->addSuccess('Voto registrado', 'Sucesso');

            return to_route('material.show', $this->material->id);
        }
        Avaliacaomaterial::create($data);
        $this->getVote();
        toastr()->addSuccess('Voto registrado', 'Sucesso');

        return to_route('material.show', $this->material->id);
    }

    public function muitoRuim()
    {
        $data = [
            'muito_ruim'  => true,
            'ruim'        => false,
            'razoavel'    => false,
            'muito_bom'   => false,
            'excelente'   => false,
            'user_id'     => auth()->user()->id,
            'material_id' => $this->material->id,
        ];

        $this->store($data);
    }

    public function ruim()
    {
        $data = [
            'muito_ruim'  => false,
            'ruim'        => true,
            'razoavel'    => false,
            'muito_bom'   => false,
            'excelente'   => false,
            'user_id'     => auth()->user()->id,
            'material_id' => $this->material->id,
        ];

        $this->store($data);
    }

    public function razoavel()
    {
        $data = [
            'muito_ruim'  => false,
            'ruim'        => false,
            'razoavel'    => true,
            'muito_bom'   => false,
            'excelente'   => false,
            'user_id'     => auth()->user()->id,
            'material_id' => $this->material->id,
        ];

        $this->store($data);
    }

    public function muitoBom()
    {
        $data = [
            'muito_ruim'  => false,
            'ruim'        => false,
            'razoavel'    => false,
            'muito_bom'   => true,
            'excelente'   => false,
            'user_id'     => auth()->user()->id,
            'material_id' => $this->material->id,
        ];

        $this->store($data);
    }

    public function excelente()
    {
        $data = [
            'muito_ruim'  => false,
            'ruim'        => false,
            'razoavel'    => false,
            'muito_bom'   => false,
            'excelente'   => true,
            'user_id'     => auth()->user()->id,
            'material_id' => $this->material->id,
        ];

        $this->store($data);
    }
}
