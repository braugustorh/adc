<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EvaluationsTypes;
use App\Models\AnswerType;
use App\Models\Question;
use App\Models\Answers;
use App\Models\Competence; // Asumiendo que tienes este modelo
use Illuminate\Support\Facades\DB;

class PsychometricSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Asegurar Tipos de Respuesta (Widgets)
        $multipleChoice = AnswerType::firstOrCreate(['id' => 2], ['name' => 'Opción Múltiple', 'description' => 'Selección única', 'status' => 1]);
        $trueFalse = AnswerType::firstOrCreate(['id' => 4], ['name' => 'Verdadero o Falso', 'description' => 'Binario', 'status' => 1]);
        $cleaverType = AnswerType::firstOrCreate(['id' => 5], ['name' => 'Selección Forzada (Cleaver)', 'description' => 'Más y Menos', 'status' => 1]);
        /*
        // 2. CREAR PRIMERO LOS TIPOS DE EVALUACIÓN (Para tener los IDs)
        $moss = EvaluationsTypes::firstOrCreate(['name' => 'Test de Moss'], ['description' => 'Habilidades Gerenciales', 'status' => 1]);
        $mossWes = EvaluationsTypes::firstOrCreate(['name' => 'Test de Moss Wes'], ['description' => 'Versión rápida', 'status' => 1]);
        $cleaver = EvaluationsTypes::firstOrCreate(['name' => 'Cleaver'], ['description' => 'Comportamiento DISC', 'status' => 1]);
        */
        $mossWes=9;
        $moss=10;
        $cleaver=11;

        // 3. CREAR COMPETENCIAS (Ligadas a su evaluación correspondiente para evitar error 1364)
        // Competencias para Moss
        $compSupervision = Competence::firstOrCreate(
            ['name' => 'Habilidad de Supervisión'],
            ['evaluations_type_id' => $moss] // <--- AQUÍ LA CORRECCIÓN
        );
        $compTacto = Competence::firstOrCreate(
            ['name' => 'Tacto y Diplomacia'],
            ['evaluations_type_id' => $moss]
        );

        // Competencias para Cleaver (Aunque Cleaver no las usa igual, la BD lo pide)
        $compHonestidad = Competence::firstOrCreate(
            ['name' => 'Honestidad'], // Nombre dummy para Cleaver
            ['evaluations_type_id' => $cleaver]
        );

        // ---------------------------------------------------------
        // ESCENARIO A: TEST DE MOSS (Clásico)
        // ---------------------------------------------------------
        $qMoss = Question::create([
            'evaluations_type_id' => $moss,
            'question' => 'Se le ha asignado un puesto. El anterior jefe era muy querido, pero ineficiente. ¿Qué hace?',
            'answer_type_id' => $multipleChoice->id,
            'competence_id' => $compSupervision->id,
            'order' => 1,
            'status' => 1
        ]);

        Answers::create(['question_id' => $qMoss->id, 'text' => 'Trato de imitar al jefe anterior', 'weight' => 1, 'competence_id' => $compTacto->id]);
        Answers::create(['question_id' => $qMoss->id, 'text' => 'Impongo mi autoridad desde el día 1', 'weight' => 2, 'competence_id' => $compSupervision->id]);
        Answers::create(['question_id' => $qMoss->id, 'text' => 'Hablo con el equipo para conocerlos', 'weight' => 3, 'competence_id' => $compSupervision->id]);

        // ---------------------------------------------------------
        // ESCENARIO B: TEST DE MOSS WES (Verdadero/Falso)
        // ---------------------------------------------------------
        $qMossWes = Question::create([
            'evaluations_type_id' => $mossWes,
            'question' => '¿Prefiere trabajar solo que acompañado?',
            'answer_type_id' => $trueFalse->id,
            'competence_id' => $compTacto->id, // Reutilizamos Tacto, pero ojo: en tu BD esta competencia pertenece a Moss normal.
            // Si tienes restricción estricta, crea una competencia nueva ligada a $mossWes->id
            'order' => 1,
            'status' => 1
        ]);

        Answers::create(['question_id' => $qMossWes->id, 'text' => 'Verdadero', 'weight' => 1, 'competence_id' => null]);
        Answers::create(['question_id' => $qMossWes->id, 'text' => 'Falso', 'weight' => 0, 'competence_id' => null]);

        // ---------------------------------------------------------
        // ESCENARIO C: CLEAVER (El Reto)
        // ---------------------------------------------------------
        $qCleaver1 = Question::create([
            'evaluations_type_id' => $cleaver,
            'question' => 'Serie 1',
            'answer_type_id' => $cleaverType->id,
            'competence_id' => $compHonestidad->id,
            'order' => 1,
            'status' => 1
        ]);

        Answers::create(['question_id' => $qCleaver1->id, 'text' => 'Persuasivo', 'weight' => 0]);
        Answers::create(['question_id' => $qCleaver1->id, 'text' => 'Gentil', 'weight' => 0]);
        Answers::create(['question_id' => $qCleaver1->id, 'text' => 'Humilde', 'weight' => 0]);
        Answers::create(['question_id' => $qCleaver1->id, 'text' => 'Original', 'weight' => 0]);
    }
}
