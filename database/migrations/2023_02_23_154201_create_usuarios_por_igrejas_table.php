<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosPorIgrejasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_por_igrejas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('igreja_id')->constant();
            $table->foreign('igreja_id')->references('id')->on('igrejas');
            $table->foreignId('user_id')->constant();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('usuarios_por_igrejas');
    }
}
