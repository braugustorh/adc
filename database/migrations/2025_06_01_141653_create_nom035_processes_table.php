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
        Schema::create('nom_035_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sede_id')->constrained('sedes')->onDelete('cascade');
            $table->foreignId('hr_manager_id')->constrained('users')->onDelete('restrict');
            $table->dateTime('start_date');
            $table->enum('status', ['iniciado', 'en_progreso', 'finalizado'])->default('iniciado');
            $table->integer('total_employees');
            $table->boolean('survey_applicable')->default(false);
            $table->dateTime('finished_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nom035_processes');
    }
};
