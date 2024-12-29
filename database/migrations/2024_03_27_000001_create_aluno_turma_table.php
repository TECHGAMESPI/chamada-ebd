<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('aluno_turma', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('turma_id')->constrained('turmas')->onDelete('cascade');
            $table->foreignId('igreja_id')->constrained('igrejas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aluno_turma');
    }
}; 