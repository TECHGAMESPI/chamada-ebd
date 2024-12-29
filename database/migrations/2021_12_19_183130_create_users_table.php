<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->unsignedBigInteger('perfil_id')->unsigned();
            $table->string('estado_civil');
            $table->date('data_nascimento');
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger('turma_id')->unsigned();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('perfil_id')->references('id')->on('perfils');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
    }
}
