<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('answers', function (Blueprint $table) {
            // Agregamos la columna 'code' para guardar la letra del factor Kostick (G, L, P, etc.)
            // La ponemos nullable para no afectar los registros viejos de Moss/Cleaver
            $table->string('code', 5)->nullable()->after('weight');
        });
    }

    public function down()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
