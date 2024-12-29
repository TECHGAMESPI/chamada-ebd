<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInIgrejas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('igrejas', function (Blueprint $table) {
            $table->string('endereco')->nullable();
            $table->string('pastor')->nullable();
            $table->string('tipo_igreja')->default('IGREJA');
            $table->string('dia_ebd')->default('Domingo');
            $table->string('horario')->default('08 às 10');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('igrejas', function (Blueprint $table) {
            $table->dropColumn('endereco');
            $table->dropColumn('pastor');
            $table->dropColumn('tipo_igreja');
            $table->dropColumn('dia_ebd');
            $table->dropColumn('horario');
        });
    }
}
