<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIgrejaIdInProfessoresPorTurma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('professor_por_turmas', function (Blueprint $table) {
            $table->foreignId('igreja_id')->constant()->default(1);
            $table->foreign('igreja_id')->references('id')->on('igrejas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('professor_por_turmas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('igreja_id');
        });
    }
}
