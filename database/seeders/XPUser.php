<?php

namespace Database\Seeders;

use App\Models\{User, UsuariosPorIgreja};
use Illuminate\Database\Seeder;

class XPUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function ($user) {
            $igreja = UsuariosPorIgreja::where('user_id', $user->id)->first();
            $user->xp()->create([
                'igreja_id' => $igreja->igreja_id,
                'points'    => 0,
                'year'      => date('Y'),
            ]);
        });
    }
}
