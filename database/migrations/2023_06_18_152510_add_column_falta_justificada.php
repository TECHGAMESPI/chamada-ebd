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
        Schema::table('chamadas', function (Blueprint $table) {
            $table->boolean('falta_justificada')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chamadas', function (Blueprint $table) {
            $table->dropColumn('falta_justificada');
        });
    }
};
