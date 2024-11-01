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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluations_type_id')->constrained('evaluations_types');
            $table->foreignId('competence_id')->constrained('competences');
            $table->integer('order')->nullable()->default(null);
            $table->string('question',255)->index();
            $table->string('comment',255)->nullable()->default(null);
            $table->foreignId('answer_type_id')->constrained('answer_types');
            $table->boolean('status')->default(true);
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
