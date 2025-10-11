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
        Schema::create('ui_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('element_key')->unique();
            $table->json('configuration_jsonb'); // Usamos json para compatibilidad con MySQL
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ui_configurations');
    }
};
