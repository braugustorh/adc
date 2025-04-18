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
        Schema::create('competences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluations_type_id')->constrained('evaluations_types')->onDelete('cascade');
            $table->string('name');
            $table->text('description',255)->nullable()->default(null);
            $table->string('level')->nullable()->default(null);
            $table->boolean('status')->default(true);
            $table->timestamps();

        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competences');
    }
};
