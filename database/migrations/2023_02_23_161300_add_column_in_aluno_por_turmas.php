<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInAlunoPorTurmas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aluno_por_turmas', function (Blueprint $table) {
            $table->foreignId('igreja_id')->constant()->default(1);
            $table->foreign('igreja_id')->references('id')->on('igrejas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aluno_por_turmas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('aluno_por_turmas.igreja_id');
            $table->dropColumn('igreja_id');
        });
    }
}
