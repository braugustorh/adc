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
        // Crear tabla traumatic_events si no existe

            Schema::create('traumatic_events', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('identified_id')->nullable()->constrained('identified_collaborators')->onDelete('cascade');
                $table->string('event_type'); // Enum como string
                $table->text('description')->nullable();
                $table->dateTime('date_occurred')->nullable(); // Fecha en que ocurrió el evento
                $table->timestamps();

                // Índices
                $table->index( 'user_id');
                $table->index('event_type');
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traumatic_events');
    }

};
