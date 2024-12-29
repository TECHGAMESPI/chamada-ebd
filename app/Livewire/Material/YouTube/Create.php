<?php

namespace App\Livewire\material\YouTube;

use App\Models\material;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Create extends Component
{
    public material $material;

    public $title = '';

    public $link;

    protected $rules = [
        'title' => 'required',
        'link'  => 'required|url|youtube_url',
    ];

    protected $messages = [
        'required'    => 'Campo obrigatório',
        'url'         => 'O link precisa ser uma url válida',
        'youtube_url' => 'O link precisa ser do domínio do YouTube',
    ];

    public function boot()
    {
        Validator::extend('youtube_url', function ($attribute, $value) {

            $parsedUrl = parse_url($value);
            $host      = $parsedUrl['host'] ?? '';

            if (str_contains($host, 'youtube.com') !== false || str_contains($host, 'youtu.be') !== false) {
                return true;
            }

            return false;
        });
    }

    public function render()
    {
        return view('livewire.material.you-tube.create');
    }

    public function store()
    {
        try {
            $this->validate();
            $data           = [];
            $data['titulo'] = $this->title;
            $data['url']    = $this->link;
            $this->material->you_tubes()->create($data);

            toastr()->addSuccess('Link do You Tube inserido', 'Sucesso');

            return redirect(route('material.show', $this->material->id));
        } catch (QueryException $e) {
            env('APP_ENV') == 'local' ? toastr()->addError($e->getMessage()) : toastr()->addError('Não foi possível cadastrar', 'Erro!');
        }
    }
}
