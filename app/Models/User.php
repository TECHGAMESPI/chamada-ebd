<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\{Auth, Hash};
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'perfil_id',
        'estado_civil',
        'data_nascimento',
        'turma_id',
        'password',
        'telefone',
        'google_email',
    ];

    protected $appends = ['presenca'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function perfil()
    {
        return $this->hasOne(Perfil::class, 'id', 'perfil_id');
    }

    public function turmas()
    {
        return $this->hasMany(AlunoPorTurma::class, 'id', 'turma_id');
    }

    public function getPresencaAttribute()
    {
        return Chamada::where(['aluno_id' => $this->id, 'turma_id' => $this->turma_id, 'data' => date('Y-m-d')])->first();
    }

    public function presencas(?int $turma_id): int
    {
        if (is_null($turma_id)) {
            return Chamada::where(['aluno_id' => $this->id])->count();
        }

        return Chamada::where(['aluno_id' => $this->id, 'turma_id' => $turma_id])->count();
    }

    public function presencasAnoCorrente(?int $turma_id): int
    {
        if (is_null($turma_id)) {
            return Chamada::where(['aluno_id' => $this->id])->whereYear('data', date('Y'))->count();
        }

        return Chamada::where(['aluno_id' => $this->id, 'turma_id' => $turma_id])->whereYear('data', date('Y'))->count();
    }

    public static function getIgrejaName($id)
    {
        $igreja = UsuariosPorIgreja::where('user_id', $id)->first()->igreja;

        return $igreja->nome;
    }

    public static function getIgreja()
    {
        return UsuariosPorIgreja::where('user_id', Auth::user()->id)->first()->igreja;
    }

    public static function storeUser(
        string $name,
        string $email,
        int $perfil_id,
        string $estado_civil,
        string $data_nascimento,
        ?int $turma_id,
        ?string $password,
        ?string $telefone,
        ?int $igreja_id,
        ?string $googleEmail
    ) {
        try {

            $user = User::create([
                'name'            => $name,
                'email'           => $email,
                'perfil_id'       => $perfil_id,
                'estado_civil'    => $estado_civil,
                'data_nascimento' => $data_nascimento,
                'password'        => $password ? Hash::make($password) : Hash::make("ChamadaEBD"),
                'telefone'        => $telefone ? $telefone : "",
                'google_email'    => $googleEmail,
            ]);

            //Associando primera turma do aluno
            if (!is_null($turma_id)) {
                AlunoPorTurma::create([
                    'user_id'   => $user->id,
                    'turma_id'  => $turma_id,
                    'name'      => $name,
                    'igreja_id' => $igreja_id,
                ]);
            }

            $igreja = User::getIgreja()->id;

            if (!is_null($igreja_id)) {
                $igreja = $igreja_id;
            }

            $igreja = UsuariosPorIgreja::create(['user_id' => $user->id, 'igreja_id' => $igreja]);

            XP::create([
                'user_id'   => $user->id,
                'igreja_id' => $igreja->igreja_id,
                'points'    => 0,
                'year'      => date('Y'),
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Não foi possível incluir o usuário');
        }
    }

    public function materials()
    {
        return $this->hasMany(material::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function xp()
    {
        return $this->hasOne(XP::class);
    }
}
