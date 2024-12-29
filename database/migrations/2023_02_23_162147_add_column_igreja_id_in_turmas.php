<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIgrejaIdInTurmas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('turmas', function (Blueprint $table) {
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
        Schema::table('turmas', function (Blueprint $table) {
            $table->dropColumn('igreja_id');
        });
    }
}
