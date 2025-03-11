<?php

namespace App\Console\Commands;

use App\Models\Evaluation360Response;
use Illuminate\Console\Command;
use App\Models\EvaluationAssign;

class DepureEvaluations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:depure-evaluations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Depuring evaluations...');
        $this->info('Eliminando Registros de Respuestas de Evaluación 360');
        $deleteResponses= Evaluation360Response::query()->delete();
        $this->info('Eliminando Registros de Asignaciones');
        $deleteAssignations = EvaluationAssign::query()->delete();
        $this->info('Eliminando Registros de Historial de Evaluaciones');
        $this->info('Evaluations depured successfully.');
    }
}
