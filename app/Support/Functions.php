<?php

use App\Models\{Chamada, Igreja, Quiz, ResponseQuiz, User, UsuariosPorIgreja};
use Illuminate\Support\Facades\Auth;

function calculateAge(string $birthDate): string
{
    $startDate = new \DateTime($birthDate);
    $endDate   = new \DateTime();
    $interval  = $endDate->diff($startDate);

    return $interval->y . ' anos';
}

function cutName(string $name): string
{
    $name = explode(' ', $name);

    if (array_key_exists(1, $name)) {
        return $name[0] . ' ' . $name[1];
    }

    return $name[0];
}

function getChurch(): Igreja
{
    return UsuariosPorIgreja::where('user_id', Auth::user()->id)->first()->igreja;
}

function alternatives(int $key): string
{
    $alternatives = ["A)", "B)", "C)", "D)", "E)", "F)", "G)", "H)", "I)", "J)", ];

    return $alternatives[$key];
}

function isPresent(User $user): int
{
    return Chamada::where('aluno_id', $user->id)
        ->where('data', date('Y-m-d'))
        ->where('igreja_id', getChurch()->id)
        ->where('falta_justificada', false)
        ->count();

}

function responseQuiz(User $user, Quiz $quiz): null|ResponseQuiz
{
    return ResponseQuiz::where('user_id', $user->id)
        ->where('quiz_id', $quiz->id)
        ->first();
}
