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
        Schema::table('psychometries', function (Blueprint $table) {
            $table->decimal('leadership', 4,2)->nullable();
            $table->decimal('communication', 4,2)->nullable();
            $table->decimal('conflict_management', 4,2)->nullable();
            $table->decimal('negotiation', 4,2)->nullable();
            $table->decimal('organization', 4,2)->nullable();
            $table->decimal('problem_analysis', 4,2)->nullable();
            $table->decimal('decision_making', 4,2)->nullable();
            $table->decimal('strategic_thinking', 4,2)->nullable();
            $table->decimal('resilience', 4,2)->nullable();
            $table->decimal('focus_on_results', 4,2)->nullable();
            $table->decimal('teamwork', 4,2)->nullable();
            $table->decimal('willingness_service', 4,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('psychometries', function (Blueprint $table) {
            $table->dropColumn('leadership');
            $table->dropColumn('communication');
            $table->dropColumn('conflict_management');
            $table->dropColumn('negotiation');
            $table->dropColumn('organization');
            $table->dropColumn('problem_analysis');
            $table->dropColumn('decision_making');
            $table->dropColumn('strategic_thinking');
            $table->dropColumn('resilience');
            $table->dropColumn('focus_on_results');
            $table->dropColumn('teamwork');
            $table->dropColumn('willingness_service');

        });
    }
};
