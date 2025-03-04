<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    //modificado el 1 de marzo
    //Se quitan campos solo se deja compromisos y comentarios-
    //la original se encuentra en database/2025_02_13_132435_create_performance_evaluations_table.php
    public function up(): void
    {
        Schema::create('performance_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('one_to_one_evaluation_id')->constrained()->onDelete('cascade'); // Relación con la evaluación
            $table->text('commitments')->nullable(); // Compromisos
            $table->text('comments')->nullable(); // Comentarios
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_evaluations');
    }
};
