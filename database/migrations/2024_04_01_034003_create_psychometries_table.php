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
        Schema::create('psychometries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('test_name', 100)->nullable();
            $table->string('test_description', 255)->nullable();
            $table->string('result_url', 250);
            $table->string('interpretation_url', 250);
            $table->string('comments', 255)->nullable();
            $table->date('application_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychometries');
    }
};
