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
        Schema::create('identified_collaborators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sede_id')->constrained('sedes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('norma_id')->constrained('nom_035_processes')->onDelete('cascade');
            $table->enum('type_identification', ['encuesta', 'manual'])->nullable()->default('encuesta'); // Tipo de identificación
            $table->foreignId('identified_by')->constrained('users')->onDelete('cascade');
            $table->dateTime('identified_at')->nullable(); // Fecha de identificación
            $table->timestamps();

            // Índices para optimizar búsquedas
            $table->index(['sede_id', 'user_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identified_collaborators');
    }
};
