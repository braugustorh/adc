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
        Schema::create('one_to_ones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluator_user_id')->constrained('users');
            $table->foreignId('evaluated_user_id')->constrained('users');
            $table->string('period',25)->nullable()->index();
            $table->date('date')->nullable();
            $table->string('recommendation', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('one_to_ones');
    }
};
