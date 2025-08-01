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
        Schema::table('risk_factor_survey_organizationals', function (Blueprint $table) {
            $table->string('response_value',20)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('risk_factor_survey_organizationals', function (Blueprint $table) {
            $table->dropColumn('response_value');
        });
    }
};
