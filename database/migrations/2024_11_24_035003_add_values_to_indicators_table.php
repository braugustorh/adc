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
        Schema::table('indicators', function (Blueprint $table) {
            $table->string('indicator_type');
            $table->string('indicator_unit_id', 15);
            $table->date('target_period_start');
            $table->date('target_period_end');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('indicators', function (Blueprint $table) {
            $table->dropColumn('indicator_type');
            $table->dropColumn('indicator_unit_id');
            $table->dropColumn('target_period_start');
            $table->dropColumn('target_period_end');
        });
    }
};
