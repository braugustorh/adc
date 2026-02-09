<?php

namespace App\Services;

use App\Models\PsychometricEvaluation;
use App\Models\EvaluationUserAnswer;

class PsychometricScoringService
{
    public function calculate(PsychometricEvaluation $evaluation)
    {
        // Asumiendo IDs: 10=Moss, 11=Cleaver, 12=Kostick, 13=MostWess
        switch ($evaluation->evaluations_type_id) {
            case 10:
                return $this->calculateMoss($evaluation);
            case 11:
                return $this->calculateCleaver($evaluation);
            case 12:
                return $this->calculateKostick($evaluation);
            case 9: // <--- NUEVO CASO AGREGADO
                return $this->calculateMossWess($evaluation);
            default:
                return ['error' => 'Tipo de evaluación no soportado. ID: ' . $evaluation->evaluations_type_id];
        }
    }

    /**
     * LÓGICA DE MOSS WESS (Clima Social / Work Environment Scale)
     * Estructura: Preguntas -> Subescalas (10) -> Dimensiones (3) -> Baremos
     */
    private function calculateMossWess($evaluation)
    {
        // =========================================================================
        // PASO 1: ARRAYS DE CONFIGURACIÓN (Aquí debes completar con tus imágenes)
        // =========================================================================

        // 1.1 CLAVE DE RESPUESTAS (CORRECTION KEY)
        // Define si la respuesta correcta es 'V' o 'F' para cada una de las 90 preguntas.
        // HE LLENADO LA SUBESCALA IM (1, 11, 21...) SEGÚN TU EJEMPLO.
        // ¡DEBES LLENAR EL RESTO!
        $correctionKey = [
            // Subescala 1: Implicación (IM) - COMPLETA
            1 => 'V', 11 => 'F', 21 => 'F', 31 => 'V', 41 => 'V',
            51 => 'F', 61 => 'V', 71 => 'F', 81 => 'V',
            // Subescala 2: Cohesión (CO) - COMPLETA
            2 => 'V', 12 => 'F', 22 => 'V', 32 => 'F', 42 => 'V',
            52 => 'V', 62 => 'F', 72 => 'V', 82 => 'F',
            // Subescala 3: Apoyo (AP) - COMPLETA
            3 => 'F', 13 => 'V', 23 => 'F', 33 => 'V', 43 => 'F',
            53 => 'V', 63 => 'F', 73 => 'V', 83 => 'V',
            // Subescala 4: Autonomía (AU) - COMPLETA
            4 => 'F', 14 => 'V', 24 => 'V', 34 => 'V', 44 => 'V',
            54 => 'F', 64 => 'V', 74 => 'V', 84 => 'V',
            // Subescala 5: Organización (OR) - COMPLETA
            5 => 'V', 15 => 'F', 25 => 'V', 35 => 'V', 45 => 'V',
            55 => 'V', 65 => 'V', 75 => 'F', 85 => 'F',
            // Subescala 6: Presión (PR) - COMPLETA
            6 => 'V', 16 => 'V', 26 => 'V', 36 => 'F', 46 => 'F',
            56 => 'V', 66 => 'F', 76 => 'V', 86 => 'V',
            // Subescala 7: Claridad (CL) - COMPLETA
            7 => 'F', 17 => 'V', 27 => 'F', 37 => 'V', 47 => 'F',
            57 => 'F', 67 => 'V', 77 => 'F', 87 => 'V',
            // Subescala 8: Control (CN) - COMPLETA
            8 => 'V', 18 => 'F', 28 => 'V', 38 => 'V', 48 => 'V',
            58 => 'V', 68 => 'V', 78 => 'V', 88 => 'F',
            // Subescala 9: Innovación (IN) - COMPLETA
            9 => 'V', 19 => 'V', 29 => 'V', 39 => 'F', 49 => 'F',
            59 => 'F', 69 => 'F', 79 => 'V', 89 => 'V',
            // Subescala 10: Comodidad Física (CF) - COMPLETA
            10 => 'F', 20 => 'V', 30 => 'F', 40 => 'V', 50 => 'F',
            60 => 'V', 70 => 'F', 80 => 'V', 90 => 'V',
        ];

        // 1.2 MAPA DE SUBESCALAS
        // Agrupa qué preguntas pertenecen a qué sigla. (Esto es estándar del WES)
        $subscalesMap = [
            'IM' => [1, 11, 21, 31, 41, 51, 61, 71, 81], // Implicación
            'CO' => [2, 12, 22, 32, 42, 52, 62, 72, 82], // Cohesión
            'AP' => [3, 13, 23, 33, 43, 53, 63, 73, 83], // Apoyo
            'AU' => [4, 14, 24, 34, 44, 54, 64, 74, 84], // Autonomía
            'OR' => [5, 15, 25, 35, 45, 55, 65, 75, 85], // Organización
            'PR' => [6, 16, 26, 36, 46, 56, 66, 76, 86], // Presión
            'CL' => [7, 17, 27, 37, 47, 57, 67, 77, 87], // Claridad
            'CN' => [8, 18, 28, 38, 48, 58, 68, 78, 88], // Control
            'IN' => [9, 19, 29, 39, 49, 59, 69, 79, 89], // Innovación
            'CF' => [10, 20, 30, 40, 50, 60, 70, 80, 90] // Comodidad Física
        ];

        // 1.3 MAPA DE DIMENSIONES (Imagen 4)
        // Agrupa las subescalas en las 3 grandes áreas
        $dimensionsMap = [
            'Relaciones' => ['IM', 'CO', 'AP'],
            'Auto-realización' => ['AU', 'OR', 'PR'], // A veces llamada "Desarrollo Personal"
            'Estabilidad/Cambio' => ['CL', 'CN', 'IN', 'CF'] // A veces llamada "Mantenimiento del Sistema"
        ];

        // 1.4 TABLA DE BAREMOS POR DIMENSIÓN (Imagen 3)
        // Define los rangos para asignar categoría a la SUMA de la dimensión.
        // He puesto el ejemplo de Relaciones que me diste (16-20 = Promedio).
        // DEBES AJUSTAR LOS NÚMEROS EXACTOS DE TUS TABLAS.
        $baremos = [
            'Relaciones' => [
                ['max' => 5, 'label' => 'Excelente', 'color' => 'green'],
                ['max' => 10, 'label' => 'Buena', 'color' => 'green'],
                ['max' => 15, 'label' => 'Promedio', 'color' => 'blue'], // Tu ejemplo: 17 cae aquí
                ['max' => 20, 'label' => 'Tiende a Buena', 'color' => 'gray'],
                ['max' => 24, 'label' => 'Mala', 'color' => 'orange'],
                ['max' => 90, 'label' => 'Deficiente', 'color' => 'red'],
            ],
            'Auto-realización' => [
                ['max' => 4, 'label' => 'Excelente', 'color' => 'green'],
                ['max' => 9, 'label' => 'Buena', 'color' => 'green'],
                ['max' => 14, 'label' => 'Promedio', 'color' => 'blue'], // Tu ejemplo: 17 cae aquí
                ['max' => 18, 'label' => 'Tiende a Buena', 'color' => 'gray'],
                ['max' => 23, 'label' => 'Mala', 'color' => 'orange'],
                ['max' => 90, 'label' => 'Deficiente', 'color' => 'red'],
            ],
            'Estabilidad/Cambio' => [
                ['max' => 6, 'label' => 'Excelente', 'color' => 'green'],
                ['max' => 13, 'label' => 'Buena', 'color' => 'green'],
                ['max' => 15, 'label' => 'Promedio', 'color' => 'blue'], // Tu ejemplo: 17 cae aquí
                ['max' => 19, 'label' => 'Tiende a Buena', 'color' => 'gray'],
                ['max' => 24, 'label' => 'Mala', 'color' => 'orange'],
                ['max' => 90, 'label' => 'Deficiente', 'color' => 'red'],
            ],
        ];

        // =========================================================================
        // PASO 2: CÁLCULO DE PUNTOS (MOTOR)
        // =========================================================================

        // 2.1 Obtener respuestas del usuario
        $userAnswers = EvaluationUserAnswer::where('psychometric_evaluation_id', $evaluation->id)
            ->join('answers', 'evaluation_user_answers.answer_id', '=', 'answers.id')
            ->join('questions', 'answers.question_id', '=', 'questions.id')
            ->select('questions.order', 'answers.text')
            ->get();

        // 2.2 Calcular Puntuación Directa (PD) por Subescala
        $subscaleScores = array_fill_keys(array_keys($subscalesMap), 0);

        foreach ($userAnswers as $ans) {
            $qNum = $ans->order;

            // Si tenemos la clave para esa pregunta
            if (isset($correctionKey[$qNum])) {
                $expected = $correctionKey[$qNum];

                // Normalizamos respuesta del usuario (Busca 'V' o 'F' en el texto)
                $userVal = '';
                if (stripos($ans->text, 'V') !== false) $userVal = 'V';
                elseif (stripos($ans->text, 'F') !== false) $userVal = 'F';

                // Si coincide, suma 1 punto
                if ($userVal === $expected) {
                    // Buscamos a qué subescala pertenece esta pregunta
                    foreach ($subscalesMap as $subKey => $qList) {
                        if (in_array($qNum, $qList)) {
                            $subscaleScores[$subKey]++;
                            break;
                        }
                    }
                }
            }
        }

        // 2.3 Calcular Puntuación por Dimensión y Asignar Categoría
        $dimensionResults = [];

        foreach ($dimensionsMap as $dimName => $subKeys) {
            $dimTotal = 0;
            // Sumar los puntajes de las subescalas de esta dimensión
            foreach ($subKeys as $sub) {
                if (isset($subscaleScores[$sub])) {
                    $dimTotal += $subscaleScores[$sub];
                }
            }

            // Buscar en Baremos
            $categoryLabel = 'N/A';
            $categoryColor = 'gray';

            if (isset($baremos[$dimName])) {
                foreach ($baremos[$dimName] as $rango) {
                    if ($dimTotal <= $rango['max']) {
                        $categoryLabel = $rango['label'];
                        $categoryColor = $rango['color'];
                        break;
                    }
                }
            }

            $dimensionResults[$dimName] = [
                'score' => $dimTotal,
                'category' => $categoryLabel,
                'color' => $categoryColor
            ];
        }

        // =========================================================================
        // PASO 3: RETORNO DE DATOS
        // =========================================================================

        return [
            'test_name' => 'Moss Wess (Clima Social)',
            'chart_type' => 'bar_grouped', // Gráfica de barras agrupadas por dimensión
            'dimensions' => $dimensionResults, // Resultado final (Relaciones: 17 - Promedio)
            'subscales' => $subscaleScores,   // Detalle (IM: 5, CO: 4...)
            'summary' => "Perfil de Clima Social basado en " . count($dimensionResults) . " dimensiones."
        ];
    }

