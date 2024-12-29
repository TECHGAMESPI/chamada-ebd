<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlunoPorTurmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aluno_por_turmas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aluno_id')->unsigned();
            $table->unsignedBigInteger('turma_id')->unsigned();
            $table->foreign('aluno_id')->references('id')->on('users');
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
        Schema::dropIfExists('aluno_por_turmas');
    }
}
