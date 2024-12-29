<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avaliacao_materials', function (Blueprint $table) {
            $table->id();
            $table->boolean('muito_ruim');
            $table->boolean('ruim');
            $table->boolean('razoavel');
            $table->boolean('muito_bom');
            $table->boolean('excelente');
            $table->foreignId('user_id')->unsigned();
            $table->foreignId('material_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacao_materials');
    }
};
