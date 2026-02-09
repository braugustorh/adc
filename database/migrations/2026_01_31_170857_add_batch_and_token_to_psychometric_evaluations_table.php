<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('psychometric_evaluations', function (Blueprint $table) {
            // El token único para acceder desde fuera (Indexado para velocidad)
            $table->string('access_token', 64)->nullable()->index()->after('id');

            // El ID del lote para agrupar varias evaluaciones en una sola "sesión"
            $table->uuid('batch_id')->nullable()->index()->after('access_token');
        });
    }

    public function down(): void
    {
        Schema::table('psychometric_evaluations', function (Blueprint $table) {
            $table->dropColumn(['access_token', 'batch_id']);
        });
    }
};
