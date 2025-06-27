<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_factor_surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sede_id')->constrained('sedes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('norma_id')->constrained('nom_035_processes')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->integer('response_value')->comment('1=Nunca, 2=Casi nunca, 3=Algunas veces, 4=Casi siempre, 5=Siempre');
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Índices
            $table->index(['user_id', 'norma_id']);
            $table->index('question_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likert_survey_responses');
    }
};
