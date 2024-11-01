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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            //Datos Personales
            $table->string('name', 100)->index();
            $table->string('first_name', 100)->index()->nullable();
            $table->string('last_name',100)->nullable();
            $table->string('curp',18)->nullable()->unique();
            $table->tinyText('sex')->nullable();
            $table->string('nationality')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('birth_country',100)->nullable();
            $table->string('birth_state',100)->nullable();
            $table->string('birth_city',100)->nullable();
            $table->string('disability',65)->nullable();
            $table->string('email',80)->unique()->index();
            $table->string('phone',10)->nullable();
            $table->string('emergency_name',100)->nullable();
            $table->string('emergency_phone',100)->nullable();
            $table->string('relationship_contact',100)->nullable();
            //Domicilio
            $table->string('address',255)->nullable();
            $table->string('colony',100)->nullable();
            $table->integer('cp')->nullable();
            $table->string('state',100)->nullable();
            $table->string('city',100)->nullable();
            //Datos Escolares
            $table->string('scholarship',100)->nullable();
            $table->string('career',100)->nullable();
            //Datos Laborales
            $table->string('employee_code',25)->nullable()->index();
            $table->foreignId('sede_id')->nullable()->references('id')->on('sedes');
            $table->foreignId('department_id')->nullable()->references('id')->on('departments');
            $table->foreignId('position_id')->nullable()->references('id')->on('positions');
            $table->string('rfc',13)->nullable();
            $table->string('imss',11)->nullable();
            $table->string('contract_type',40)->nullable(); //Sidicalizado, Confianza, Eventual, Temporal, Por Obra, Por Proyecto, Otro
            $table->string('employee_number',10)->nullable();
            $table->date('entry_date')->nullable();
            $table->string('password');
            $table->boolean('status')->default(true);
            $table->rememberToken();
            $table->timestamps();
            //Imagen de Perfil
            $table->string('profile_photo', 450)->nullable();
            $table->timestamp('email_verified_at')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
