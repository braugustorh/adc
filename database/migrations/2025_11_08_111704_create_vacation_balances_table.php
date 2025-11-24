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
        Schema::create('vacation_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('year'); // Año de antigüedad (ej: 2025)
            $table->integer('total_days')->default(0); // Días totales según LFT
            $table->integer('used_days')->default(0); // Días consumidos
            $table->integer('pending_days')->default(0); // Días en solicitudes pendientes
            $table->integer('available_days')->default(0); // Días disponibles
            $table->date('period_start'); // Inicio del período
            $table->date('period_end'); // Fin del período
            $table->timestamps();

            $table->unique(['user_id', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vacation_balances');
    }
};
