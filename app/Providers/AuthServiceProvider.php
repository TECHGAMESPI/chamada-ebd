<?php

namespace App\Providers;

use App\Models\{material, Perfil, User};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is_admin', function () {
            if (auth()->user()->perfil_id == Perfil::ADMINISTRADOR) {
                return true;
            }

            return false;
        });

        Gate::define('is_teacher', function () {
            if (auth()->user()->perfil_id == Perfil::PROFESSOR) {
                return true;
            }

            return false;
        });

        Gate::define('admin_superintendente', function (User $user) {
            if ($user->perfil_id == Perfil::ADMINISTRADOR || $user->perfil_id == Perfil::SUPERINTENDENTE) {
                return true;
            }

            return false;
        });

        Gate::define('aluno', function (User $user) {
            if ($user->perfil_id == Perfil::ALUNO) {
                return true;
            }

            return false;
        });

        Gate::define('post_material', function (User $user) {
            if ($user->perfil_id == Perfil::ALUNO) {
                return false;
            }

            return true;
        });

        Gate::define('action_material', function (User $user, material $material) {

            if ($user->perfil_id == Perfil::ADMINISTRADOR) {
                return true;
            }

            if ($user->perfil_id == Perfil::SUPERINTENDENTE && $material->material_global == false) {
                return true;
            }

            if ($user->id == $material->user_id) {
                return true;
            }

            return false;
        });
    }
}
