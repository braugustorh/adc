<?php
/*
    |--------------------------------------------------------------------------
    | Plantilla de Calificación Cleaver (DISC)
    |--------------------------------------------------------------------------
    |
    | Este diccionario mapea las 96 palabras de la prueba Cleaver a su
    | respectivo dominio (D, I, S, C) dependiendo de si el usuario
    | la seleccionó como MÁS (MOST) o MENOS (LEAST).
    |
    */
return [
    'plantilla' => [
        'Persuasivo'         => ['MOST' => 'I',    'LEAST' => null],
        'Gentil'             => ['MOST' => 'S',    'LEAST' => 'S'],
        'Humilde'            => ['MOST' => 'C',   'LEAST' => 'C'],
        'Original'           => ['MOST' => null,    'LEAST' => 'D'],
        'Agresivo'           => ['MOST' => 'D',    'LEAST' => null],
        'Alma de la fiesta'  => ['MOST' => 'I',    'LEAST' => 'I'],
        'Comodino'           => ['MOST' => 'S',    'LEAST' => 'S'],
        'Temeroso'           => ['MOST' => null,   'LEAST' => 'C'],
        'Agradable'          => ['MOST' => null,   'LEAST' => 'S'],
        'Temeroso de Dios'   => ['MOST' => 'C',   'LEAST' => 'C'],
        'Tenaz'              => ['MOST' => 'D',    'LEAST' => 'D'],
        'Atractivo'          => ['MOST' => 'I',    'LEAST' => 'I'],
        'Cauteloso'          => ['MOST' => 'C',   'LEAST' => 'C'],
        'Determinado'        => ['MOST' => 'D',    'LEAST' => null],
        'Convincente'        => ['MOST' => 'I',    'LEAST' => 'I'],
        'Bonachón'           => ['MOST' => 'S',    'LEAST' => null],
        'Dócil'              => ['MOST' => null,   'LEAST' => 'C'],
        'Atrevido'           => ['MOST' => 'D',    'LEAST' => 'D'],
        'Leal'               => ['MOST' => 'S',    'LEAST' => null],
        'Encantador'         => ['MOST' => 'I',    'LEAST' => 'I'],
        'Dispuesto'          => ['MOST' => 'S',    'LEAST' => null],
        'Deseoso'            => ['MOST' => null,   'LEAST' => null],
        'Consecuente'        => ['MOST' => 'C',   'LEAST' => 'C'],
        'Entusiasta'         => ['MOST' => null,   'LEAST' => 'D'],
        'Fuerza de voluntad' => ['MOST' => null,    'LEAST' => 'D'],
        'Mente abierta'      => ['MOST' => 'C',   'LEAST' => null],
        'Complaciente'       => ['MOST' => 'S',    'LEAST' => 'S'],
        'Animoso'            => ['MOST' => 'I',    'LEAST' => 'I'],
        'Confiado'           => ['MOST' => 'I',    'LEAST' => null],
        'Simpatizador'       => ['MOST' => null,   'LEAST' => 'S'],
        'Tolerante'          => ['MOST' => null,   'LEAST' => 'C'],
        'Afirmativo'         => ['MOST' => 'D',    'LEAST' => 'D'],
        // --- Continuación Columna 2 ---
        'Ecuánime'               => ['MOST' => 'S',    'LEAST' => 'S'],
        'Preciso'                => ['MOST' => 'C',   'LEAST' => 'C'],
        'Nervioso'               => ['MOST' => null,   'LEAST' => 'D'],
        'Jovial'                 => ['MOST' => null,    'LEAST' => 'I'],
        'Disciplinado'           => ['MOST' => 'C',    'LEAST' => null],
        'Generoso'               => ['MOST' => 'S',    'LEAST' => 'S'],
        'Animoso'               => ['MOST' => null,    'LEAST' => 'I'], // Aparece por segunda vez
        'Persistente'            => ['MOST' => 'D',    'LEAST' => 'D'],
        'Competitivo'            => ['MOST' => 'D',    'LEAST' => 'D'],
        'Alegre'                 => ['MOST' => null,    'LEAST' => 'I'],
        'Considerado'            => ['MOST' => 'S',    'LEAST' => 'S'],
        'Armonioso'              => ['MOST' => null,   'LEAST' => 'C'],
        'Admirable'              => ['MOST' => 'I',   'LEAST' => null],
        'Bondadoso'              => ['MOST' => 'S',    'LEAST' => null],
        'Resignado'              => ['MOST' => null,   'LEAST' => 'C'],
        'Carácter Firme'         => ['MOST' => 'D',    'LEAST' => 'D'],

        // --- Columna 3 ---
        'Obediente'              => ['MOST' => 'S',    'LEAST' => null],
        'Quisquilloso'           => ['MOST' => null,   'LEAST' => 'C'],
        'Inconquistable'         => ['MOST' => 'D',    'LEAST' => 'D'],
        'Juguetón'               => ['MOST' => 'I',   'LEAST' => 'I'],
        'Respetuoso'             => ['MOST' => 'C',    'LEAST' => null],
        'Emprendedor'            => ['MOST' => 'D',    'LEAST' => 'D'],
        'Optimista'              => ['MOST' => 'I',    'LEAST' => 'I'],
        'Servicial'              => ['MOST' => 'S',    'LEAST' => 'S'],
        'Valiente'               => ['MOST' => 'D',    'LEAST' => null],
        'Inspirador'             => ['MOST' => 'I',    'LEAST' => null],
        'Sumiso'                 => ['MOST' => null,   'LEAST' => 'S'],
        'Tímido'                 => ['MOST' => null,   'LEAST' => 'C'],
        'Adaptable'              => ['MOST' => 'C',    'LEAST' => null],
        'Disputador'             => ['MOST' => 'D',    'LEAST' => 'D'],
        'Indiferente'            => ['MOST' => null,   'LEAST' => 'S'],
        'Sangre liviana'         => ['MOST' => 'I',    'LEAST' => 'I'],
        'Amiguero'               => ['MOST' => 'I',    'LEAST' => 'I'],
        'Paciente'               => ['MOST' => 'S',    'LEAST' => 'S'],
        'Confianza en sí mismo'  => ['MOST' => 'D',    'LEAST' => 'D'],
        'Mesurado para hablar'   => ['MOST' => 'C',    'LEAST' => null],
        'Conforme'               => ['MOST' => null,   'LEAST' => 'S'],
        'Confiable'              => ['MOST' => 'S',    'LEAST' => 'I'],
        'Pacífico'               => ['MOST' => 'C',    'LEAST' => 'C'],
        'Positivo'               => ['MOST' => 'D',    'LEAST' => 'D'],

        // --- Columna 4 ---
        'Aventurero'             => ['MOST' => 'D',   'LEAST' => 'D'],
        'Receptivo'              => ['MOST' => 'C',   'LEAST' => null],
        'Cordial'                => ['MOST' => null,    'LEAST' => 'I'],
        'Moderado'               => ['MOST' => 'S',   'LEAST' => 'S'],
        'Indulgente'             => ['MOST' => 'S',   'LEAST' => 'S'],
        'Esteta'                 => ['MOST' => null,   'LEAST' => 'C'],
        'Vigoroso'               => ['MOST' => 'D',    'LEAST' => 'D'],
        'Sociable'               => ['MOST' => 'I',    'LEAST' => 'I'],
        'Parlanchín'             => ['MOST' => 'I',    'LEAST' => 'I'],
        'Controlado'             => ['MOST' => 'S',    'LEAST' => 'S'],
        'Convencional'           => ['MOST' => null,    'LEAST' => 'C'],
        'Decisivo'               => ['MOST' => 'D',    'LEAST' => 'D'],
        'Cohibido'               => ['MOST' => null,   'LEAST' => 'S'],
        'Exacto'                 => ['MOST' => 'C',    'LEAST' => null],
        'Franco'                 => ['MOST' => 'D',    'LEAST' => 'D'],
        'Buen compañero'         => ['MOST' => 'I',    'LEAST' => 'I'],
        'Diplomático'            => ['MOST' => 'C',    'LEAST' => null],
        'Audaz'                  => ['MOST' => 'D',    'LEAST' => 'D'],
        'Refinado'               => ['MOST' => null,    'LEAST' => 'I'],
        'Satisfecho'             => ['MOST' => 'S',   'LEAST' => 'S'],
        'Inquieto'               => ['MOST' => 'D',   'LEAST' => 'D'],
        'Popular'                => ['MOST' => 'I',    'LEAST' => 'I'],
        'Buen vecino'            => ['MOST' => 'S',    'LEAST' => 'S'],
        'Devoto'                 => ['MOST' => 'C',    'LEAST' => 'C'],

    ],
    //Conversión de los valores de la tabla de percentiles a los valores percentiles para cada dominio (D, I, S, C) y cada tipo de respuesta (M = MOST, L = LEAST, T = Total).
    'percentiles' => [
        'M' => [
            'D' => [0 => 1, 1 => 5, 2 => 10, 3 => 20, 4 => 30, 5 => 40, 6 => 50, 7 => 60, 8 => 65, 9 => 75, 10 => 84, 11 => 87, 12 => 90, 13 => 93, 14 => 95, 15 => 97, 16 => 97, 17 => 98, 18 => 98, 19 => 98, 20 => 99],
            'I' => [0 => 4, 1 => 10, 2 => 25, 3 => 40, 4 => 55, 5 => 70, 6 => 82, 7 => 90, 8 => 95, 9 => 96, 10 => 97, 11 => 97, 12 => 97, 13 => 97, 14 => 97, 15 => 97, 16 => 97, 17 => 99],
            'S' => [0 => 5, 1 => 10, 2 => 16, 3 => 30, 4 => 40, 5 => 55, 6 => 63, 7 => 75, 8 => 84, 9 => 90, 10 => 95, 11 => 96, 12 => 97, 13 => 97, 14 => 97, 15 => 97, 16 => 98, 17 => 98, 18 => 98, 19 => 99],
            'C' => [0 => 1, 1 => 5, 2 => 16, 3 => 30, 4 => 55, 5 => 70, 6 => 84, 7 => 93, 8 => 95, 9 => 97, 10 => 97, 11 => 97, 12 => 98, 13 => 98, 14 => 98, 15 => 99],
        ],
        'L' => [
            'D' => [0 => 99, 1 => 95, 2 => 87, 3 => 80, 4 => 65, 5 => 55, 6 => 50, 7 => 35, 8 => 30, 9 => 20, 10 => 18, 11 => 15, 12 => 10, 13 => 6, 14 => 5, 15 => 4, 16 => 3, 17 => 2, 18 => 2, 19 => 2, 20 => 2, 21 => 1],
            'I' => [0 => 99, 1 => 95, 2 => 87, 3 => 75, 4 => 55, 5 => 40, 6 => 25, 7 => 16, 8 => 10, 9 => 5, 10 => 4, 11 => 4, 12 => 3, 13 => 3, 14 => 3, 15 => 2, 16 => 2, 17 => 2, 18 => 2, 19 => 1],
            'S' => [0 => 99, 1 => 97, 2 => 95, 3 => 87, 4 => 80, 5 => 65, 6 => 55, 7 => 35, 8 => 28, 9 => 18, 10 => 10, 11 => 5, 12 => 4, 13 => 3, 14 => 3, 15 => 3, 16 => 2, 17 => 2, 18 => 2, 19 => 1],
            'C' => [0 => 99, 1 => 97, 2 => 95, 3 => 90, 4 => 84, 5 => 70, 6 => 55, 7 => 40, 8 => 38, 9 => 23, 10 => 10, 11 => 5, 12 => 4, 13 => 3, 14 => 2, 15 => 2, 16 => 1],
        ],
        'T' => [
            'D' => [-21 => 1, -20 => 2, -19 => 2, -18 => 2, -17 => 2, -16 => 2, -15 => 2, -14 => 2, -13 => 4, -12 => 5, -11 => 5, -10 => 9, -9 => 13, -8 => 15, -7 => 16, -6 => 20, -5 => 25, -4 => 29, -3 => 35, -2 => 40, -1 => 45, 0 => 50, 1 => 55, 2 => 60, 3 => 65, 4 => 67, 5 => 70, 6 => 75, 7 => 80, 8 => 84, 9 => 85, 10 => 90, 11 => 91, 12 => 94, 13 => 95, 14 => 96, 15 => 97, 16 => 97, 17 => 98, 18 => 98, 19 => 98, 20 => 99],
            'I' => [-19 => 1, -18 => 2, -17 => 2, -16 => 2, -15 => 2, -14 => 2, -13 => 2, -12 => 2, -11 => 2, -10 => 3, -9 => 4, -8 => 5, -7 => 6, -6 => 10, -5 => 16, -4 => 20, -3 => 29, -2 => 35, -1 => 45, 0 => 55, 1 => 60, 2 => 70, 3 => 75, 4 => 85, 5 => 90, 6 => 95, 7 => 96, 8 => 97, 9 => 97, 10 => 98, 11 => 98, 12 => 98, 13 => 98, 14 => 98, 15 => 98, 16 => 98, 17 => 99],
            'S' => [-19 => 1, -18 => 2, -17 => 2, -16 => 2, -15 => 2, -14 => 2, -13 => 2, -12 => 3, -11 => 4, -10 => 5, -9 => 8, -8 => 10, -7 => 15, -6 => 20, -5 => 25, -4 => 30, -3 => 35, -2 => 40, -1 => 50, 0 => 57, 1 => 60, 2 => 70, 3 => 75, 4 => 80, 5 => 84, 6 => 87, 7 => 91, 8 => 94, 9 => 96, 10 => 97, 11 => 97, 12 => 98, 13 => 98, 14 => 98, 15 => 98, 16 => 98, 17 => 98, 18 => 98, 19 => 99],
            'C' => [-16 => 1, -15 => 2, -14 => 2, -13 => 2, -12 => 2, -11 => 3, -10 => 4, -9 => 6, -8 => 9, -7 => 13, -6 => 20, -5 => 25, -4 => 35, -3 => 40, -2 => 55, -1 => 60, 0 => 70, 1 => 75, 2 => 84, 3 => 90, 4 => 95, 5 => 96, 6 => 97, 7 => 97, 8 => 98, 9 => 98, 10 => 98, 11 => 98, 12 => 98, 13 => 98, 14 => 98, 15 => 99],
        ],
    ],

    'interpretations' => [
        'D' => [
            'name' => 'Dominancia o Empuje',
            'description' => 'Capacidad de liderazgo, de lograr resultados y aceptar retos.',
            'high' => [ // > 50% (D+)
                'title' => 'Alto (D+)',
                'traits' => 'Orientado a resultados, toma decisiones rápidas, asume riesgos, competitivo, directo.',
                'behavior' => 'Persona enfocada en resolver problemas y superar obstáculos. Prefiere tomar el control y actuar con autoridad. Excelente para arrancar proyectos o manejar crisis.'
            ],
            'low' => [ // <= 50% (D-)
                'title' => 'Bajo (D-)',
                'traits' => 'Pacífico, conservador, analítico ante riesgos, evita conflictos, modesto.',
                'behavior' => 'Prefiere un entorno predecible. Investiga y recopila datos antes de actuar. Evita la confrontación directa y busca el consenso antes que la imposición.'
            ]
        ],
        'I' => [
            'name' => 'Influencia o Relación',
            'description' => 'Habilidad para relacionarse con la gente y motivarla.',
            'high' => [ // > 50% (I+)
                'title' => 'Alto (I+)',
                'traits' => 'Sociable, persuasivo, entusiasta, optimista, comunicativo.',
                'behavior' => 'Logra resultados a través de la persuasión y la motivación de otros. Destaca en relaciones públicas, ventas y negociaciones. Confía en su instinto social.'
            ],
            'low' => [ // <= 50% (I-)
                'title' => 'Bajo (I-)',
                'traits' => 'Lógico, reservado, calculador, prefiere datos a emociones.',
                'behavior' => 'Se enfoca en los hechos y la lógica por encima de los sentimientos. Es más distante en sus relaciones laborales. Prefiere trabajar solo o con equipos muy técnicos.'
            ]
        ],
        'S' => [
            'name' => 'Constancia o Permanencia',
            'description' => 'Capacidad para realizar trabajos de manera continua y rutinaria.',
            'high' => [ // > 50% (S+)
                'title' => 'Alto (S+)',
                'traits' => 'Paciente, predecible, buen oyente, consistente, enfocado en rutinas.',
                'behavior' => 'Muestra gran resistencia para tareas de largo plazo o repetitivas. Excelente jugador de equipo que busca estabilidad, lealtad y armonía a largo plazo.'
            ],
            'low' => [ // <= 50% (S-)
                'title' => 'Bajo (S-)',
                'traits' => 'Flexible, impaciente, adaptable, prefiere la variedad.',
                'behavior' => 'Bajo nivel de tolerancia a la rutina. Busca variedad, movilidad y cambio constante. Reacciona rápido ante emergencias pero se aburre en tareas mecánicas.'
            ]
        ],
        'C' => [
            'name' => 'Apego o Cumplimiento',
            'description' => 'Habilidad para desarrollar trabajos respetando normas y procedimientos.',
            'high' => [ // > 50% (C+)
                'title' => 'Alto (C+)',
                'traits' => 'Preciso, perfeccionista, apegado a reglas, analítico, detallista.',
                'behavior' => 'Exige alta calidad y perfección. Sigue manuales y procedimientos al pie de la letra para evitar riesgos y errores. Trabaja mejor en entornos altamente estructurados.'
            ],
            'low' => [ // <= 50% (C-)
                'title' => 'Bajo (C-)',
                'traits' => 'Independiente, firme, no convencional, delega detalles.',
                'behavior' => 'No le gusta ser micro-gestionado. Prefiere operar con independencia y autonomía. Ve las reglas como guías flexibles más que como leyes inquebrantables.'
            ]
        ],
        'situational' => [
            'D' => [
                'M' => [
                    'high' => 'Se siente fuertemente motivado por el poder, la autoridad y los retos. Busca proyectar una imagen de líder enfocado en ganar y superar obstáculos.',
                    'low'  => 'Su motivación principal es la paz y la armonía. Proyecta un perfil pacífico, buscando entornos donde no tenga que imponerse ni confrontar a otros.'
                ],
                'L' => [
                    'high' => 'Bajo fuerte estrés o crisis, tiende a volverse autoritario, exigente y directo hasta la rudeza, tomando el control de forma agresiva.',
                    'low'  => 'Ante problemas graves o confrontaciones directas, tiende a ceder el control, evitar decisiones impopulares y huir del conflicto.'
                ]
            ],
            'I' => [
                'M' => [
                    'high' => 'Su mayor motivación es el reconocimiento público, la popularidad y el contacto social. Busca proyectar una imagen persuasiva y carismática.',
                    'low'  => 'Se motiva en entornos lógicos y de trabajo individual. Proyecta un perfil que prefiere enfocarse en los datos y tareas antes que en agradar a los demás.'
                ],
                'L' => [
                    'high' => 'Bajo estrés, tiende a hablar de más, prometer cosas difíciles de cumplir o volverse excesivamente emocional para evadir la presión.',
                    'low'  => 'En situaciones de crisis se vuelve distante, frío y calculador. Pierde su expresividad y prefiere aislarse del contacto social para pensar.'
                ]
            ],
            'S' => [
                'M' => [
                    'high' => 'Le motiva la seguridad, la estabilidad a largo plazo y un ritmo predecible. Proyecta una imagen leal, buscando ambientes familiares y de apoyo mutuo.',
                    'low'  => 'Se siente motivado por la variedad, el dinamismo y los cambios rápidos. Anhela la movilidad y rechaza las rutinas estancadas.'
                ],
                'L' => [
                    'high' => 'Ante la presión se aferra al status quo, resiste obstinadamente los cambios repentinos y puede mostrarse terco o pasivo-agresivo.',
                    'low'  => 'Bajo estrés se vuelve errático e impaciente. Puede abandonar procedimientos, perder la concentración y saltar de una tarea a otra sin terminar.'
                ]
            ],
            'C' => [
                'M' => [
                    'high' => 'Se motiva en entornos altamente estructurados, con reglas precisas y cero margen de error. Proyecta una imagen de máxima exactitud y perfeccionismo.',
                    'low'  => 'Anhela la independencia y la libertad operativa. Su motivación es trabajar sin ataduras a manuales estrictos, delegando los detalles técnicos.'
                ],
                'L' => [
                    'high' => 'Bajo presión sufre de "parálisis por análisis". Se vuelve sumamente crítico, teme equivocarse y se escuda rígidamente en las reglas y el manual.',
                    'low'  => 'Ante emergencias o crisis operativa, ignora los procedimientos, toma atajos riesgosos y se vuelve muy descuidado con los detalles importantes.'
                ]
            ],
            'T' => [
                'general' => 'Esta puntuación refleja su comportamiento natural y diario en condiciones normales de trabajo.'
            ]
        ],

        // Alerta de Aplanamiento (Aplicable a T, M o L)
        'alerts' => [
            'flattened_profile' => 'Perfil Aplanado: Las puntuaciones se concentran entre el percentil 40 y 60. Esto puede indicar transición de puesto, confusión del candidato al responder, o neutralización de factores por alto estrés.'
        ]
    ],
    'glosario' => [
        1 => [
            ['frase' => 'Persuasivo', 'definicion' => 'capaz de llevar a otro a creer o hacer algo'],
            ['frase' => 'Gentil', 'definicion' => 'aquel que en su trato es amable'],
            ['frase' => 'Humilde', 'definicion' => 'que demuestra sencillez y docilidad'],
            ['frase' => 'Original', 'definicion' => 'especial, único, distinto a los demás']
        ],
        2 => [
            ['frase' => 'Agresivo', 'definicion' => 'aquel que ataca u ofende a los demás'],
            ['frase' => 'Alma de las fiestas', 'definicion' => 'el que es alegre, entusiasta'],
            ['frase' => 'Comodino', 'definicion' => 'el que busca lo agradable con el menor esfuerzo'],
            ['frase' => 'Temeroso', 'definicion' => 'aquel que es miedoso, cobarde']
        ],
        3 => [
            ['frase' => 'Agradable', 'definicion' => 'aquel que es grato y atrayente'],
            ['frase' => 'Temeroso de Dios', 'definicion' => 'que tiene miedo al castigo divino'],
            ['frase' => 'Tenaz', 'definicion' => 'aquel que es constante para alcanzar sus objetivos'],
            ['frase' => 'Atractivo', 'definicion' => 'aquel que con sus cualidades capta la atención']
        ],
        4 => [
            ['frase' => 'Cauteloso', 'definicion' => 'precavido, que actúa previendo posibles dificultades'],
            ['frase' => 'Determinado', 'definicion' => 'resuelto y decidido'],
            ['frase' => 'Convincente', 'definicion' => 'que consigue que una idea o hecho se acepten como verdad'],
            ['frase' => 'Bonachón', 'definicion' => 'aquel que es accesible, cordial y/o crédulo']
        ],
        5 => [
            ['frase' => 'Dócil', 'definicion' => 'aquel que fácilmente se amolda a los requerimientos'],
            ['frase' => 'Atrevido', 'definicion' => 'que actúa de manera arriesgada, con decisión y arrojo'],
            ['frase' => 'Leal', 'definicion' => 'que es fiel a personas o ideales'],
            ['frase' => 'Encantador', 'definicion' => 'que cautiva la atención, seductor']
        ],
        6 => [
            ['frase' => 'Dispuesto', 'definicion' => 'disponible, preparado y con ánimo favorable para participar'],
            ['frase' => 'Deseoso', 'definicion' => 'que anhela poseer, o realizar una cierta actividad'],
            ['frase' => 'Consecuente', 'definicion' => 'aquel con quien es fácil llegar a un acuerdo'],
            ['frase' => 'Entusiasta', 'definicion' => 'el que se siente motivado']
        ],
        7 => [
            ['frase' => 'Fuerza de voluntad', 'definicion' => 'con convencimiento interno y tenacidad para alcanzar un objetivo'],
            ['frase' => 'Mente abierta', 'definicion' => 'que es tolerante y acepta ideas nuevas y distintas a las suyas'],
            ['frase' => 'Complaciente', 'definicion' => 'el que busca ser agradable y dar satisfacción a otros'],
            ['frase' => 'Animoso', 'definicion' => 'que muestra energía, motivación y deseos para hacer algo']
        ],
        8 => [
            ['frase' => 'Confiado', 'definicion' => 'satisfecho de si mismo, crédulo, ingenuo'],
            ['frase' => 'Simpatizador', 'definicion' => 'el que trata de mantener relaciones agradables con los demás'],
            ['frase' => 'Tolerante', 'definicion' => 'que respeta y sobrelleva aquello que no le es familiar'],
            ['frase' => 'Afirmativo', 'definicion' => 'que sostiene sus ideas o actitudes con determinación']
        ],
        9 => [
            ['frase' => 'Ecuánime', 'definicion' => 'aquella persona que se muestra equilibrada y serena'],
            ['frase' => 'Preciso', 'definicion' => 'que es exacto y conciso'],
            ['frase' => 'Nervioso', 'definicion' => 'que es irritable, inquieto, impresionable'],
            ['frase' => 'Jovial', 'definicion' => 'alegre, festivo, divertido']
        ],
        10 => [
            ['frase' => 'Disciplinado', 'definicion' => 'que sigue un método de manera continua'],
            ['frase' => 'Generoso', 'definicion' => 'que da lo que tiene'],
            ['frase' => 'Animoso', 'definicion' => 'que muestra energía, motivación y deseos de hacer algo'],
            ['frase' => 'Persistente', 'definicion' => 'que es constante y tenaz en una actividad que se propone']
        ],
        11 => [
            ['frase' => 'Competitivo', 'definicion' => 'que tiene la disposición y características para rivalizar'],
            ['frase' => 'Alegre', 'definicion' => 'que se muestra contento y regocijado. Gozoso'],
            ['frase' => 'Considerado', 'definicion' => 'que es atento y toma en cuenta a los demás'],
            ['frase' => 'Armonioso', 'definicion' => 'que busca el acuerdo, la convivencia, lo equilibrado']
        ],
        12 => [
            ['frase' => 'Admirable', 'definicion' => 'notable, digno de respeto y aprecio'],
            ['frase' => 'Bondadoso', 'definicion' => 'que se inclina hacer el bien, amable'],
            ['frase' => 'Resignado', 'definicion' => 'que se conforma con la situación en la que vive'],
            ['frase' => 'Carácter firme', 'definicion' => 'que es comprometido con sus convicciones']
        ],
        13 => [
            ['frase' => 'Obediente', 'definicion' => 'que se apega a lo establecido'],
            ['frase' => 'Quisquilloso', 'definicion' => 'que toma en cuenta hasta el más mínimo detalle, susceptible'],
            ['frase' => 'Inconquistable', 'definicion' => 'alguien de quien es muy difícil obtener el aprecio o aceptación'],
            ['frase' => 'Juguetón', 'definicion' => 'travieso, inquieto']
        ],
        14 => [
            ['frase' => 'Respetuoso', 'definicion' => 'que toma en cuenta y acata la reglas'],
            ['frase' => 'Emprendedor', 'definicion' => 'que propone e inicia proyectos'],
            ['frase' => 'Optimista', 'definicion' => 'que ve las cosas de manera favorable'],
            ['frase' => 'Servicial', 'definicion' => 'dispuesto a complacer y ayudar']
        ],
        15 => [
            ['frase' => 'Valiente', 'definicion' => 'que enfrenta el peligro'],
            ['frase' => 'Inspirador', 'definicion' => 'que hace surgir ideas creativas'],
            ['frase' => 'Sumiso', 'definicion' => 'que es manejable, dócil, obediente'],
            ['frase' => 'Tímido', 'definicion' => 'que se muestra poco abierto con las personas']
        ],
        16 => [
            ['frase' => 'Adaptable', 'definicion' => 'que se acomoda o ajusta a circunstancias y condiciones'],
            ['frase' => 'Disputador', 'definicion' => 'el que discute sus razonamientos para demostrar algo'],
            ['frase' => 'Indiferente', 'definicion' => 'el que no tenga preferencia o interés por algo'],
            ['frase' => 'Sangre liviana', 'definicion' => 'que en su manera de ser es agradable y atractivo, con carisma']
        ],
        17 => [
            ['frase' => 'Amiguero', 'definicion' => 'que gusta de establecer relaciones afectuosas'],
            ['frase' => 'Paciente', 'definicion' => 'que tiene la capacidad para esperar con tranquilidad'],
            ['frase' => 'Confianza en si mismo', 'definicion' => 'que se siente seguro y satisfecho con su manera de ser y actuar.'],
            ['frase' => 'Mesurado por hablar', 'definicion' => 'que evita los excesos al expresarse verbalmente']
        ],
        18 => [
            ['frase' => 'Conforme', 'definicion' => 'que se resigna a las circunstancias'],
            ['frase' => 'Confiable', 'definicion' => 'que inspira un sentimiento de seguridad'],
            ['frase' => 'Pacifico', 'definicion' => 'tranquilo, que está en paz, que evita peleas'],
            ['frase' => 'Positivo', 'definicion' => 'que muestra lo que es cierto, real autentico.']
        ],
        19 => [
            ['frase' => 'Aventurero', 'definicion' => 'que gusta de tener experiencias novedosas y arriesgadas'],
            ['frase' => 'Receptivo', 'definicion' => 'que percibe fácilmente sentimientos, ideas y hechos'],
            ['frase' => 'Cordial', 'definicion' => 'que es respetuoso y amable con su trato'],
            ['frase' => 'Moderado', 'definicion' => 'el que en su conducta se mantiene alejado de los extremos']
        ],
        20 => [
            ['frase' => 'Indulgente', 'definicion' => 'que es tolerante respecto a errores, que perdona fácilmente'],
            ['frase' => 'Esteta', 'definicion' => 'el que gusta de lo bello'],
            ['frase' => 'Vigoroso', 'definicion' => 'que tiene energía, fuerza y vitalidad'],
            ['frase' => 'Sociable', 'definicion' => 'que busca la convivencia con sus semejantes']
        ],
        21 => [
            ['frase' => 'Parlanchín', 'definicion' => 'que habla mucho'],
            ['frase' => 'Controlado', 'definicion' => 'que se domina y frena a si mismo'],
            ['frase' => 'Convencional', 'definicion' => 'apegado a las costumbres, evita cambios e innovaciones'],
            ['frase' => 'Decisivo', 'definicion' => 'que es tajante, terminante y definitivo']
        ],
        22 => [
            ['frase' => 'Cohibido', 'definicion' => 'que se siente restringido, intimidado para actuar, avergonzado'],
            ['frase' => 'Exacto', 'definicion' => 'el que cuida los más pequeños detalles, conciso'],
            ['frase' => 'Franco', 'definicion' => 'el que dice lo que piensa abiertamente, comunicativo'],
            ['frase' => 'Buen compañero', 'definicion' => 'atento, cortés, respetuoso, cooperativo']
        ],
        23 => [
            ['frase' => 'Diplomático', 'definicion' => 'que tiene tacto y delicadeza en su trato'],
            ['frase' => 'Audaz', 'definicion' => 'que se atreve a correr riesgos'],
            ['frase' => 'Refinado', 'definicion' => 'distinguido, muy fino y delicado'],
            ['frase' => 'Satisfecho', 'definicion' => 'que se siente complacido con lo que ha logrado']
        ],
        24 => [
            ['frase' => 'Inquieto', 'definicion' => 'que está en constante actividad'],
            ['frase' => 'Popular', 'definicion' => 'que es aceptado y querido en un grupo'],
            ['frase' => 'Buen vecino', 'definicion' => 'respetuoso, amable, considerado'],
            ['frase' => 'Devoto', 'definicion' => 'que vive de acuerdo a costumbres e ideas religiosas']
        ]
    ]
];
