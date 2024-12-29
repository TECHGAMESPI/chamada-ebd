<?php

namespace Database\Seeders;

use App\Models\{Chamada, XP};
use Illuminate\Database\Seeder;

class PointsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $livro       = Chamada::where(['livro' => true, 'falta_justificada' => false])->whereYear('data', date('Y'))->get();
        $presencas    = Chamada::where(['livro' => false, 'falta_justificada' => false])->whereYear('data', date('Y'))->get();
        $justificadas = Chamada::where(['livro' => false, 'falta_justificada' => true])->whereYear('data', date('Y'))->get();

        $livro->map(function ($item) {

            $xp = XP::where('user_id', $item->aluno_id)->first();

            if ($xp) {
                $xp->points += 7;
                $xp->save();
            }
        });

        $presencas->map(function ($item) {

            $xp = XP::where('user_id', $item->aluno_id)->first();

            if ($xp) {
                $xp->points += 10;
                $xp->save();
            }
        });

        $justificadas->map(function ($item) {

            $xp = XP::where('user_id', $item->aluno_id)->first();

            if ($xp) {
                $xp->points += 2;
                $xp->save();
            }
        });
    }
}
