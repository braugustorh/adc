<?php

namespace App\Services;

use DeepSeek\DeepSeekClient;
use Illuminate\Support\Facades\Log;

class DeepSeekService
{
    protected DeepSeekClient $deepseek;

    public function __construct(DeepSeekClient $deepseek)
    {
        $this->deepseek = $deepseek;
    }

    /**
     * Genera un dictamen psicométrico determinista basado en los resultados del candidato.
     *
     * @param array $candidateData  Datos del candidato (debe incluir 'puesto')
     * @param array $testResults    Resultados de las pruebas aplicadas
     * @return array                Reporte estructurado o array con clave '__ai_error'
     */
    public function generateReport(array $candidateData, array $testResults, array $competencias = [], float $ajusteGlobal = 0.0, string $dictamen = ''): array
    {
        $puesto = $candidateData['puesto'] ?? 'General';

        // Generar una semilla determinista a partir de los resultados + puesto.
        $deterministicSeed = abs(crc32(json_encode($testResults) . $puesto));

        // Pasamos el ajuste global al constructor del prompt
        $prompt = $this->buildUserPrompt($candidateData, $testResults, $puesto, $competencias, $ajusteGlobal,$dictamen);

        try {
            $queryBuilder = $this->deepseek
                ->query($this->getSystemPrompt(), 'system')
                ->query($prompt)
                ->withModel("deepseek-chat")   // Regresamos a deepseek-chat por compatibilidad SDK
                ->setTemperature(0.0);             // Greedy sampling: sin aleatoriedad

            // Inyectar parámetros de determinismo y formato JSON
            if (method_exists($queryBuilder, 'addParameter')) {
                $queryBuilder
                    ->addParameter('seed', $deterministicSeed)
                    ->addParameter('response_format', ['type' => 'json_object']);
                // top_p no es necesario con temperature=0, se omite.
            }
            file_put_contents(
                storage_path('logs/deepseek_payload_debug.json'),
                json_encode([
                    'candidateData' => $candidateData,
                    'testResults'   => $testResults,
                    'competencias'  => $competencias,
                    'prompt'        => $prompt,
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );
            $response = $queryBuilder->run();

            $decoded = json_decode($response, true);

            // Manejo de errores de la API (saldo insuficiente, rate limit, etc.)
            if (isset($decoded['error'])) {
                $errorMsg = $decoded['error']['message'] ?? 'Error desconocido de la API';
                $errorCode = $decoded['error']['code'] ?? $decoded['error']['type'] ?? '';
                Log::warning("DeepSeek API error [{$errorCode}]: {$errorMsg}");

                return [
                    '__ai_error' => true,
                    'message'    => $errorMsg,
                    'code'       => $errorCode,
                ];
            }

            $content = $decoded['choices'][0]['message']['content'] ?? null;

            if ($content) {
                // Eliminar posibles bloques de markdown (por si el modelo ignora response_format)
                $content = preg_replace('/^```json\s*(.*?)\s*```$/s', '$1', trim($content));

                $reportData = json_decode($content, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $reportData; // Éxito
                }

                Log::warning('DeepSeek: contenido no es JSON válido', [
                    'content' => substr($content, 0, 500),
                    'error'   => json_last_error_msg()
                ]);

                return [
                    '__ai_error' => true,
                    'message'    => 'DeepSeek devolvió una respuesta que no es JSON válido',
                    'code'       => 'invalid_json_content',
                ];
            }

            return $decoded ?? [];

        } catch (\Exception $e) {
            Log::error('Error al generar reporte psicológico: ' . $e->getMessage());

            return [
                '__ai_error' => true,
                'message'    => $e->getMessage(),
                'code'       => 'exception',
            ];
        }
    }

    /**
     * System prompt estático que contiene TODAS las reglas, teoría y formato de salida.
     * Al ser inmutable, el modelo lo procesa con alta consistencia.
     */
    /**
     * System prompt estático que contiene TODAS las reglas, teoría y formato de salida.
     * Al ser inmutable, el modelo lo procesa con alta consistencia.
     */
    protected function getSystemPrompt(): string
    {
        return <<<PROMPT
Eres un psicólogo organizacional experto basado estrictamente en el "Modelo de Assessment Psicométrico Estratificado SEDYCO v1.1".
Tu única función es generar un dictamen clínico en formato JSON estricto, basándote en los resultados provistos.

INFORMACIÓN DEL SISTEMA (HECHOS INMUTABLES):
1. El porcentaje de ajuste global calculado por el sistema es: {ajuste_global_calculado}%
2. El dictamen final asignado por el sistema es: "{dictamen_php}"
Tu trabajo NO es calcular el dictamen, sino REDACTAR la justificación clínica congruente con este resultado.

REGLAS GLOBALES, CALIBRACIÓN CULTURAL Y DE INDUSTRIA:
1. Contexto México: La alta distancia jerárquica puede suprimir la Dominancia (D) en Cleaver. La Constancia (S) y Cumplimiento (C) suelen ser altas por evitación de incertidumbre.
2. Contexto Operativo (Centrales de Autobuses): El talento evaluado opera en empresas de logística, mantenimiento, atención masiva en piso, taquillas y gerencias de terminal. Aterriza tu lenguaje, ejemplos y planes de desarrollo a esta realidad del sector logístico/servicios.
3. Tono Constructivo (Growth Mindset): Evita lenguaje punitivo o destructivo. Sustituye palabras como "deficiencia" o "incapacidad" por "área de oportunidad" o "potencial a desarrollar".
4. PRUEBAS OPCIONALES (MUY IMPORTANTE): Las pruebas Kostick, Moss y Moss Wess son opcionales para niveles Supervisores y Administrativos. Si en el JSON de entrada NO aparecen estas pruebas, ignóralas por completo. Basa tu análisis estrictamente en las pruebas provistas. NO menciones que "faltan pruebas".

FORMATO DE SALIDA OBLIGATORIO (sin markdown, solo JSON puro):
{
    "pasos_de_razonamiento": {
        "1_analisis_de_competencias_criticas": "Análisis de las áreas fuertes y de oportunidad en las competencias con mayor peso.",
        "2_justificacion_del_dictamen": "Explicación de por qué el perfil coincide con el dictamen de '{dictamen_php}'.",
        "3_identificacion_entorno_optimo": "Evaluación independiente: Análisis de en qué área, dinámica o tipo de rol el candidato sería excepcional."
    },
    "reporte": {
        "resultado_global": {
            "nivel_ajuste": "Alto | Medio | Bajo | Insuficiente"
        },
        "resumen_ejecutivo": "string (máx 120 palabras. IMPORTANTE: Céntrate principalmente en el estilo de trabajo natural y las fortalezas del candidato. OMITE mencionar explícitamente si es APTO o NO APTO, el sistema ya lo hace.)",
        "fortaleza_principal": "string (1 frase, ej: Alta capacidad de organización de turnos y apego a protocolos de seguridad)",
        "brecha_principal": "string (1 frase propositiva, ej: Requiere desarrollar mayor asertividad en la resolución de conflictos en piso)",
        "entorno_optimo_sugerido": "string (máx 50 palabras indicando en qué áreas de la central, corporativo o logística aportaría más valor, ej: 'Es ideal para roles de control de calidad o back-office administrativo donde predomine el orden sobre la atención al público...')",
        "plan_desarrollo": [
            {
                "prioridad": "critical|important|normal",
                "titulo": "string (ej: Comunicación Asertiva — Nivel Latente)",
                "descripcion": "string (Acción recomendada táctica y aplicable, max 2 oraciones)",
                "periodo": "0 - 30 días | 30 - 60 días | 60 - 90 días"
            }
        ],
        "notas_adicionales": "string (solo si hay alertas operativas importantes)"
    }
}
PROMPT;
    }

    protected function buildUserPrompt(array $candidateData, array $testResults, string $puesto, array $competencias = [], float $ajusteGlobal = 0.0, string $dictamen = ''): string
    {
        $jsonEntrada = [
            'candidato' => [
                'nombres' => $candidateData['name'] ?? '',
                'puesto' => $puesto,
                'fecha_evaluacion' => date('Y-m-d'),
                // >>> INYECCIÓN CLAVE: El modelo usará esto como verdad absoluta <<<
                'ajuste_global_calculado' => $ajusteGlobal,
                'dictamen_asignado'=>$dictamen,
            ],
            'pruebas' => $testResults,
            'competencias_precalculadas' => $competencias
        ];

        $reglasSedyco = $this->getSedycoProfile($puesto);

        $payload = json_encode([
            'input_candidato'       => $jsonEntrada,
            'target_perfil_sedyco'  => $reglasSedyco
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return "Realiza el reporte clínico basado en la siguiente información. IMPORTANTE: El sistema ya ha determinado que el ajuste es {$ajusteGlobal}% y el dictamen es '{$dictamen}'. Tu único trabajo es REDACTAR la justificación clínica y el plan de desarrollo congruentes con este dictamen:\n\n" . $payload;


    }

    /**
     * Mapea las directrices del manual SEDYCO v1.1 a arrays estructurados según el nivel jerárquico.
     */
    /**
     * Mapea las directrices del manual SEDYCO v1.1 a arrays estructurados según el nivel jerárquico.
     * CALIBRADO PARA SECTOR LOGÍSTICO / CENTRALES DE AUTOBUSES
     */
    private function getSedycoProfile(string $nivel): array
    {
        // Normalizamos espacios y guiones bajos para asegurar el match
        $nivelNormalizado = str_replace(' ', '_', strtoupper(trim($nivel)));

        return match ($nivelNormalizado) {
            'DIRECTIVO' => [
                'perfil' => 'Directivo',
                'Terman' => 'CI 105-125 (Fuerte en Juicio, Planeación y Negociación)',
                'Cleaver' => ['D' => '65-80%', 'I' => '60-75%', 'S' => '30-45%', 'C' => '50-65%'],
                'Kostick' => ['G' => '5-7', 'L' => '6-8', 'A' => '6-8', 'P' => '5-7 (Control equilibrado)', 'T' => '5-7 (Manejo de crisis)'],
                'Moss' => ['Supervision' => '70-85%', 'Decision' => '75-90%', 'Evaluacion' => '70-85%', 'Relaciones' => '70-85%', 'Sentido_Comun' => '75-90%']
            ],
            'MANDO_MEDIO' => [
                'perfil' => 'Mando Medio',
                'Terman' => 'CI 95-115 (Fuerte en Organización y Análisis operativo)',
                'Cleaver' => ['D' => '55-70%', 'I' => '50-65%', 'S' => '45-60%', 'C' => '60-75%'],
                'Kostick' => ['G' => '5-7', 'L' => '5-7', 'N' => '6-8', 'A' => '5-7', 'S' => '5-7', 'C' => '5-7'],
                'Moss' => ['Supervision' => '65-80%', 'Decision' => '60-75%', 'Evaluacion' => '65-80%', 'Relaciones' => '65-80%', 'Sentido_Comun' => '70-85%']
            ],
            'SUPERVISOR' => [
                'perfil' => 'Supervisor',
                'Terman' => 'CI 90-105 (Funcional, pragmático)',
                'Cleaver' => ['D' => '50-65% (Firmeza)', 'I' => '45-60%', 'S' => '60-75%', 'C' => '70-85% (Apego a seguridad)'],
                'Kostick' => 'Opcional (Si aplica: Liderazgo firme y Necesidad de completar tareas altas)',
                'Moss' => 'Opcional (Si aplica: Habilidad de supervisión directa)'
            ],
            'ADMINISTRATIVO' => [
                'perfil' => 'Administrativo',
                'Terman' => 'CI 85-105 (Fuerte en Atención y Concentración para tareas repetitivas)',
                'Cleaver' => ['D' => '20-35% (Baja agresividad)', 'I' => '30-45%', 'S' => '70-85% (Paciencia)', 'C' => '75-90% (Apego estricto a manuales y cortes)']
                // Nota: Kostick y Moss eliminados intencionalmente para evitar alucinaciones de la IA.
            ],
            default => [
                'nota' => 'No se encontró un perfil estratificado específico. Evaluar competencias operativas generales.'
            ]
        };
    }

    /**
     * Devuelve los valores ideales de Cleaver (DISC) como puntos medios.
     * CALIBRADO PARA SECTOR LOGÍSTICO / CENTRALES DE AUTOBUSES
     */
    public function getIdealCleaverForChart(string $nivel): array
    {
        $nivel = strtoupper(trim($nivel));

        $ideales = [
            // D alto para manejar crisis, I alto para negociar con líneas de buses.
            'DIRECTIVO'      => ['D' => 75, 'I' => 65, 'S' => 38, 'C' => 58],

            // Equilibrio: Resuelven problemas (D) pero mantienen el orden operativo (C).
            'MANDO MEDIO'    => ['D' => 63, 'I' => 58, 'S' => 53, 'C' => 68],

            // Subimos la D a 58. Necesitan autoridad en piso para controlar personal de limpieza/mantenimiento.
            'SUPERVISOR'     => ['D' => 58, 'I' => 53, 'S' => 68, 'C' => 78],

            // Paciencia (S) y Apego a reglas (C) altísimos para cajas y servicio al cliente repetitivo.
            'ADMINISTRATIVO' => ['D' => 28, 'I' => 38, 'S' => 78, 'C' => 83],
        ];

        return $ideales[$nivel] ?? ['D' => 50, 'I' => 50, 'S' => 50, 'C' => 50];
    }
}
