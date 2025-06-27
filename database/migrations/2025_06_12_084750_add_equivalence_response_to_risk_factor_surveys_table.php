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
        Schema::table('risk_factor_surveys', function (Blueprint $table) {
            $table->integer('equivalence_response')->nullable()->after('response_value');
        });
    }

    public function down(): void
    {
        Schema::table('risk_factor_surveys', function (Blueprint $table) {
            $table->dropColumn('equivalence_response');
        });
    }
};
