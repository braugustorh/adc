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
        Schema::create('culture_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('one_to_one_evaluation_id')->constrained()->onDelete('cascade'); // Relación con la evaluación
            $table->string('theme'); // Tema discutido
            $table->text('comments')->nullable(); // Comentarios
            $table->text('commitments')->nullable(); // Compromisos
            $table->date('scheduled_date'); // Fecha programada
            $table->integer('progress')->default(0); // Avance (porcentaje)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('culture_topics');
    }
};
