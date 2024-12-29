<?php

namespace App\Policies;

use App\Models\Perfil;
use App\Models\{Quiz, User};

class QuizPolicy
{
    public function actionsQuiz(User $user, Quiz $quiz): bool
    {
        return $user->perfil_id == Perfil::ADMINISTRADOR || $user->perfil_id == Perfil::SUPERINTENDENTE || $quiz->owner_id == $user->id;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Quiz $quiz): bool
    {
        //
    }
}
