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
        Schema::create('psychometric_evaluations', function (Blueprint $table) {
            $table->id();

            // Relación con el tipo de evaluación existente
            $table->foreignId('evaluations_type_id')->constrained('evaluations_types');

            // Relación polimórfica: User o Candidate
            $table->morphs('evaluable');

            // Quien asigna la evaluación
            $table->foreignId('assigned_by')->constrained('users');

            // Control de estados y progreso
            $table->enum('status', [
                'assigned', 'started', 'in_progress', 'completed', 'expired'
            ])->default('assigned');

            $table->integer('progress')->default(0); // 0-100%

            // Fechas de control
            $table->datetime('assigned_at');
            $table->datetime('started_at')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->datetime('expires_at')->nullable();

            // Instrucciones y notas
            $table->text('instructions')->nullable();
            $table->text('manual_notes')->nullable();

            // Respuestas en JSON (aprovechando Response existente también)
            $table->json('response_summary')->nullable(); // Resumen de respuestas por competencia

            // URLs de documentos
            $table->string('result_document_url')->nullable();
            $table->string('interpretation_document_url')->nullable();

            $table->timestamps();

            // Índices
           // $table->index(['evaluable_type', 'evaluable_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('psychometric_evaluations');
    }

};
