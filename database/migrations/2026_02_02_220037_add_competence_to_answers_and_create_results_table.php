<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. AJUSTE PARA MOSS: Solo agrega la columna si NO existe
        if (!Schema::hasColumn('answers', 'competence_id')) {
            Schema::table('answers', function (Blueprint $table) {
                $table->foreignId('competence_id')
                    ->nullable()
                    ->after('question_id')
                    ->constrained('competences');
            });
        }

        // 2. TABLA DE RESULTADOS: Solo crea la tabla si NO existe
        if (!Schema::hasTable('evaluation_user_answers')) {
            Schema::create('evaluation_user_answers', function (Blueprint $table) {
                $table->id();

                $table->foreignId('psychometric_evaluation_id')
                    ->constrained('psychometric_evaluations')
                    ->onDelete('cascade');

                $table->foreignId('question_id')->constrained('questions');

                $table->foreignId('answer_id')->nullable()->constrained('answers');

                $table->string('attribute')->nullable(); // Para Cleaver (MOST/LEAST)

                $table->text('text_value')->nullable();

                $table->timestamps();

                // EL NOMBRE CORTO DEL ÍNDICE (La corrección del error pasado)
                $table->index(['psychometric_evaluation_id', 'question_id'], 'eva_usr_ans_pe_id_q_id_idx');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_user_answers');
        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign(['competence_id']);
            $table->dropColumn('competence_id');
        });
    }
};
