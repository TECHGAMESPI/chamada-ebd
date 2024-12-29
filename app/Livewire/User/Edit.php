<?php

namespace App\Livewire\User;

use App\Models\{Perfil, User};
use DateTime;
use Exception;
use Illuminate\Support\Facades\{Hash, Storage};
use Intervention\Image\Facades\Image;
use Livewire\{Component, WithFileUploads};

class Edit extends Component
{
    use WithFileUploads;

    public $user_id;

    public $profile;

    public $profiles;

    public $name;

    public $email;

    public $googleEmail;

    public $maritalStatus;

    public $phone;

    public $date;

    public $path_photo;

    public $photo;

    protected $rules = [
        'name'          => 'required',
        'email'         => 'required',
        'maritalStatus' => 'required',
        'phone'         => 'nullable',
        'date'          => 'required',
        'googleEmail'   => 'nullable|email',
        'photo'         => 'nullable|mimes:jpg,jpeg,png',
    ];

    protected $messages = [
        'name.required'          => 'Campo obrigatório',
        'email.required'         => 'Campo obrigatório',
        'maritalStatus.required' => 'Campo obrigatório',
        'date.required'          => 'Campo obrigatório',
        'googleEmail.email'      => 'E-mail inválido',
        'photo.mimes'            => 'A foto precisa ser de um formato válido (jpg,jpeg,png)',
    ];

    public function mount()
    {
        $this->profiles = Perfil::where('id', '!=', Perfil::ADMINISTRADOR)->get();

        if (auth()->user()->perfil_id == Perfil::ADMINISTRADOR) {
            $this->profiles = Perfil::all();
        }

        $user                = User::find(request('id'));
        $this->user_id       = $user->id;
        $this->profile       = $user->perfil_id;
        $this->name          = $user->name;
        $this->email         = $user->email;
        $this->googleEmail   = $user->google_email;
        $this->maritalStatus = $user->estado_civil;
        $this->path_photo    = $user->path_photo;
        $this->phone         = $user->telefone;
        $this->date          = $user->data_nascimento;
    }

    public function render()
    {
        return view('livewire.user.edit');
    }

    public function update()
    {
        $this->validate();

        try {
            $user                  = User::find($this->user_id);
            $user->name            = $this->name;
            $user->email           = $this->email;
            $user->google_email    = $this->googleEmail;
            $user->estado_civil    = $this->maritalStatus;
            $user->perfil_id       = $this->profile;
            $user->data_nascimento = $this->date;
            $user->telefone        = $this->phone;
            $user->path_photo      = $this->photo ? $this->updatePhoto($user->path_photo) : $user->path_photo;

            $user->save();

            toastr()->addSuccess('Usuário atualizado com sucesso', 'Feito!');

            return redirect(route('user.edit', ['id' => $user->id]));
        } catch (Exception $e) {
            toastr()->addError('Não foi posível atualizar', 'Erro!');
        }
    }

    protected function updatePhoto(string $path_photo): string
    {
        if ($path_photo != "img/profile/user-512.webp") {
            unlink($path_photo);
        }

        $today = new DateTime('now');

        $img = Image::make($this->photo->getRealPath());
        /* $img->crop(200, 200); */

        $nameFile = hash('sha1', $this->photo->getClientOriginalName() . $today->format('u'));
        $img->save('storage/users/' . $nameFile . '.' . 'webp', 50, 'webp');

        // return 'storage/' . $this->photo->storeAs('users', $nameFile  .  '.' . $this->photo->getClientOriginalExtension());
        return 'storage/users/' . $nameFile . '.' . 'webp';
    }

    public function resetPassword()
    {
        try {
            $user           = User::find($this->user_id);
            $user->password = Hash::make(env('PASSWORD_DEFAULT'));
            $user->save();
            toastr()->addSuccess('Senha resetada com sucesso', 'Feito!');
        } catch (Exception $e) {

            toastr()->addError('Não foi posível resetar a senha', 'Erro!');
        }
    }
}
