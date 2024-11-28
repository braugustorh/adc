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
            $table->string('expression_excellent',20);
            $table->string('expression_satisfactory',20);
            $table->string('expression_unsatisfactory',20);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('indicator_ranges', function (Blueprint $table) {
            $table->dropColumn('expression_excellent');
            $table->dropColumn('expression_satisfactory');
            $table->dropColumn('expression_unsatisfactory');
        });
    }
};
