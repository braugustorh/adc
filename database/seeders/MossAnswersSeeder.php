<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Answer;
use Illuminate\Support\Facades\DB;

class MossAnswersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Rango de IDs de tus preguntas Moss (WES)
        $startId = 295;
        $endId = 382;

        $answers = [];

        // Generamos el array masivo para insertar all de un jalón (más rápido)
        for ($questionId = $startId; $questionId <= $endId; $questionId++) {

            // Opción: Verdadero
            $answers[] = [
                'question_id' => $questionId,
                'text'        => 'Verdadero',
                'weight'       => 1, // Usamos 1 para representar True
                'is_correct' => 0, // Marcamos esta opción como correcta
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            // Opción: Falso
            $answers[] = [
                'question_id' => $questionId,
                'text'        => 'Falso',
                'weight'       => 0, // Usamos 0 para representar False
                'is_correct' => 0, // Marcamos esta opción como incorrecta
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        // Insertamos en lotes (chunks) para no ahogar la base de datos si fueran muchos
        // Aunque 180 registros es poco, es buena práctica.
        foreach (array_chunk($answers, 50) as $chunk) {
            Answer::insert($chunk);
        }
    }
}
