<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Añadimos la columna para el tipo de modelo COCOMO después de la columna 'mode'
            $table->string('cocomo_model')->after('mode')->default('basico');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Esto permite revertir la migración si es necesario
            $table->dropColumn('cocomo_model');
        });
    }
};
