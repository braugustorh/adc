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
        Schema::create('exit_surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->json('reasons_for_leaving')->nullable()->default(null)->comment('Razones de salida');
            $table->text('reasons_details')->nullable()->default(null)->comment('Detalles de las razones de salida');
            $table->enum('physical_environment_rating', ['muy_bueno', 'bueno', 'regular', 'malo', 'muy_malo'])->nullable()->default(null)->comment('Calificación del ambiente físico');
            $table->enum('induction_rating', ['muy_bueno', 'bueno', 'regular', 'malo', 'muy_malo'])->nullable()->default(null)->comment('Calificación de la inducción');
            $table->enum('training_rating', ['muy_bueno', 'bueno', 'regular', 'malo', 'muy_malo'])->nullable()->default(null)->comment('Calificación de la capacitación');
            $table->enum('motivation_rating', ['muy_bueno', 'bueno', 'regular', 'malo', 'muy_malo'])->nullable()->default(null)->comment('Calificación de la motivación');
            $table->enum('recognition_rating', ['muy_bueno', 'bueno', 'regular', 'malo', 'muy_malo'])->nullable()->default(null)->comment('Calificación del reconocimiento');
            $table->enum('salary_rating', ['muy_bueno', 'bueno', 'regular', 'malo', 'muy_malo'])->nullable()->default(null)->comment('Calificación del salario y comisiones');
            $table->enum('supervisor_treatment_rating', ['muy_bueno', 'bueno', 'regular', 'malo', 'muy_malo'])->nullable()->default(null)->comment('Calificación del trato del supervisor');
            $table->enum('rh_treatment_rating', ['muy_bueno', 'bueno', 'regular', 'malo', 'muy_malo'])->nullable()->default(null)->comment('Calificación del trato de RH');
            $table->boolean('met_expectations')->nullable()->default(null)->comment('Las funciones y responsabilidades cumplieron con las expectativas');
            $table->text('expectations_explanation')->nullable()->default(null)->comment('Explicación de las expectativas');
            $table->text('favorite_aspects')->nullable()->default(null)->comment('Aspectos favoritos');
            $table->text('least_favorite_aspects')->nullable()->default(null)->comment('Aspectos menos favoritos');
            $table->text('improvements')->nullable()->default(null)->comment('que hubiera hecho para evitar su salida');
            $table->text('suggestions')->nullable()->default(null)->comment('Sugerencias');
            $table->enum('status', ['activa', 'finalizada'])->default('finalizada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exit_surveys');
    }
};
