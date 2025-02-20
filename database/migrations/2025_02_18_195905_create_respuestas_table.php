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
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->string('hora');
            $table->string('fecha');
            $table->string('nacionalidad');
            $table->string('motivo_visita');
            $table->string('descubrimiento');
            $table->string('viaje');
            $table->string('transporte');
            $table->string('comuna')->nullable(); // Permitir valores nulos
            $table->timestamps(); // Esto añadirá automáticamente campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};