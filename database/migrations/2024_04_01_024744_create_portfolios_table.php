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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('acta_url',250)->nullable();
            $table->string('curp_url',250)->nullable();
            $table->string('rfc_url',250)->nullable();
            $table->string('ine_url',250)->nullable();
            $table->string('comprobante_domicilio_url',250)->nullable();
            $table->string('comprobante_estudios_url',250)->nullable();
            $table->string('carta_no_antecedentes_url',250)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
