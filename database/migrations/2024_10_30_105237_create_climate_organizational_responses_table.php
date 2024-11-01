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
        Schema::create('climate_organizational_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('campaigns');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('competence_id')->constrained('competences');
            $table->foreignId('question_id')->constrained('questions');
            $table->integer('response');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('climate_organizational_responses');
    }
};
