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
        Schema::create('user_terminations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('processed_by')->constrained('users');
            //fecha efectiva de baja
            $table->date('termination_date');
            /*
            // Tipo de Baja
            $table->enum('termination_type', [
                'renuncia_voluntaria',
                'despido',
                'terminacion_contrato',
                'jubilacion',
                'incapacidad',
                'otro'
            ]);
            */
            $table->string('termination_type',255)->nullable()->default(null);

            $table->string('other_reason')->nullable();
            $table->boolean('prior_notice')->default(false);
            $table->integer('notice_days')->nullable();

            // Se envío Entrevista de Salida
            $table->boolean('exit_interview')->default(false);
            // Fecha de entrevista de salida
            $table->date('interview_date')->nullable();
            // Entrevistador
            $table->foreignId('interviewer_id')->nullable()->constrained('users');

            // Evaluación
            // Motivo de la baja
            $table->text('detailed_reason');
            // Desempeño
            $table->enum('performance', ['bueno', 'regular', 'deficiente']);
            // Comentarios de desempeño
            $table->text('performance_comments');
            // Comentarios del empleado
            $table->text('employee_feedback')->nullable();
            // Comentarios del supervisor
            $table->text('supervisor_feedback');

            // Documentos entregados
            $table->json('documents_delivered')->nullable();
            //liquidación completa
            $table->boolean('settlement_completed')->default(false);
            //detalles de la liquidación
            $table->text('settlement_details')->nullable();
            //acceso a sistemas desactivado
            $table->boolean('access_deactivated')->default(false);
            //fecha de desactivación de acceso
            $table->date('access_deactivation_date')->nullable();

            // Análisis

            // Reemplazo de posición
            $table->boolean('position_replaced')->default(false);
            // Urgencia del reemplazo
            $table->string('replacement_urgency',255)->nullable()->default(null);
            // Impacto en el equipo
            $table->boolean('impacts_team')->default(false);

            //Recomendable para recontratación
            $table->boolean('re_hire')->default(false);

            //Mas comentarios
            $table->text('additional_comments')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_terminations');
    }
};
