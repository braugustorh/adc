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
        Schema::create('indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('evaluated_by')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->text('objective_description');
            $table->string('evaluation_formula');
            $table->string('periodicity');
            $table->integer('target_value');
            $table->string('type_of_target');
            $table->string('target_period');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicators');
    }
};
