<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsVisitanteToChamadasTable extends Migration
{
    public function up()
    {
        Schema::table('chamadas', function (Blueprint $table) {
            $table->boolean('is_visitante')->default(false);
        });
    }

    public function down()
    {
        Schema::table('chamadas', function (Blueprint $table) {
            $table->dropColumn('is_visitante');
        });
    }
} 