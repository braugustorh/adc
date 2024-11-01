<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->integer('evaluation_grades')->nullable()->default(360)->after('department_id');
        });
    }

    public function down()
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->dropColumn('evaluation_grades');
        });
    }
};
