<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\DB;

class CleaverSeeder extends Seeder
{
    public function run()
    {
        // ID del Test Cleaver (Según tu indicación es el 11)
        // OJO: Si el 11 es el ID en la tabla 'evaluation_types', úsalo aquí.
        // Si el 11 fuera una 'parent question', habría que ajustar, pero asumo que es el Tipo de Evaluación.
        $cleaverTypeId = 11;

        // Tipo de respuesta para Cleaver (Según tu código anterior es el 6)
        $answerTypeId = 5;
        $competenceId = 53; // Se Generó una competencia generar para agrupar ahí las preguntas del cleaver

        // Listado completo de las 24 Series del Cleaver Clásico
        $series = [
            1 => ['Persuasivo', 'Gentil', 'Humilde', 'Original'],
            2 => ['Agresivo', 'Alma de la fiesta', 'Comodino', 'Temeroso'],
            3 => ['Agradable', 'Temeroso de Dios', 'Tenaz', 'Atractivo'],
            4 => ['Cauteloso', 'Determinado', 'Convincente', 'Bonachón'],
            5 => ['Dócil', 'Atrevido', 'Leal', 'Encantador'],
            6 => ['Dispuesto', 'Deseoso', 'Consecuente', 'Entusiasta'],
            7 => ['Fuerza de voluntad', 'Mente abierta', 'Complaciente', 'Animoso'],
            8 => ['Confiado', 'Simpatizador', 'Tolerante', 'Afirmativo'],
            9 => ['Ecuánime', 'Preciso', 'Nervioso', 'Jovial'],
            10 => ['Disciplinado', 'Generoso', 'Animoso', 'Persistente'],
            11 => ['Competitivo', 'Alegre', 'Considerado', 'Armonioso'],
            12 => ['Admirable', 'Bondadoso', 'Resignado', 'Carácter Firme'],
            13 => ['Obediente', 'Quisquilloso', 'Inconquistable', 'Juguetón'],
            14 => ['Respetuoso', 'Emprendedor', 'Optimista', 'Servicial'],
            15 => ['Valiente', 'Inspirador', 'Sumiso', 'Tímido'],
            16 => ['Adaptable', 'Disputador', 'Indiferente', 'Sangre liviana'],
            17 => ['Amiguero', 'Paciente', 'Confianza en sí mismo', 'Mesurado para hablar'],
            18 => ['Conforme', 'Confiable', 'Pacífico', 'Positivo'],
            19 => ['Aventurero', 'Receptivo', 'Cordial', 'Moderado'],
            20 => ['Indulgente', 'Esteta', 'Vigoroso', 'Sociable'],
            21 => ['Parlanchín', 'Controlado', 'Convencional', 'Decisivo'],
            22 => ['Cohibido', 'Exacto', 'Franco', 'Buen compañero'],
            23 => ['Diplomático', 'Audaz', 'Refinado', 'Satisfecho'],
            24 => ['Inquieto', 'Popular', 'Buen vecino', 'Devoto'],
        ];

        DB::transaction(function () use ($series, $cleaverTypeId, $answerTypeId,$competenceId) {
            foreach ($series as $index => $words) {

                // 1. Crear la "Pregunta" (El contenedor de la serie)
                $question = Question::create([
                    'evaluations_type_id' => $cleaverTypeId,
                    'question'           => 'Serie ' . $index, // Nombre interno
                    'answer_type_id'     => $answerTypeId,     // 6 = Cleaver
                    'order'              => $index,
                    'competence_id'      => $competenceId, // Las series no tienen competencia única
                    'status'          => true,
                ]);

                // 2. Crear las 4 "Respuestas" (Las palabras)
                foreach ($words as $word) {
                    Answer::create([
                        'question_id' => $question->id,
                        'text'        => $word,
                        'is_correct' => false, // En Cleaver no hay respuestas "correctas"
                        'weight'       => 0, // En Cleaver el valor depende de si es MOST o LEAST, se calcula después
                    ]);
                }
            }
        });
    }
}
