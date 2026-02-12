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
     * LÓGICA DE MOSS WESS (Clima Social / Work Environment Scale)  COMPLETO SIN INTERPRETACIÓN
     * Estructura: Preguntas -> Subescalas (10) -> Dimensiones (3) -> Baremos
     */
    private function calculateMossWess($evaluation)
    {
        // =========================================================================
        // PASO 0: TEXTOS DESCRIPTIVOS (INFO DE TU SOLICITUD)
        // =========================================================================

        // A. Descripciones de Dimensiones
        // (Ajusté las llaves para que coincidan con $dimensionsMap de abajo)
        $dimensionesInfo = [
            'Relaciones' => 'Relaciones es una dimensión integrada por las subescalas implicación cohesión y apoyo, que evalúan el grado en los empleados están interesados y comprometidos en su trabajo y el grado en que la dirección apoya a los empleados y les anima a apoyarse unos a otros.',
            'Auto-realización' => 'La dimensión autorrealización u orientación hacia unos objetivos se aprecian por medio de sus escalas autonomía, organización y presión, que evalúan el grado en que se estimula a los empleados a ser autosuficientes y a tomar sus propias decisiones; de importancia que se da a la buena planificación, eficiencia y terminación de las tareas y el grado en que la presión en el trabajo o la urgencia dominan el ambiente laboral.',
            'Estabilidad/Cambio' => 'Estabilidad/ cambio es la dimensión apreciada por las subescuelas claridad, control innovación y comodidad. Estas subescalas evalúan el grado en que los empleados conocen lo que esperan de su tarea diaria y como se les explican las normas y planes de trabajo; el grado en que la dirección utiliza las normas y la presión para controlar a los empleados; la importancia que se da a la variedad, al cambio de las nuevas propuestas y, por ultimo, el grado entorno físico contribuye a crear un ambiente de trabajo agradable.'
        ];

        // B. Información de Subescalas (Nombre y Descripción)
        $subescalasInfo = [
            'IM' => ['nombre' => 'IMPLICACION', 'descripcion' => 'Grado en que los empleados se preocupan por su actividad y se entregan a ella.'],
            'CO' => ['nombre' => 'COHESION', 'descripcion' => 'Grado en que los empleados se ayudan entra si y se muestran amables con los compañeros.'],
            'AP' => ['nombre' => 'APOYO', 'descripcion' => 'Grado en que los jefes ayudan y animan al personal para crear un buen clima social.'],
            'AU' => ['nombre' => 'AUTONOMIA', 'descripcion' => 'Grado en que se anima a los empleados a ser autosuficientes y a tomar iniciativas propias.'],
            'OR' => ['nombre' => 'ORGANIZACIÓN', 'descripcion' => 'Grado en que se subraya una buena planificación, eficiencia y terminación de la tarea.'],
            'PR' => ['nombre' => 'PRESION', 'descripcion' => 'Grado en que la urgencia o la presión en el trabajo domina el ambiente laboral.'],
            'CL' => ['nombre' => 'CLARIDAD', 'descripcion' => 'Grado en que se conocen las expectativas de las tareas diarias y se explican las reglas y planes para el trabajo.'],
            'CN' => ['nombre' => 'CONTROL', 'descripcion' => 'Grado en que los jefes utilizan las reglas y las presiones para tener controlados a los empleados.'],
            'IN' => ['nombre' => 'INNOVACION', 'descripcion' => 'Grado en que se subraya la variedad, el cambio y los nuevos enfoques.'],
            'CF' => ['nombre' => 'COMODIDAD', 'descripcion' => 'Grado en que el ambiente físico contribuyo a crear un ambiente laboral agradable.']
        ];

        // =========================================================================
        // PASO 1: ARRAYS DE CONFIGURACIÓN TÉCNICA
        // =========================================================================

        // 1.1 CLAVE DE RESPUESTAS (CORRECTION KEY)
        $correctionKey = [
            // Subescala 1: Implicación (IM)
            1 => 'V', 11 => 'F', 21 => 'F', 31 => 'V', 41 => 'V', 51 => 'F', 61 => 'V', 71 => 'F', 81 => 'V',
            // Subescala 2: Cohesión (CO)
            2 => 'V', 12 => 'F', 22 => 'V', 32 => 'F', 42 => 'V', 52 => 'V', 62 => 'F', 72 => 'V', 82 => 'F',
            // Subescala 3: Apoyo (AP)
            3 => 'F', 13 => 'V', 23 => 'F', 33 => 'V', 43 => 'F', 53 => 'V', 63 => 'F', 73 => 'V', 83 => 'V',
            // Subescala 4: Autonomía (AU)
            4 => 'F', 14 => 'V', 24 => 'V', 34 => 'V', 44 => 'V', 54 => 'F', 64 => 'V', 74 => 'V', 84 => 'V',
            // Subescala 5: Organización (OR)
            5 => 'V', 15 => 'F', 25 => 'V', 35 => 'V', 45 => 'V', 55 => 'V', 65 => 'V', 75 => 'F', 85 => 'F',
            // Subescala 6: Presión (PR)
            6 => 'V', 16 => 'V', 26 => 'V', 36 => 'F', 46 => 'F', 56 => 'V', 66 => 'F', 76 => 'V', 86 => 'V',
            // Subescala 7: Claridad (CL)
            7 => 'F', 17 => 'V', 27 => 'F', 37 => 'V', 47 => 'F', 57 => 'F', 67 => 'V', 77 => 'F', 87 => 'V',
            // Subescala 8: Control (CN)
            8 => 'V', 18 => 'F', 28 => 'V', 38 => 'V', 48 => 'V', 58 => 'V', 68 => 'V', 78 => 'V', 88 => 'F',
            // Subescala 9: Innovación (IN)
            9 => 'V', 19 => 'V', 29 => 'V', 39 => 'F', 49 => 'F', 59 => 'F', 69 => 'F', 79 => 'V', 89 => 'V',
            // Subescala 10: Comodidad Física (CF)
            10 => 'F', 20 => 'V', 30 => 'F', 40 => 'V', 50 => 'F', 60 => 'V', 70 => 'F', 80 => 'V', 90 => 'V',
        ];

        // 1.2 MAPA DE SUBESCALAS (Preguntas)
        $subscalesMap = [
            'IM' => [1, 11, 21, 31, 41, 51, 61, 71, 81],
            'CO' => [2, 12, 22, 32, 42, 52, 62, 72, 82],
            'AP' => [3, 13, 23, 33, 43, 53, 63, 73, 83],
            'AU' => [4, 14, 24, 34, 44, 54, 64, 74, 84],
            'OR' => [5, 15, 25, 35, 45, 55, 65, 75, 85],
            'PR' => [6, 16, 26, 36, 46, 56, 66, 76, 86],
            'CL' => [7, 17, 27, 37, 47, 57, 67, 77, 87],
            'CN' => [8, 18, 28, 38, 48, 58, 68, 78, 88],
            'IN' => [9, 19, 29, 39, 49, 59, 69, 79, 89],
            'CF' => [10, 20, 30, 40, 50, 60, 70, 80, 90]
        ];

        // 1.3 MAPA DE DIMENSIONES
        $dimensionsMap = [
            'Relaciones' => ['IM', 'CO', 'AP'],
            'Auto-realización' => ['AU', 'OR', 'PR'],
            'Estabilidad/Cambio' => ['CL', 'CN', 'IN', 'CF']
        ];

        // 1.4 TABLA DE BAREMOS SUBESCALAS (Acierto Raw -> Valor Transformado + Categoría)
        $baremosSubescalas = [
            0 => ['IM' => 30, 'CO' => 18, 'AP' => 28, 'AU' => 29, 'OR' => 21, 'PR' => 13, 'CL' => 18, 'CN' => 13, 'IN' => 35, 'CF' => 20, 'CATEGORIA' => 'Deficitaria'],
            1 => ['IM' => 36, 'CO' => 26, 'AP' => 34, 'AU' => 36, 'OR' => 29, 'PR' => 23, 'CL' => 27, 'CN' => 21, 'IN' => 43, 'CF' => 27, 'CATEGORIA' => 'Deficitaria'],
            2 => ['IM' => 42, 'CO' => 34, 'AP' => 40, 'AU' => 43, 'OR' => 36, 'PR' => 32, 'CL' => 37, 'CN' => 30, 'IN' => 50, 'CF' => 34, 'CATEGORIA' => 'Deficitaria'],
            3 => ['IM' => 48, 'CO' => 41, 'AP' => 46, 'AU' => 50, 'OR' => 44, 'PR' => 41, 'CL' => 47, 'CN' => 38, 'IN' => 58, 'CF' => 41, 'CATEGORIA' => 'Deficitaria'],
            4 => ['IM' => 53, 'CO' => 49, 'AP' => 52, 'AU' => 57, 'OR' => 51, 'PR' => 51, 'CL' => 56, 'CN' => 46, 'IN' => 65, 'CF' => 48, 'CATEGORIA' => 'Mala'],
            5 => ['IM' => 59, 'CO' => 57, 'AP' => 58, 'AU' => 64, 'OR' => 59, 'PR' => 60, 'CL' => 66, 'CN' => 54, 'IN' => 73, 'CF' => 55, 'CATEGORIA' => 'Promedio'],
            6 => ['IM' => 65, 'CO' => 64, 'AP' => 64, 'AU' => 71, 'OR' => 66, 'PR' => 69, 'CL' => 76, 'CN' => 62, 'IN' => 80, 'CF' => 62, 'CATEGORIA' => 'Promedio'],
            7 => ['IM' => 71, 'CO' => 72, 'AP' => 70, 'AU' => 77, 'OR' => 73, 'PR' => 79, 'CL' => 85, 'CN' => 70, 'IN' => 88, 'CF' => 69, 'CATEGORIA' => 'Tiende a Buena'],
            8 => ['IM' => 76, 'CO' => 80, 'AP' => 76, 'AU' => 84, 'OR' => 81, 'PR' => 88, 'CL' => 95, 'CN' => 78, 'IN' => 96, 'CF' => 76, 'CATEGORIA' => 'Buena'],
            9 => ['IM' => 82, 'CO' => 87, 'AP' => 82, 'AU' => 91, 'OR' => 88, 'PR' => 97, 'CL' => null, 'CN' => 86, 'IN' => null, 'CF' => 83, 'CATEGORIA' => 'Excelente']
        ];

        // 1.5 BAREMOS DIMENSIONES (Acumulado)
        $baremosDimensions = [
            'Relaciones' => [
                ['max' => 5, 'label' => 'Excelente', 'color' => 'green'],
                ['max' => 10, 'label' => 'Buena', 'color' => 'green'],
                ['max' => 15, 'label' => 'Tiende a Buena', 'color' => 'blue'],
                ['max' => 20, 'label' => 'Promedio', 'color' => 'gray'],
                ['max' => 24, 'label' => 'Mala', 'color' => 'orange'],
                ['max' => 99, 'label' => 'Deficiente', 'color' => 'red'],
            ],
            'Auto-realización' => [
                ['max' => 4, 'label' => 'Excelente', 'color' => 'green'],
                ['max' => 9, 'label' => 'Buena', 'color' => 'green'],
                ['max' => 14, 'label' => 'Tiende a Buena', 'color' => 'blue'],
                ['max' => 18, 'label' => 'Promedio', 'color' => 'gray'],
                ['max' => 23, 'label' => 'Mala', 'color' => 'orange'],
                ['max' => 99, 'label' => 'Deficiente', 'color' => 'red'],
            ],
            'Estabilidad/Cambio' => [
                ['max' => 6, 'label' => 'Excelente', 'color' => 'green'],
                ['max' => 13, 'label' => 'Buena', 'color' => 'green'],
                ['max' => 15, 'label' => 'Tiende a Buena', 'color' => 'blue'],
                ['max' => 19, 'label' => 'Promedio', 'color' => 'gray'],
                ['max' => 24, 'label' => 'Mala', 'color' => 'orange'],
                ['max' => 99, 'label' => 'Deficiente', 'color' => 'red'],
            ],
        ];

        // =========================================================================
        // PASO 2: CÁLCULO DE PUNTOS
        // =========================================================================

        // 2.1 Obtener respuestas
        $userAnswers = EvaluationUserAnswer::where('psychometric_evaluation_id', $evaluation->id)
            ->join('answers', 'evaluation_user_answers.answer_id', '=', 'answers.id')
            ->join('questions', 'answers.question_id', '=', 'questions.id')
            ->select('questions.order', 'answers.text')
            ->get();

        // 2.2 Calcular RAW SCORE por Subescala
        $rawScores = array_fill_keys(array_keys($subscalesMap), 0);

        foreach ($userAnswers as $ans) {
            $qNum = $ans->order;
            if (isset($correctionKey[$qNum])) {
                $expected = $correctionKey[$qNum];
                $userVal = '';
                if (stripos($ans->text, 'V') !== false) $userVal = 'V';
                elseif (stripos($ans->text, 'F') !== false) $userVal = 'F';

                if ($userVal === $expected) {
                    foreach ($subscalesMap as $subKey => $qList) {
                        if (in_array($qNum, $qList)) {
                            $rawScores[$subKey]++;
                            break;
                        }
                    }
                }
            }
        }

        // =========================================================================
        // PASO 2.3: PROCESAR SUBESCALAS (AGREGAMOS NOMBRE Y DESCRIPCIÓN)
        // =========================================================================
        $detailedSubscales = [];

        foreach ($rawScores as $code => $score) {
            // Aseguramos que el score no pase de 9
            $safeScore = min($score, 9);
            $baremosData = $baremosSubescalas[$safeScore] ?? null;

            $category = 'N/A';
            $standardValue = 0;
            $color = 'gray';

            if ($baremosData) {
                $category = $baremosData['CATEGORIA'];
                $standardValue = $baremosData[$code] ?? 0;

                if (str_contains($category, 'Excelente') || str_contains($category, 'Buena')) $color = 'green';
                elseif (str_contains($category, 'Tiende a Buena')) $color = 'blue';
                elseif (str_contains($category, 'Promedio')) $color = 'gray';
                elseif (str_contains($category, 'Mala')) $color = 'orange';
                else $color = 'red';
            }

            // >>> AQUÍ INYECTAMOS TU DATA DE SUBESCALAS <<<
            $info = $subescalasInfo[$code] ?? ['nombre' => $code, 'descripcion' => ''];

            $detailedSubscales[$code] = [
                'name' => $info['nombre'],         // <-- Nombre completo (IMPLICACION)
                'description' => $info['descripcion'], // <-- Descripción
                'raw_score' => $score,
                'standard_score' => $standardValue,
                'category' => $category,
                'color' => $color
            ];
        }

        // =========================================================================
        // PASO 2.4: PROCESAR DIMENSIONES (AGREGAMOS DESCRIPCIÓN)
        // =========================================================================
        $dimensionResults = [];

        foreach ($dimensionsMap as $dimName => $subKeys) {
            $dimTotal = 0;
            foreach ($subKeys as $sub) {
                if (isset($rawScores[$sub])) {
                    $dimTotal += $rawScores[$sub];
                }
            }

            $categoryLabel = 'N/A';
            $categoryColor = 'gray';

            if (isset($baremosDimensions[$dimName])) {
                foreach ($baremosDimensions[$dimName] as $rango) {
                    if ($dimTotal <= $rango['max']) {
                        $categoryLabel = $rango['label'];
                        $categoryColor = $rango['color'];
                        break;
                    }
                }
            }

            // >>> AQUÍ INYECTAMOS TU DATA DE DIMENSIONES <<<
            $dimDesc = $dimensionesInfo[$dimName] ?? '';

            $dimensionResults[$dimName] = [
                'completeName' => $dimName, // Mantenemos compatibilidad con el blade
                'description' => $dimDesc,  // <-- Descripción rica
                'score' => $dimTotal,
                'category' => $categoryLabel,
                'color' => $categoryColor
            ];
        }

        // =========================================================================
        // PASO 3: RETORNO
        // =========================================================================

        return [
            'test_name' => 'Moss Wess (Clima Social)',
            'chart_type' => 'bar_grouped',
            'dimensions' => $dimensionResults,
            'subscales' => $detailedSubscales,
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

    //Interpretación de Moss COMPLETA y FUNCIONANDO
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