    // --- MÉTODOS ANTERIORES (Kostick, Moss, Cleaver) SE MANTIENEN IGUAL ---

    private function calculateKostick($evaluation)
    {
        $answers = EvaluationUserAnswer::where('psychometric_evaluation_id', $evaluation->id)
            ->join('answers', 'evaluation_user_answers.answer_id', '=', 'answers.id')
            ->select('answers.code')
            ->get();

        // Inicializamos las 20 dimensiones en 0 para que la gráfica salga completa
        $scores = [
            'G' => 0, 'L' => 0, 'P' => 0, 'I' => 0, 'T' => 0, 'V' => 0, 'X' => 0, 'S' => 0, 'B' => 0, 'O' => 0,
            'R' => 0, 'D' => 0, 'C' => 0, 'Z' => 0, 'E' => 0, 'K' => 0, 'F' => 0, 'W' => 0, 'N' => 0, 'A' => 0
        ];

        foreach ($answers as $ans) {
            if ($ans->code && isset($scores[$ans->code])) {
                $scores[$ans->code]++;
            }
        }

        return [
            'test_name' => 'Kostick',
            'chart_type' => 'radar',
            'scores' => $scores,
            'summary' => "Perfil de comportamiento y preferencias."
        ];
    }

    private function calculateMoss($evaluation)
    {
        // 1. MAPEO: ¿A qué dimensión pertenece cada pregunta? (Estándar Moss)
        // Formato: [Número de Pregunta => ID de Dimensión]
        $map = [
            1 => 4, 2 => 1, 3 => 1, 4 => 2, 5 => 5,
            6 => 2, 7 => 3, 8 => 5, 9 => 3, 10 => 4,
            11 => 4, 12 => 3, 13 => 4, 14 => 3, 15 => 5,
            16 => 1, 17 => 5, 18 => 1, 19 => 3, 20 => 2,
            21 => 3, 22 => 5, 23 => 2, 24 => 1, 25 => 4,
            26 => 3, 27 => 3, 28 => 5, 29 => 2, 30 => 1
        ];
        $dimensions = [
            1 => [
                'name' => 'Habilidad de Supervisión',
                'completeName' => 'Habilidad de Supervisión',
                'description' => 'Es la eficacia con que propicia que el personal a su cargo cumpla con las actividades encomendadas.',
                'total_questions' => 6,
                'score' => 0
            ],
            2 => [
                'name' => 'Capacidad de Decisión',
                'completeName' => 'Capacidad de decisión en las Relaciones Humanas', // (Capacidad de decisión en las Relaciones Humanas)
                'description' => 'Es el criterio y toma de decisiones con respecto a la forma de interactuar con los demás.',
                'total_questions' => 5,
                'score' => 0
            ],
            3 => [
                'name' => 'Capacidad de Evaluación',
                'completeName' => 'Capacidad para Evaluar Problemas Interpersonales', // (Capacidad para Evaluar Problemas Interpersonales)
                'description' => 'Criterio y juicio con respecto a situaciones sociales que presentan conflicto con cierta problemática.',
                'total_questions' => 8,
                'score' => 0
            ],
            4 => [
                'name' => 'Habilidad de Relacionarse',
                'completeName' => 'Capacidad para Establecer Relaciones Interpersonales', // (Capacidad para Establecer Relaciones Interpersonales)
                'description' => 'Es la facultad con que cuenta para establecer contacto con los demás de manera adaptativa y eficiente.',
                'total_questions' => 5,
                'score' => 0
            ],
            5 => [
                'name' => 'Sentido Común y Tacto',
                'completeName' => 'Sentido común y tacto en las Relaciones Interpersonales', // (Sentido común y tacto en las Relaciones Interpersonales)
                'description' => 'Capacidad de llevarse bien con los demás manteniendo una conducta basada en el buen juicio y la lógica ante dificultades o conflictos.',
                'total_questions' => 6,
                'score' => 0
            ],
        ];

        $feedbackMatrix = [
            'Habilidad de Supervisión' => [
                'Excelente' => [
                    'interpretation' => 'Liderazgo excepcional, delegación precisa y monitoreo constante.',
                    'recommendation' => 'Asignar proyectos estratégicos y fomentar su mentoría a otros supervisores.'
                ],
                'Superior' => [
                    'interpretation' => 'Sobresale en supervisión, aunque puede perfeccionar aspectos menores de liderazgo.',
                    'recommendation' => 'Ofrecer oportunidades de liderazgo en proyectos clave.'
                ],
                'Superior al Término Medio' => [
                    'interpretation' => 'Buen desempeño en supervisión, con áreas específicas para mejorar en eficiencia o seguimiento.',
                    'recommendation' => 'Capacitación en habilidades avanzadas de supervisión y liderazgo.'
                ],
                'Término Medio' => [
                    'interpretation' => 'Supervisión adecuada pero inconsistente en situaciones críticas.',
                    'recommendation' => 'Reforzar habilidades con talleres de supervisión y seguimiento estructurado.'
                ],
                'Inferior al Término Medio' => [
                    'interpretation' => 'Falta de claridad en liderazgo y supervisión, impactando la productividad del equipo.',
                    'recommendation' => 'Capacitación en fundamentos de supervisión y asignación de tareas guiadas.'
                ],
                'Inferior' => [
                    'interpretation' => 'Deficiencias significativas en supervisión, dificultando la ejecución eficiente del trabajo.',
                    'recommendation' => 'Coaching intensivo y supervisión directa por un líder experimentado.'
                ],
                'Deficiente' => [
                    'interpretation' => 'Incapacidad para supervisar adecuadamente, afectando el logro de objetivos organizacionales.',
                    'recommendation' => 'Implementar un plan de desarrollo intensivo y reevaluar su ajuste al rol de supervisión.'
                ],
            ],

            'Capacidad de Decisión' => [
                'Excelente' => [
                    'interpretation' => 'Habilidad excepcional para crear conexiones y mantener relaciones laborales positivas.',
                    'recommendation' => 'Asignar tareas que requieran mediación o manejo de conflictos sensibles.'
                ],
                'Superior' => [
                    'interpretation' => 'Relaciones humanas destacadas, con capacidad de comunicación efectiva y empatía.',
                    'recommendation' => 'Delegar roles donde la interacción interpersonal sea clave, como recursos humanos o ventas.'
                ],
                'Superior al Término Medio' => [
                    'interpretation' => 'Buenas habilidades interpersonales, con margen de mejora en empatía o resolución de conflictos.',
                    'recommendation' => 'Fomentar actividades de desarrollo de inteligencia emocional.'
                ],
                'Término Medio' => [
                    'interpretation' => 'Relaciones humanas aceptables, pero limitadas en contextos más exigentes.',
                    'recommendation' => 'Ofrecer talleres sobre habilidades interpersonales y manejo de conflictos.'
                ],
                'Inferior al Término Medio' => [
                    'interpretation' => 'Dificultades para establecer relaciones positivas o mantenerlas en el tiempo.',
                    'recommendation' => 'Entrenamiento en habilidades sociales y comunicación efectiva.'
                ],
                'Inferior' => [
                    'interpretation' => 'Problemas evidentes en relaciones interpersonales que afectan la dinámica de equipo.',
                    'recommendation' => 'Asignar un mentor y monitorear su progreso en ambientes colaborativos.'
                ],
                'Deficiente' => [
                    'interpretation' => 'Relaciones humanas deficientes, con riesgo de afectar el clima laboral de manera crítica.',
                    'recommendation' => 'Intervención inmediata con coaching especializado en inteligencia emocional y relaciones.'
                ],
            ],
            'Capacidad de Evaluación' => [
                'Excelente' => [
                    'interpretation' => 'Gran precisión al analizar y evaluar situaciones, con criterio confiable y decisiones efectivas.',
                    'recommendation' => 'Asignar roles de evaluación estratégica en proyectos críticos.'
                ],
                'Superior' => [
                    'interpretation' => 'Capacidad destacada para evaluar, aunque con posibles mejoras en ciertos matices de análisis.',
                    'recommendation' => 'Fomentar su participación en evaluaciones grupales o auditorías.'
                ],
                'Superior al Término Medio' => [
                    'interpretation' => 'Evaluación adecuada, aunque podría mejorar en detalle y profundidad en situaciones específicas.',
                    'recommendation' => 'Proveer herramientas y capacitación avanzada en análisis y evaluación crítica.'
                ],
                'Término Medio' => [
                    'interpretation' => 'Evaluaciones consistentes, pero faltan aspectos clave de detalle en contextos más complejos.',
                    'recommendation' => 'Promover el uso de metodologías estructuradas de análisis.'
                ],
                'Inferior al Término Medio' => [
                    'interpretation' => 'Dificultades para realizar evaluaciones precisas y confiables.',
                    'recommendation' => 'Entrenamiento en métodos básicos de evaluación con prácticas supervisadas.'
                ],
                'Inferior' => [
                    'interpretation' => 'Evaluaciones inconsistentes y poco precisas, afectando la toma de decisiones.',
                    'recommendation' => 'Capacitación intensiva en procesos de evaluación y análisis crítico.'
                ],
                'Deficiente' => [
                    'interpretation' => 'Incapacidad para evaluar, lo que puede generar errores graves en decisiones organizacionales.',
                    'recommendation' => 'Reevaluar las responsabilidades asignadas y realizar un plan de desarrollo intensivo.'
                ],
            ],
            'Habilidad de Relacionarse' => [
                'Excelente' => [
                    'interpretation' => 'Habilidad sobresaliente para interactuar con otros, establecer conexiones sólidas y resolver conflictos de manera efectiva.',
                    'recommendation' => 'Asignar tareas que requieran mediación, liderazgo en equipo, o gestión de relaciones clave con clientes.'
                ],
                'Superior' => [
                    'interpretation' => 'Relaciones interpersonales destacadas, aunque puede haber pequeñas áreas de mejora en situaciones de alta complejidad.',
                    'recommendation' => 'Proveer oportunidades para representar a la organización en eventos clave o liderar proyectos colaborativos.'
                ],
                'Superior al Término Medio' => [
                    'interpretation' => 'Competente en interacciones sociales, pero puede mostrar inconsistencias en contextos de alta presión o incertidumbre.',
                    'recommendation' => 'Implementar capacitaciones avanzadas en empatía, manejo de conflictos y comunicación asertiva.'
                ],
                'Término Medio' => [
                    'interpretation' => 'Capacidad básica para mantener relaciones, pero limitada en contextos desafiantes o dinámicas complejas.',
                    'recommendation' => 'Ofrecer talleres sobre habilidades interpersonales, con un enfoque en empatía y escucha activa.'
                ],
                'Inferior al Término Medio' => [
                    'interpretation' => 'Dificultad para establecer relaciones positivas o resolver conflictos, lo que afecta la colaboración en equipo.',
                    'recommendation' => 'Entrenamiento en habilidades sociales y sesiones de coaching en manejo de relaciones.'
                ],
                'Inferior' => [
                    'interpretation' => 'Relaciones interpersonales deficientes, con impacto negativo en la dinámica del equipo y la comunicación.',
                    'recommendation' => 'Supervisión cercana, mentoría directa y asignación de roles con interacción limitada inicialmente.'
                ],
                'Deficiente' => [
                    'interpretation' => 'Incapacidad para relacionarse adecuadamente con otros, generando conflictos o aislamiento.',
                    'recommendation' => 'Plan de intervención intensiva con coaching especializado y actividades prácticas de integración.'
                ],
            ],
            'Sentido Común y Tacto' => [
                'Excelente' => [
                    'interpretation' => 'Capacidad sobresaliente para aplicar juicio práctico y manejar situaciones delicadas con sensibilidad.',
                    'recommendation' => 'Asignar roles que requieran resolución de conflictos o toma de decisiones críticas con impacto humano.'
                ],
                'Superior' => [
                    'interpretation' => 'Maneja situaciones con tacto y sentido común en la mayoría de los contextos.',
                    'recommendation' => 'Delegar tareas donde la diplomacia y la empatía sean esenciales, como atención a clientes o mediación.'
                ],
                'Superior al Término Medio' => [
                    'interpretation' => 'Buen juicio práctico y tacto en general, pero puede carecer de refinamiento en circunstancias excepcionales.',
                    'recommendation' => 'Brindar oportunidades para practicar toma de decisiones en entornos desafiantes.'
                ],
                'Término Medio' => [
                    'interpretation' => 'Sentido común adecuado, pero con falta de consistencia en situaciones complejas.',
                    'recommendation' => 'Ofrecer capacitación en habilidades de resolución de problemas y toma de decisiones práctica.'
                ],
                'Inferior al Término Medio' => [
                    'interpretation' => 'Dificultad para aplicar juicio práctico en situaciones cotidianas y resolver problemas con tacto.',
                    'recommendation' => 'Implementar talleres de desarrollo de juicio crítico y empatía.'
                ],
                'Inferior' => [
                    'interpretation' => 'Frecuentes errores de juicio práctico y falta de tacto en sus interacciones.',
                    'recommendation' => 'Reforzar habilidades de juicio a través de simulaciones y ejercicios guiados.'
                ],
                'Deficiente' => [
                    'interpretation' => 'Incapacidad para manejar situaciones con sentido común, lo que puede afectar relaciones y decisiones.',
                    'recommendation' => 'Requiere intervención inmediata con coaching intensivo y seguimiento cercano.'
                ],
            ],
        ];


        // 2. OBTENER ACIERTOS DEL USUARIO
        // Necesitamos unir con 'questions' para saber el número de pregunta ('order')
        $userAnswers = EvaluationUserAnswer::where('psychometric_evaluation_id', $evaluation->id)
            ->join('answers', 'evaluation_user_answers.answer_id', '=', 'answers.id')
            ->join('questions', 'answers.question_id', '=', 'questions.id')
            ->where('answers.weight', '>', 0) // Solo traemos las correctas (Aciertos)
            ->select('questions.order', 'answers.weight')
            ->get();

        $totalRawScore = 0;

        // 3. PROCESAMIENTO
        foreach ($userAnswers as $ans) {
            $qNum = $ans->order; // Número de pregunta (1 al 30)

            // Verificamos a qué dimensión pertenece
            if (isset($map[$qNum])) {
                $dimId = $map[$qNum];
                $dimensions[$dimId]['score'] += $ans->weight; // Sumamos 1 punto
            }
            $totalRawScore += $ans->weight;
        }

        // 4. PREPARAR RESULTADOS POR DIMENSIÓN (Porcentaje de efectividad)
        $dimensionScores = [];
        foreach ($dimensions as $key => $data) {
            // Calculamos porcentaje: (Aciertos / Total Preguntas de esa área) * 100
            $percentage = ($data['score'] > 0)
                ? round(($data['score'] / $data['total_questions']) * 100)
                : 0;

            // Determinación del rango basado en el porcentaje de la dimensión
            $dimensionRange = '';
            $dimensionPercentile = 0;

            if ($percentage <= 20) {
                $dimensionPercentile = 5;
                $dimensionRange = 'Deficiente';
            } elseif ($percentage <= 40) {
                $dimensionPercentile = 10;
                $dimensionRange = 'Inferior';
            } elseif ($percentage <= 50) {
                $dimensionPercentile = 20;
                $dimensionRange = 'Inferior al Término Medio';
            } elseif ($percentage <= 60) {
                $dimensionPercentile = 30;
                $dimensionRange = 'Término Medio';
            } elseif ($percentage <= 75) {
                $dimensionPercentile = 40;
                $dimensionRange = 'Superior al Término Medio';
            } elseif ($percentage <= 90) {
                $dimensionPercentile = 50;
                $dimensionRange = 'Superior';
            } else {
                $dimensionPercentile = 60;
                $dimensionRange = 'Excelente';
            }

            $dimensionScores[$data['name']] = [
                'completeName' => $data['completeName'],
                'description' => $data['description'],
                'percentage' => $percentage,
                'range' => $dimensionRange,
                'interpretation' => $feedbackMatrix[$data['name']][$dimensionRange]['interpretation'],
                'recommendation' => $feedbackMatrix[$data['name']][$dimensionRange]['recommendation'],
                'percentile' => $dimensionPercentile,
                'raw_score' => $data['score']
            ];
        }

        // 5. RANGO GLOBAL (Percentil General)
        // Tabla de baremos estándar (Ajustar si tu imagen tiene otros rangos)
        $percentile = 0;
        $range = '';

        if ($totalRawScore <= 24) { $percentile = 5;  $range = 'Deficiente'; }
        elseif ($totalRawScore <= 39) { $percentile = 10; $range = 'Inferior'; }
        elseif ($totalRawScore <= 49) { $percentile = 20; $range = 'Inferior al Término Medio'; }
        elseif ($totalRawScore <= 59) { $percentile = 30; $range = 'Término Medio'; }
        elseif ($totalRawScore <= 74) { $percentile = 40; $range = 'Superior al Término Medio'; }
        elseif ($totalRawScore <= 89) { $percentile = 50; $range = 'Superior'; }
        elseif ($totalRawScore <= 100) { $percentile = 60; $range = 'Excelente'; }


        return [
            'test_name' => 'Moss (Habilidades Gerenciales)',
            'chart_type' => 'bar', // Cambiamos a barras para ver las 5 dimensiones
            'raw_score' => $totalRawScore,
            'percentile' => $percentile,
            'range' => $range,
            'scores' => $dimensionScores, // Aquí va el array de las 5 dimensiones con sus %
            'summary' => "Rango Global: $range ($percentile%)"
        ];
    }

    private function calculateCleaver($evaluation)
    {
        $answers = EvaluationUserAnswer::where('psychometric_evaluation_id', $evaluation->id)
            ->join('answers', 'evaluation_user_answers.answer_id', '=', 'answers.id')
            ->select('answers.code')
            ->get();

        $scores = ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0];

        foreach ($answers as $ans) {
            $code = strtoupper(substr($ans->code, 0, 1));
            if (isset($scores[$code])) {
                $scores[$code]++;
            }
        }

        return [
            'test_name' => 'Cleaver (DISC)',
            'chart_type' => 'bar',
            'scores' => $scores,
            'summary' => "D:{$scores['D']} I:{$scores['I']} S:{$scores['S']} C:{$scores['C']}"
        ];
    }
}
