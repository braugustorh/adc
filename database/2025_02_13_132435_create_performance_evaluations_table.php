<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('one_to_one_evaluation_id')->constrained()->onDelete('cascade'); // Relación con la evaluación
            $table->enum('evaluation_type', ['360', '9box', 'psychometry']); // Tipo de evaluación
            $table->decimal('qualify', 5, 2); // Ponderación
            $table->string('qualify_translate'); // Calificación traducida
            $table->text('comments')->nullable(); // Comentarios
            $table->date('scheduled_date'); // Fecha programada
            $table->integer('progress')->default(0); // Avance (porcentaje)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_evaluations');
    }
};
