<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmploymentFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('marital_status')->nullable()->after('password'); // Estado civil
            $table->string('staff_type')->nullable()->after('marital_status'); // Tipo de personal
            $table->string('work_shift')->nullable()->after('staff_type'); // Jornada laboral
            $table->boolean('rotates_shifts')
                ->nullable()
                ->default(false)->after('work_shift'); // Si realiza rotación de turnos
            $table->enum('time_in_position', [
                'lt_6m',    // menos de 6 meses
                '6m_1y',    // entre 6 meses y 1 año
                '1_4y',     // entre 1 a 4 años
                '5_9y',     // entre 5 a 9 años
                '10_14y',   // 10 a 14
                '15_19y',   // 15 a 19
                '20_24y',   // 20 a 24
                '25_plus',  // 25 años o más
            ])->nullable()->after('rotates_shifts');
            $table->unsignedInteger('experience_years')->nullable()->after('time_in_position'); // Años de experiencia

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'marital_status',
                'staff_type',
                'work_shift',
                'rotates_shifts',
                'time_in_position',
                'experience_years'
            ]);
        });
    }
}
