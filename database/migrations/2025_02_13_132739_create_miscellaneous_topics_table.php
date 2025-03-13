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
        Schema::create('miscellaneous_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('one_to_one_evaluation_id')->constrained()->onDelete('cascade'); // Relación con la evaluación
            $table->enum('who_says', ['colaborador', 'supervisor', 'ambos']); // Quién genera el asunto
            $table->string('topic'); // Asunto
            $table->text('comments')->nullable(); // Comentarios
            $table->text('follow_up')->nullable(); // Compromisos
            $table->date('scheduled_date')->nullable()->default(null); // Fecha programada
            $table->integer('progress')->nullable()->default(0); // Avance (porcentaje)
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miscellaneous_topics');
    }
};
