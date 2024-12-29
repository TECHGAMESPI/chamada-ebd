<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessorPorTurmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professor_por_turmas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id')->unsigned();
            $table->unsignedBigInteger('turma_id')->unsigned();

            $table->foreign('professor_id')->references('id')->on('users');
            $table->foreign('turma_id')->references('id')->on('turmas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professor_por_turmas');
    }
}
