<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class verifyExecution extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verify-execution';

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
        // Aquí puedes agregar la lógica para verificar la ejecución de los comandos
        $this->info('Se inicio el proceso de Schedule para verificar la ejecución de los comandos');
        $this->line('Display this on the screen');
        $this->error('Something went wrong!');


    }
}
