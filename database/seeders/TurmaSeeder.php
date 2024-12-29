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
            'nome_turma' => 'Adolescentes',

        ]);

        DB::table('turmas')->insert([
            'nome_turma' => 'Adultos',
        ]);

        DB::table('turmas')->insert([
            'nome_turma' => 'Discipulado',
        ]);

        DB::table('turmas')->insert([
            'nome_turma' => 'Jardim da Infância',
        ]);

        DB::table('turmas')->insert([
            'nome_turma' => 'Jovens',
        ]);

        DB::table('turmas')->insert([
            'nome_turma' => 'Juniores',
        ]);

        DB::table('turmas')->insert([
            'nome_turma' => 'Líderes',
        ]);

        DB::table('turmas')->insert([
            'nome_turma' => 'Maternal',
        ]);
    }
}
