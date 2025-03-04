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
            $table->string('indicator_type');
            $table->integer('target_value');
            $table->string('type_of_target');
            $table->string('indicator_unit_id', 15);
            $table->string('periodicity');
            $table->string('target_period');
            $table->date('target_period_start');
            $table->date('target_period_end');
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
