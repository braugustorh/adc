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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            /*La columna evaluations_id almacena un arreglo de los id's de las evaluacines
            * que estarán activas en esa campaña
             */
            //$table->string('evaluations_id')->nullable();
            /*La columna sedes_id almacena un arreglo de los id's de las sedes
            * que estarán en esa campaña
             */
           // $table->string('sedes_id')->nullable();
            $table->string('name')->index()->unique();
            $table->string('description',150)->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignid('user_id')->constrained('users');
            $table->string('status')->default('Activo')->index();
            $table->timestamps();
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
