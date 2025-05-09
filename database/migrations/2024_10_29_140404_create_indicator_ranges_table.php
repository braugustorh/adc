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
        Schema::create('indicator_ranges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indicator_id')->constrained()->onDelete('cascade');
            $table->string('expression_excellent',20);
            $table->integer('excellent_threshold');
            $table->string('expression_satisfactory',20);
            $table->integer('satisfactory_threshold');
            $table->string('expression_unsatisfactory',20);
            $table->integer('unsatisfactory_threshold');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicator_ranges');
    }
};
