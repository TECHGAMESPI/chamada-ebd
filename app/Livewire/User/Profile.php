<?php

namespace App\Livewire\User;

use App\Models\{Perfil, User};
use DateTime;
use Exception;
use Illuminate\Support\Facades\{Auth, Storage};
use Intervention\Image\Facades\Image;
use Livewire\{Component, WithFileUploads};

class Profile extends Component
{
    use WithFileUploads;

    public $profile;

    public $name;

    public $email;

    public $googleEmail;

    public $maritalStatus;

    public $phone;

    public $date;

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
        'googleEmail.email'      => 'E-mail inválido',
        'maritalStatus.required' => 'Campo obrigatório',
        'date.required'          => 'Campo obrigatório',
        'photo.mimes'            => 'A foto precisa ser de um formato válido (jpg,jpeg,png)',
    ];

    public function mount()
    {
        $user                = User::find(Auth::user()->id);
        $this->profile       = Perfil::find($user->perfil_id)->perfil;
        $this->name          = $user->name;
        $this->email         = $user->email;
        $this->googleEmail   = $user->google_email;
        $this->maritalStatus = $user->estado_civil;
        $this->phone         = $user->telefone;
        $this->date          = $user->data_nascimento;
    }
    public function render()
    {
        return view('livewire.user.profile');
    }

    public function update()
    {
        $this->validate();

        try {
            $user                  = User::find(Auth::user()->id);
            $user->name            = $this->name;
            $user->email           = $this->email;
            $user->google_email    = $this->googleEmail;
            $user->estado_civil    = $this->maritalStatus;
            $user->data_nascimento = $this->date;
            $user->telefone        = $this->phone;
            $user->path_photo      = $this->photo ? $this->updatePhoto($user->path_photo) : $user->path_photo;

            $user->save();

            toastr()->addSuccess('Perfil atualizado com sucesso', 'Feito!');

            return redirect(route('perfil'));
        } catch (Exception $e) {
            toastr()->addError($e->getMessage(), 'Erro!');
        }
    }

    protected function updatePhoto(string $path_photo): string
    {
        if ($path_photo != "img/profile/user-512.webp") {

            unlink($path_photo);
        }

        $today = new DateTime('now');

        $img = Image::make($this->photo->getRealPath());

        $nameFile = hash('sha1', $this->photo->getClientOriginalName() . $today->format('u'));
        $img->save('storage/users/' . $nameFile . '.' . 'webp', 50, 'webp');

        return 'storage/users/' . $nameFile . '.' . 'webp';
    }
}
