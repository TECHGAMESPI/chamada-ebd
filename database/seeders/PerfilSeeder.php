<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('perfils')->insert([
            'perfil' => 'Administrador',
        ]);

        DB::table('perfils')->insert([
            'perfil' => 'Aluno',
        ]);

        DB::table('perfils')->insert([
            'perfil' => 'Professor',
        ]);

        DB::table('perfils')->insert([
            'perfil' => 'Superintendente',
        ]);

        DB::table('perfils')->insert([
            'perfil' => 'Secretário',
        ]);
    }
}
