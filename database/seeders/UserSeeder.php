<?php

namespace Database\Seeders;

use App\Models\{User, UsuariosPorIgreja};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash};

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'            => "José Cândido",
            'email'           => 'jose@professor',
            'perfil_id'       => 1,
            'estado_civil'    => 'SOLTEIRO',
            'data_nascimento' => '2002-05-22',
            'password'        => Hash::make('12345678'),
            'telefone'        => '999999999',
            'google_email'    => 'nailie2010@gmail.com',
        ]);

        UsuariosPorIgreja::create([
            'igreja_id' => 1,
            'user_id'   => 1,
        ]);

        for ($i = 0; $i < 50; $i++) {
            $user = User::factory()->create();
            UsuariosPorIgreja::create([
                'igreja_id' => 1,
                'user_id'   => $user->id,
            ]);
        }
    }
}
