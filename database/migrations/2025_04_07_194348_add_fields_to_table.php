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
        Schema::table('indicator_ranges', function (Blueprint $table) {
            $table->integer('excellent_maximum_value')->nullable()->after('excellent_threshold');
            $table->integer('satisfactory_maximum_value')->nullable()->after('satisfactory_threshold');
            $table->integer('unsatisfactory_maximum_value')->nullable()->after('unsatisfactory_threshold');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('indicator_ranges', function (Blueprint $table) {
            $table->dropColumn(['excellent_maximum_value', 'satisfactory_maximum_value', 'unsatisfactory_maximum_value']);
        });
    }
};
