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
        Schema::create('answer_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description',255)->nullable()->default(null);
            $table->boolean('status')->default(true)->index();
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