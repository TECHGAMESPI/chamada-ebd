<?php

namespace App\Livewire\Administrator\User;

use App\Models\{Igreja, Perfil, Turma, User};
use Livewire\Component;

class Register extends Component
{
    public $name;

    public $email;

    public $googleEmail;

    public $maritalStatus;

    public $birthDate;

    public $phone;

    public $profiles;

    public $perfil;

    public $churchs;

    public $church;

    protected $rules = [
        'name'          => 'required',
        'email'         => 'required|email|unique:users,email',
        'googleEmail'   => 'nullable|email',
        'maritalStatus' => 'required',
        'church'        => 'required',
        'birthDate'     => 'required',
        'phone'         => 'nullable|min:9',
        'perfil'        => 'required',
    ];

    protected $messages = [
        'name.required'      => 'O campo Nome é obrigatório.',
        'email.required'     => 'O campo Email é obrigatório.',
        'email.unique'       => 'O campo Email já está em uso.',
        'email.email'        => 'O campo Email precisa ter um formato válido.',
        'church.required'    => 'O campo Igreja é obrgatório',
        'birthDate.required' => 'O campo Data de nascimento é obrigatório',
        'phone.min'          => 'O campo Telefone precisa ter pelo menos 9 caracteres.',
        'perfil.required'    => 'O campo Perfil é obrigatório',
    ];

    public function mount()
    {
        $this->churchs  = Igreja::all();
        $this->profiles = Perfil::all();
    }

    public function render()
    {
        return view('livewire.administrator.user.register');
    }

    public function store()
    {
        $this->validate();

        try {
            $user = User::storeUser(
                $this->name,
                $this->email,
                $this->perfil,
                $this->maritalStatus,
                $this->birthDate,
                null,
                null,
                $this->phone ? $this->phone : null,
                $this->church,
                $this->googleEmail ? $this->googleEmail : null
            );

            toastr()->addSuccess('Usuário cadastrado', 'Sucesso');
        } catch (\Exception $e) {
            toastr()->addError('Não foi possível cadastrar', 'Erro');
        }
    }
}
