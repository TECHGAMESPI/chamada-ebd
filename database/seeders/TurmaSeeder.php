<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TurmaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('turmas')->insert([
            'nome_turma' => 'Lucas',

        ]);

        DB::table('turmas')->insert([
            'nome_turma' => 'André',
        ]);

        DB::table('turmas')->insert([
            'nome_turma' => 'Discipulado',
        ]);

        DB::table('turmas')->insert([
            'nome_turma' => 'Simão Zelote',
        ]);

        DB::table('turmas')->insert([
            'nome_turma' => 'Mateus',
        ]);

        DB::table('turmas')->insert([
            'nome_turma' => 'Tomé',
        ]);

        DB::table('turmas')->insert([
            'nome_turma' => 'Oficiais e Professoreses',
        ]);

        DB::table('turmas')->insert([
            'nome_turma' => 'Catecúmenos',
        ]);
    }
}
