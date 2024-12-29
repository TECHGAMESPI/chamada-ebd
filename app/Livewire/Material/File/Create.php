<?php

namespace App\Livewire\material\File;

use App\Models\material;
use Illuminate\Database\QueryException;
use Livewire\{Component, WithFileUploads};

class Create extends Component
{
    use WithFileUploads;

    public material $material;

    public $title = '';

    public $file;

    protected $rules = [
        'title' => 'required',
        'file'  => 'required|mimes:pdf,docx,pptx,txt',
    ];

    protected $messages = [
        'required' => 'Campo obrigatório',
        'mimes'    => 'Só é permitido arquvios das seguintes extenções: pdf,docx,pptx,txt',
    ];

    public function render()
    {
        return view('livewire.material.file.create');
    }

    public function store()
    {
        try {
            $this->validate();
            $data                    = [];
            $data['titulo']          = $this->title;
            $data['caminho_arquivo'] = $this->file->store('arquivos');
            $this->material->arquivos()->create($data);

            toastr()->addSuccess('Aquivo inserido', 'Sucesso');

            return redirect(route('material.show', $this->material->id));
        } catch (QueryException $e) {
            env('APP_ENV') == 'local' ? toastr()->addError($e->getMessage()) : toastr()->addError('Não foi possível cadastrar', 'Erro!');
        }
    }
}
