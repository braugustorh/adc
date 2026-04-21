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
        Schema::table('psychometric_evaluations', function (Blueprint $table) {
            $table->string('puesto')->nullable()->after('batch_id')
                  ->comment('Puesto para el que se generó la evaluación: Directivo, Mando Medio, Supervisor, Administrativo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('psychometric_evaluations', function (Blueprint $table) {
            $table->dropColumn('puesto');
        });
    }
};
