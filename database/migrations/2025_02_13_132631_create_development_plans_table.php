<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('development_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('one_to_one_evaluation_id')->constrained()->onDelete('cascade'); // Relación con la evaluación
            $table->text('strengths')->nullable(); // Fortalezas detectadas
            $table->text('opportunities')->nullable(); // Áreas de oportunidad
            $table->string('development_area'); // Área de desarrollo
            $table->integer('progress')->default(0); // Avance (porcentaje)
            $table->date('scheduled_date'); // Fecha programada
            $table->enum('learning_type', ['experiential', 'social', 'structured']); // Tipo de aprendizaje
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('development_plans');
    }
};
