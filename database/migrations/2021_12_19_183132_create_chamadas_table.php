<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChamadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chamadas', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->unsignedBigInteger('professor_id')->unsigned();
            $table->unsignedBigInteger('turma_id')->unsigned();
            $table->unsignedBigInteger('aluno_id')->unsigned();

            $table->foreign('professor_id')->references('id')->on('users');
            $table->foreign('turma_id')->references('id')->on('turmas');
            $table->foreign('aluno_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chamadas');
    }
}
