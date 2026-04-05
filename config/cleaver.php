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
    ]
];
