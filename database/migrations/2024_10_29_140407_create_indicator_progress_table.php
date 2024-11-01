<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up(){
        Schema::create('indicator_progresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indicator_id')->constrained()->onDelete('cascade');
            $table->integer('month');
            $table->integer('year');
            $table->integer('progress_value');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicator_progress');
    }
};
