<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TermanMerrilAnswersSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Estructura: [question_id, competence_id, text, is_correct, weight]
        // weight = 1 para respuestas correctas, 0 para incorrectas (null en tu data = 0)
        /* Arreglo para Local
        $answers = [
            // ════════════════════════════════════════════════
            // SERIE I — Competence 56 (Información)
            // ════════════════════════════════════════════════
            [621, 56, 'A) GRANO',        0, 0],
            [621, 56, 'B) PETRÓLEO',     1, 1],
            [621, 56, 'C) TREMENTINA',   0, 0],
            [621, 56, 'D) SEMILLAS',     0, 0],

            [622, 56, 'A) 1000 KILOGRAMOS',   1, 1],
            [622, 56, 'B) 2000 KILOGRAMOS',   0, 0],
            [622, 56, 'C) 3000 KILOGRAMOS',   0, 0],
            [622, 56, 'D) 4000 KILOGRAMOS',   0, 0],

            [623, 56, 'A) MAZATLÁN',   0, 0],
            [623, 56, 'B) VERACRUZ',   1, 1],
            [623, 56, 'C) PROGRESO',   0, 0],
            [623, 56, 'D) ACAPULCO',   0, 0],

            [624, 56, 'A) VER',     1, 1],
            [624, 56, 'B) OÍR',     0, 0],
            [624, 56, 'C) PROBAR',  0, 0],
            [624, 56, 'D) SENTIR',  0, 0],

            [625, 56, 'A) CORTEZA', 0, 0],
            [625, 56, 'B) FRUTO',   1, 1],
            [625, 56, 'C) HOJAS',   0, 0],
            [625, 56, 'D) RAÍZ',    0, 0],

            [626, 56, 'A) CARNERO',  0, 0],
            [626, 56, 'B) VACA',     0, 0],
            [626, 56, 'C) GALLINA',  0, 0],
            [626, 56, 'D) CERDO',    1, 1],

            [627, 56, 'A) ABDOMEN',   0, 0],
            [627, 56, 'B) CABEZA',    0, 0],
            [627, 56, 'C) GARGANTA',  1, 1],
            [627, 56, 'D) ESPALDA',   0, 0],

            [628, 56, 'A) MUERTE',      1, 1],
            [628, 56, 'B) ENFERMEDAD',  0, 0],
            [628, 56, 'C) FIEBRE',      0, 0],
            [628, 56, 'D) MALESTAR',    0, 0],

            [629, 56, 'A) PERFORAR', 0, 0],
            [629, 56, 'B) CORTAR',   0, 0],
            [629, 56, 'C) LEVANTAR', 1, 1],
            [629, 56, 'D) EXPRIMIR', 0, 0],

            [630, 56, 'A) PENTÁGONO',        0, 0],
            [630, 56, 'B) PARALELOGRAMO',    0, 0],
            [630, 56, 'C) HEXÁGONO',         1, 1],
            [630, 56, 'D) TRAPECIO',         0, 0],

            [631, 56, 'A) LLUVIA',       0, 0],
            [631, 56, 'B) VIENTO',       0, 0],
            [631, 56, 'C) ELECTRICIDAD', 1, 1],
            [631, 56, 'D) PRESIÓN',      0, 0],

            [632, 56, 'A) AGRICULTURA',  0, 0],
            [632, 56, 'B) MÚSICA',       1, 1],
            [632, 56, 'C) FOTOGRAFÍA',   0, 0],
            [632, 56, 'D) ESTENOGRAFÍA', 0, 0],

            [633, 56, 'A) AZULES',    0, 0],
            [633, 56, 'B) VERDES',    1, 1],
            [633, 56, 'C) ROJAS',     0, 0],
            [633, 56, 'D) AMARILLAS', 0, 0],

            [634, 56, 'A) PIE',     0, 0],
            [634, 56, 'B) PULGADA', 0, 0],
            [634, 56, 'C) YARDA',   1, 1],
            [634, 56, 'D) MILLA',   0, 0],

            [635, 56, 'A) ANIMALES', 1, 1],
            [635, 56, 'B) HIERBAS',  0, 0],
            [635, 56, 'C) BOSQUES',  0, 0],
            [635, 56, 'D) MINAS',    0, 0],

            [636, 56, 'A) MEDICINA',   0, 0],
            [636, 56, 'B) TEOLOGÍA',   0, 0],
            [636, 56, 'C) LEYES',      1, 1],
            [636, 56, 'D) PEDAGOGÍA',  0, 0],

            // ════════════════════════════════════════════════
            // SERIE II — Competence 57 (Juicio)
            // ════════════════════════════════════════════════
            [637, 57, 'A) LAS ESTRELLAS DESAPARECERÍAN.',         0, 0],
            [637, 57, 'B) LOS MESES SERÍAN MÁS LARGOS.',          0, 0],
            [637, 57, 'C) LA TIERRA ESTARÍA MÁS CALIENTE.',       1, 1],

            [638, 57, 'A) EL NOGAL ES FUERTE.',              1, 1],
            [638, 57, 'B) SE CORTA FÁCILMENTE.',             0, 0],
            [638, 57, 'C) SUS FRENOS NO SON BUENOS.',        0, 0],

            [639, 57, 'A) TIENE MÁS RUEDA.',         0, 0],
            [639, 57, 'B) ES MÁS PESADO.',            1, 1],
            [639, 57, 'C) SUS FRENOS NO SON BUENOS.', 0, 0],

            [640, 57, 'A) QUE LOS ROBLES SON DÉBILES.',                                    0, 0],
            [640, 57, 'B) QUE SON MEJORES LOS GOLPES PEQUEÑOS.',                           0, 0],
            [640, 57, 'C) QUE EL ESFUERZO CONSTANTE LOGRA RESULTADOS SORPRENDENTES.',      1, 1],

            [641, 57, 'A) QUE NO DEBEMOS VIGILARLA CUANDO ESTÉ EN EL FUEGO.',  0, 0],
            [641, 57, 'B) QUE TARDA EN HERVIR.',                                0, 0],
            [641, 57, 'C) QUE EL TIEMPO SE ALARGA CUANDO ESPERAMOS.',           1, 1],

            [642, 57, 'A) QUE EL PASTO SE SIEMBRA EN EL VERANO.',              0, 0],
            [642, 57, 'B) QUE DEBEMOS APROVECHAR NUESTRAS OPORTUNIDADES.',     1, 1],
            [642, 57, 'C) QUE EL PASTO NO DEBE CORTARSE EN LA NOCHE.',         0, 0],

            [643, 57, 'A) QUE UN ZAPATERO NO DEBE ABANDONAR SUS ZAPATOS.',         0, 0],
            [643, 57, 'B) QUE LOS ZAPATEROS NO DEBEN ESTAR OCIOSOS.',              0, 0],
            [643, 57, 'C) QUE DEBEMOS TRABAJAR EN LO QUE PODEMOS HACER MEJOR.',   1, 1],

            [644, 57, 'A) QUE EL PALO SIRVE PARA APRETAR.',                    0, 0],
            [644, 57, 'B) QUE LAS CUÑAS SIEMPRE SON DE MADERA.',               0, 0],
            [644, 57, 'C) NOS EXIGEN MÁS LAS PERSONAS QUE NOS CONOCEN.',       1, 1],

            [645, 57, 'A) LA MAQUINA LO HACE FLOTAR.',             0, 0],
            [645, 57, 'B) PORQUE TIENE GRANDES ESPACIOS HUECOS.',  1, 1],
            [645, 57, 'C) CONTIENE ALGO DE MADERA.',               0, 0],

            [646, 57, 'A) LAS ALAS OFRECEN UNA AMPLIA SUPERFICIE LIGERA.',  1, 1],
            [646, 57, 'B) MANTIENEN EL AIRE FUERA DEL CUERPO.',             0, 0],
            [646, 57, 'C) DISMINUYEN SU PESO.',                             0, 0],

            [647, 57, 'A) QUE LAS GOLONDRINAS REGRESAN.',                              0, 0],
            [647, 57, 'B) QUE UN SIMPLE DATO NO ES SUFICIENTE.',                       1, 1],
            [647, 57, 'C) QUE LOS PÁJAROS SE AGREGAN A NUESTROS PLACERES DE VERANO.', 0, 0],

            // ════════════════════════════════════════════════
            // SERIE III — Competence 58 (Vocabulario: I / O)
            // ════════════════════════════════════════════════
            [648, 58, 'I', 0, 0], [648, 58, 'O', 1, 1],   // SALADO – DULCE → Opuesto
            [649, 58, 'I', 1, 1], [649, 58, 'O', 0, 0],   // ALEGRE – REGOCIJARSE → Igual
            [650, 58, 'I', 0, 0], [650, 58, 'O', 1, 1],   // MAYOR – MENOR → Opuesto
            [651, 58, 'I', 0, 0], [651, 58, 'O', 1, 1],   // SENTARSE – PARARSE → Opuesto
            [652, 58, 'I', 0, 0], [652, 58, 'O', 1, 1],   // DESPERDICIAR – APROVECHAR → Opuesto
            [653, 58, 'I', 0, 0], [653, 58, 'O', 1, 1],   // CONOCER – NEGAR → Opuesto
            [654, 58, 'I', 1, 1], [654, 58, 'O', 0, 0],   // TÓNICO – ESTIMULAR → Igual
            [655, 58, 'I', 1, 1], [655, 58, 'O', 0, 0],   // REBAJAR – DENIGRAR → Igual
            [656, 58, 'I', 0, 0], [656, 58, 'O', 1, 1],   // PROHIBIR – PERMITIR → Opuesto
            [657, 58, 'I', 1, 1], [657, 58, 'O', 0, 0],   // OSADO – AUDAZ → Igual
            [658, 58, 'I', 0, 0], [658, 58, 'O', 1, 1],   // ARREBATADO – PRUDENTE → Opuesto
            [659, 58, 'I', 0, 0], [659, 58, 'O', 1, 1],   // OBTUSO – AGUDO → Opuesto
            [660, 58, 'I', 0, 0], [660, 58, 'O', 1, 1],   // INEPTO – EXPERTO → Opuesto
            [661, 58, 'I', 1, 1], [661, 58, 'O', 0, 0],   // ESQUIVAR – REHUIR → Igual
            [662, 58, 'I', 0, 0], [662, 58, 'O', 1, 1],   // REVELARSE – SOMETERSE → Opuesto
            [663, 58, 'I', 0, 0], [663, 58, 'O', 1, 1],   // MONOTONÍA – VARIEDAD → Opuesto
            [664, 58, 'I', 1, 1], [664, 58, 'O', 0, 0],   // CONFORTAR – CONSOLAR → Igual
            [665, 58, 'I', 0, 0], [665, 58, 'O', 1, 1],   // EXPELER – RETENER → Opuesto
            [666, 58, 'I', 1, 1], [666, 58, 'O', 0, 0],   // DÓCIL – SUMISO → Igual
            [667, 58, 'I', 0, 0], [667, 58, 'O', 1, 1],   // TRANSITORIO – PERMANENTE → Opuesto
            [668, 58, 'I', 0, 0], [668, 58, 'O', 1, 1],   // SEGURIDAD – RIESGO → Opuesto
            [669, 58, 'I', 0, 0], [669, 58, 'O', 1, 1],   // APROVECHAR – OBJETAR → Opuesto
            [670, 58, 'I', 1, 1], [670, 58, 'O', 0, 0],   // EXPELER – ARROJAR → Igual
            [671, 58, 'I', 1, 1], [671, 58, 'O', 0, 0],   // ENGAÑO – IMPOSTURA → Igual
            [672, 58, 'I', 1, 1], [672, 58, 'O', 0, 0],   // MITIGAR – APACIGUAR → Igual
            [673, 58, 'I', 0, 0], [673, 58, 'O', 1, 1],   // INICIATIVA – APLICAR → Opuesto
            [674, 58, 'I', 1, 1], [674, 58, 'O', 0, 0],   // REVERENCIA – VENERACIÓN → Igual
            [675, 58, 'I', 1, 1], [675, 58, 'O', 0, 0],   // SOBRIEDAD – FRUGALIDAD → Igual
            [676, 58, 'I', 0, 0], [676, 58, 'O', 1, 1],   // AUMENTAR – MENGUAR → Opuesto
            [677, 58, 'I', 1, 1], [677, 58, 'O', 0, 0],   // INCITAR – INSTIGAR → Igual

            // ════════════════════════════════════════════════
            // SERIE IV — Competence 59 (Síntesis: 2 correctas por pregunta)
            // ════════════════════════════════════════════════
            [678, 59, 'A) ALTURA - LONGITUD',         0, 0],
            [678, 59, 'B) CIRCUNFERENCIA - RADIO',    1, 1],
            [678, 59, 'C) LATITUD - RADIO',           0, 0],
            [678, 59, 'D) LONGITUD - CIRCUNFERENCIA', 0, 0],
            [678, 59, 'E) RADIO - ALTURA',            0, 0],

            [679, 59, 'A) HUESOS - CANTO',   0, 0],
            [679, 59, 'B) HUEVOS - PLUMAS',  0, 0],
            [679, 59, 'C) PICO - HUESOS',    1, 1],
            [679, 59, 'D) NIDO - HUEVOS',    0, 0],
            [679, 59, 'E) CANTO - PLUMAS',   0, 0],

            [680, 59, 'A) OYENTE - PIANO',   0, 0],
            [680, 59, 'B) PIANO - VIOLÍN',   0, 0],
            [680, 59, 'C) RITMO - SONIDO',   1, 1],
            [680, 59, 'D) SONIDO - OYENTE',  0, 0],
            [680, 59, 'E) VIOLÍN - ACORDES', 0, 0],

            [681, 59, 'A) ALIMENTO - DISCURSO',  0, 0],
            [681, 59, 'B) MÚSICA - ANFITRIÓN',   0, 0],
            [681, 59, 'C) PERSONAS - ALIMENTO',  1, 1],
            [681, 59, 'D) DISCURSO - PERSONAS',  0, 0],
            [681, 59, 'E) ANFITRIÓN - ALIMENTO', 0, 0],

            [682, 59, 'A) ARNÉS - ESTABLO',      0, 0],
            [682, 59, 'B) CASCOS - COLA',        1, 1],
            [682, 59, 'C) HERRADURAS - CASCO',   0, 0],
            [682, 59, 'D) ESTABLO - HERRADURAS', 0, 0],
            [682, 59, 'E) COLA - ARNÉS',         0, 0],

            [683, 59, 'A) CARTAS - JUGADORES',   0, 0],
            [683, 59, 'B) MULTAS - REGLAS',      0, 0],
            [683, 59, 'C) JUGADORES - REGLAS',   1, 1],
            [683, 59, 'D) CASTIGOS - CARTAS',    0, 0],
            [683, 59, 'E) REGLAS - CASTIGOS',    0, 0],

            [684, 59, 'A) COLOR - PESO',   0, 0],
            [684, 59, 'B) TAMAÑO - SABOR', 0, 0],
            [684, 59, 'C) SABOR - COLOR',  0, 0],
            [684, 59, 'D) VALOR - TAMAÑO', 0, 0],
            [684, 59, 'E) PESO - TAMAÑO',  1, 1],

            [685, 59, 'A) ACUERDOS - PERSONAS',  0, 0],
            [685, 59, 'B) PERSONAS - PALABRAS',  1, 1],
            [685, 59, 'C) PREGUNTAS - INGENIO',  0, 0],
            [685, 59, 'D) INGENIO - ACUERDOS',   0, 0],
            [685, 59, 'E) PALABRAS - INGENIO',   0, 0],

            [686, 59, 'A) ACREEDOR - DEUDOR',    1, 1],
            [686, 59, 'B) DEUDOR - PAGO',        0, 0],
            [686, 59, 'C) INTERÉS - ACREEDOR',   0, 0],
            [686, 59, 'D) HIPOTECA - PAGO',      0, 0],
            [686, 59, 'E) PAGO - INTERÉS',       0, 0],

            [687, 59, 'A) PAÍS - DERECHOS',      1, 1],
            [687, 59, 'B) OCUPACIÓN - PAÍS',     0, 0],
            [687, 59, 'C) DERECHOS - VOTO',      0, 0],
            [687, 59, 'D) PROPIEDAD - DERECHOS', 0, 0],
            [687, 59, 'E) VOTO - PAÍS',          0, 0],

            [688, 59, 'A) ANIMALES - MINERALES',    0, 0],
            [688, 59, 'B) ORDEN - COLECCIONES',     1, 1],
            [688, 59, 'C) COLECCIONES - VISITANTES',0, 0],
            [688, 59, 'D) MINERALES - COLECCIONES', 0, 0],
            [688, 59, 'E) VISITANTES - ORDEN',      0, 0],

            [689, 59, 'A) OBLIGACIÓN - ACUERDO',  1, 1],
            [689, 59, 'B) ACUERDO - RESPETO',     0, 0],
            [689, 59, 'C) AMISTAD - OBLIGACIÓN',  0, 0],
            [689, 59, 'D) RESPETO - AMISTAD',     0, 0],
            [689, 59, 'E) SATISFACCIÓN - OBLIGACIÓN', 0, 0],

            [690, 59, 'A) ANIMALES - MALEZA',   0, 0],
            [690, 59, 'B) FLORES - SOMBRAS',    0, 0],
            [690, 59, 'C) SOMBRAS - ÁRBOLES',   1, 1],
            [690, 59, 'D) MALEZA - FLORES',     0, 0],
            [690, 59, 'E) ÁRBOLES - ANIMALES',  0, 0],

            [691, 59, 'A) DIFICULTAD - FRACASO',       0, 0],
            [691, 59, 'B) DESALIENTO - IMPEDIMENTO',   0, 0],
            [691, 59, 'C) FRACASO - ESTÍMULO',         0, 0],
            [691, 59, 'D) IMPEDIMENTO - DIFICULTAD',   1, 1],
            [691, 59, 'E) ESTÍMULO - DESALIENTO',      0, 0],

            [692, 59, 'A) AVERSIÓN - DESAGRADO',  1, 1],
            [692, 59, 'B) DESAGRADO - TEMOR',     0, 0],
            [692, 59, 'C) TEMOR - IRA',           0, 0],
            [692, 59, 'D) IRA - AVERSIÓN',        0, 0],
            [692, 59, 'E) TIMIDEZ - DESAGRADO',   0, 0],

            [693, 59, 'A) ANUNCIOS - PAPEL',       0, 0],
            [693, 59, 'B) PAPEL - IMPRESIÓN',      1, 1],
            [693, 59, 'C) FOTOGRAFÍAS - ANUNCIOS', 0, 0],
            [693, 59, 'D) GRABADOS - IMPRESIÓN',   0, 0],
            [693, 59, 'E) IMPRESIÓN - FOTOGRAFÍAS',0, 0],

            [694, 59, 'A) ARGUMENTO - PÚBLICO',      0, 0],
            [694, 59, 'B) DESACUERDOS - ARGUMENTO',  1, 1],
            [694, 59, 'C) AVERSIÓN - RESUMEN',       0, 0],
            [694, 59, 'D) PÚBLICO - DESACUERDO',     0, 0],
            [694, 59, 'E) RESUMEN - ARGUMENTO',      0, 0],

            [695, 59, 'A) MAQUINARIA - CAÑONES', 0, 0],
            [695, 59, 'B) CAÑONES - VELAS',      0, 0],
            [695, 59, 'C) QUILLA - MAQUINARIA',  0, 0],
            [695, 59, 'D) TIMÓN - QUILLA',       1, 1],
            [695, 59, 'E) VELAS - TIMÓN',        0, 0],

            // ════════════════════════════════════════════════
            // SERIE V — Competence 60 (Concentración / Aritmética)
            // ════════════════════════════════════════════════
            [696, 60, 'A) 30', 0, 0], [696, 60, 'B) 15', 0, 0], [696, 60, 'C) 20', 1, 1], [696, 60, 'D) 25', 0, 0], [696, 60, 'E) 18', 0, 0],
            [697, 60, 'A) 7',  0, 0], [697, 60, 'B) 10', 0, 0], [697, 60, 'C) 15', 0, 0], [697, 60, 'D) 11', 1, 1], [697, 60, 'E) 13', 0, 0],
            [698, 60, 'A) 38', 0, 0], [698, 60, 'B) 45', 0, 0], [698, 60, 'C) 60', 0, 0], [698, 60, 'D) 55', 0, 0], [698, 60, 'E) 50', 1, 1],
            [699, 60, 'A) 25', 0, 0], [699, 60, 'B) 50', 1, 1], [699, 60, 'C) 75', 0, 0], [699, 60, 'D) 100',0, 0], [699, 60, 'E) 150',0, 0],
            [700, 60, 'A) 12', 1, 1], [700, 60, 'B) 8',  0, 0], [700, 60, 'C) 10', 0, 0], [700, 60, 'D) 19', 0, 0], [700, 60, 'E) 16', 0, 0],
            [701, 60, 'A) 12', 0, 0], [701, 60, 'B) 16', 0, 0], [701, 60, 'C) 18', 1, 1], [701, 60, 'D) 20', 0, 0], [701, 60, 'E) 24', 0, 0],
            [702, 60, 'A) 300',0, 0], [702, 60, 'B) 500',1, 1], [702, 60, 'C) 180',0, 0], [702, 60, 'D) 700',0, 0], [702, 60, 'E) 243',0, 0],
            [703, 60, 'A) 1',  0, 0], [703, 60, 'B) 6',  0, 0], [703, 60, 'C) 2',  1, 1], [703, 60, 'D) 4',  0, 0], [703, 60, 'E) 8',  0, 0],
            [704, 60, 'A) 14', 0, 0], [704, 60, 'B) 21', 0, 0], [704, 60, 'C) 24', 0, 0], [704, 60, 'D) 28', 1, 1], [704, 60, 'E) 32', 0, 0],
            [705, 60, 'A) 360',1, 1], [705, 60, 'B) 320',0, 0], [705, 60, 'C) 340',0, 0], [705, 60, 'D) 325',0, 0], [705, 60, 'E) 380',0, 0],
            [706, 60, 'A) 1',  0, 0], [706, 60, 'B) 2',  1, 1], [706, 60, 'C) 3',  0, 0], [706, 60, 'D) 4',  0, 0], [706, 60, 'E) 5',  0, 0],
            [707, 60, 'A) 18%',0, 0], [707, 60, 'B) 15%',0, 0], [707, 60, 'C) 20%',0, 0], [707, 60, 'D) 28%',0, 0], [707, 60, 'E) 25%',1, 1],

            // ════════════════════════════════════════════════
            // SERIE VI — Competence 61 (Análisis: Sí / No)
            // ════════════════════════════════════════════════
            [708, 61, 'Sí', 1, 1], [708, 61, 'No', 0, 0],
            [709, 61, 'Sí', 0, 0], [709, 61, 'No', 1, 1],
            [710, 61, 'Sí', 0, 0], [710, 61, 'No', 1, 1],
            [711, 61, 'Sí', 1, 1], [711, 61, 'No', 0, 0],
            [712, 61, 'Sí', 1, 1], [712, 61, 'No', 0, 0],
            [713, 61, 'Sí', 0, 0], [713, 61, 'No', 1, 1],
            [714, 61, 'Sí', 0, 0], [714, 61, 'No', 1, 1],
            [715, 61, 'Sí', 0, 0], [715, 61, 'No', 1, 1],
            [716, 61, 'Sí', 1, 1], [716, 61, 'No', 0, 0],
            [717, 61, 'Sí', 1, 1], [717, 61, 'No', 0, 0],
            [718, 61, 'Sí', 0, 0], [718, 61, 'No', 1, 1],
            [719, 61, 'Sí', 0, 0], [719, 61, 'No', 1, 1],
            [720, 61, 'Sí', 0, 0], [720, 61, 'No', 1, 1],
            [721, 61, 'Sí', 1, 1], [721, 61, 'No', 0, 0],
            [722, 61, 'Sí', 0, 0], [722, 61, 'No', 1, 1],
            [723, 61, 'Sí', 0, 0], [723, 61, 'No', 1, 1],
            [724, 61, 'Sí', 1, 1], [724, 61, 'No', 0, 0],
            [725, 61, 'Sí', 0, 0], [725, 61, 'No', 1, 1],
            [726, 61, 'Sí', 1, 1], [726, 61, 'No', 0, 0],
            [727, 61, 'Sí', 1, 1], [727, 61, 'No', 0, 0],

            // ════════════════════════════════════════════════
            // SERIE VII — Competence 62 (Abstracción / Analogías)
            // ════════════════════════════════════════════════
            [728, 62, 'A) COMER',    1, 1], [728, 62, 'B) HAMBRE',   0, 0], [728, 62, 'C) AGUA',     0, 0], [728, 62, 'D) COCINA',   0, 0],
            [729, 62, 'A) AÑO',     1, 1], [729, 62, 'B) HORA',     0, 0], [729, 62, 'C) MINUTO',   0, 0], [729, 62, 'D) SEGUNDO',  0, 0],
            [730, 62, 'A) OLOR',    0, 0], [730, 62, 'B) HOJA',     0, 0], [730, 62, 'C) PLANTA',   1, 1], [730, 62, 'D) ESPINA',   0, 0],
            [731, 62, 'A) NEGRO',   0, 0], [731, 62, 'B) ESCLAVITUD',1, 1], [731, 62, 'C) LIBRE',    0, 0], [731, 62, 'D) SUFRIR',   0, 0],
            [732, 62, 'A) CANTAR',  0, 0], [732, 62, 'B) ESTUVO',   1, 1], [732, 62, 'C) HABLANDO', 0, 0], [732, 62, 'D) CANTÓ',    0, 0],
            [733, 62, 'A) SEMANA',  0, 0], [733, 62, 'B) JUEVES',   0, 0], [733, 62, 'C) DÍA',      0, 0], [733, 62, 'D) SÁBADO',   1, 1],
            [734, 62, 'A) BOTELLA', 0, 0], [734, 62, 'B) PESO',     0, 0], [734, 62, 'C) LIGERO',   1, 1], [734, 62, 'D) FLOTAR',   0, 0],
            [735, 62, 'A) TRISTEZA',1, 1], [735, 62, 'B) SUERTE',   0, 0], [735, 62, 'C) FRACASAR', 0, 0], [735, 62, 'D) TRABAJO',  0, 0],
            [736, 62, 'A) LOBO',    1, 1], [736, 62, 'B) LADRIDO',  0, 0], [736, 62, 'C) MORDIDA',  0, 0], [736, 62, 'D) AGARRAR',  0, 0],
            [737, 62, 'A) SIETE',    0, 0], [737, 62, 'B) CUARENTA Y CINCO', 0, 0], [737, 62, 'C) TREINTA Y CINCO', 0, 0], [737, 62, 'D) VEINTICINCO', 1, 1],
            [738, 62, 'A) MUERTE',  0, 0], [738, 62, 'B) ALEGRE',   1, 1], [738, 62, 'C) MORTAJA',  0, 0], [738, 62, 'D) DOCTOR',   0, 0],
            [739, 62, 'A) COMER',   0, 0], [739, 62, 'B) PÁJARO',   0, 0], [739, 62, 'C) VIDA',     1, 1], [739, 62, 'D) MALO',     0, 0],
            [740, 62, 'A) 18',      0, 0], [740, 62, 'B) 27',       1, 1], [740, 62, 'C) 36',       0, 0], [740, 62, 'D) 45',       0, 0],
            [741, 62, 'A) BEBER',   0, 0], [741, 62, 'B) CLARO',    0, 0], [741, 62, 'C) SED',      1, 1], [741, 62, 'D) PURO',     0, 0],
            [742, 62, 'A) ESTOS',   0, 0], [742, 62, 'B) AQUEL',    0, 0], [742, 62, 'C) ESE',      1, 1], [742, 62, 'D) ENTONCES', 0, 0],
            [743, 62, 'A) AGUA',    0, 0], [743, 62, 'B) PEZ',      0, 0], [743, 62, 'C) ESCAMA',   1, 1], [743, 62, 'D) NADAR',    0, 0],
            [744, 62, 'A) PATRIA',  0, 0], [744, 62, 'B) HONRADO',  1, 1], [744, 62, 'C) SANCIÓN',  0, 0], [744, 62, 'D) ESTUDIO',  0, 0],
            [745, 62, 'A) TERCERO', 0, 0], [745, 62, 'B) ÚLTIMO',   0, 0], [745, 62, 'C) CUARTO',   1, 1], [745, 62, 'D) POSTERIOR',0, 0],
            [746, 62, 'A) MARINA',  0, 0], [746, 62, 'B) SOLDADO',  0, 0], [746, 62, 'C) GENERAL',  1, 1], [746, 62, 'D) SARGENTO', 0, 0],
            [747, 62, 'A) PRONOMBRE',0, 0],[747, 62, 'B) ADVERBIO',  0, 0], [747, 62, 'C) VERBO',    1, 1], [747, 62, 'D) ADJETIVO', 0, 0],

            // ════════════════════════════════════════════════
            // SERIE VIII — Competence 63 (Planeación: V / F)
            // ════════════════════════════════════════════════
            [748, 63, 'VERDADERO', 1, 1], [748, 63, 'FALSO', 0, 0],
            [749, 63, 'VERDADERO', 0, 0], [749, 63, 'FALSO', 1, 1],
            [750, 63, 'VERDADERO', 1, 1], [750, 63, 'FALSO', 0, 0],
            [751, 63, 'VERDADERO', 1, 1], [751, 63, 'FALSO', 0, 0],
            [752, 63, 'VERDADERO', 1, 1], [752, 63, 'FALSO', 0, 0],
            [753, 63, 'VERDADERO', 0, 0], [753, 63, 'FALSO', 1, 1],
            [754, 63, 'VERDADERO', 0, 0], [754, 63, 'FALSO', 1, 1],
            [755, 63, 'VERDADERO', 1, 1], [755, 63, 'FALSO', 0, 0],
            [756, 63, 'VERDADERO', 1, 1], [756, 63, 'FALSO', 0, 0],
            [757, 63, 'VERDADERO', 0, 0], [757, 63, 'FALSO', 1, 1],
            [758, 63, 'VERDADERO', 0, 0], [758, 63, 'FALSO', 1, 1],
            [759, 63, 'VERDADERO', 0, 0], [759, 63, 'FALSO', 1, 1],
            [760, 63, 'VERDADERO', 1, 1], [760, 63, 'FALSO', 0, 0],
            [761, 63, 'VERDADERO', 1, 1], [761, 63, 'FALSO', 0, 0],
            [762, 63, 'VERDADERO', 1, 1], [762, 63, 'FALSO', 0, 0],
            [763, 63, 'VERDADERO', 1, 1], [763, 63, 'FALSO', 0, 0],
            [764, 63, 'VERDADERO', 0, 0], [764, 63, 'FALSO', 1, 1],

            // ════════════════════════════════════════════════
            // SERIE IX — Competence 64 (Organización / Clasificación)
            // ════════════════════════════════════════════════
            [765, 64, 'A) SALTAR',    0, 0], [765, 64, 'B) CORRER',     0, 0], [765, 64, 'C) BRINCAR',    0, 0], [765, 64, 'D) PARARSE',    1, 1], [765, 64, 'E) CAMINAR',    0, 0],
            [766, 64, 'A) MONARQUÍA', 0, 0], [766, 64, 'B) COMUNISTA',  0, 0], [766, 64, 'C) DEMÓCRATA',  0, 0], [766, 64, 'D) ANARQUISTA', 0, 0], [766, 64, 'E) CATÓLICO',   1, 1],
            [767, 64, 'A) MUERTE',    0, 0], [767, 64, 'B) DUELO',      0, 0], [767, 64, 'C) PASEO',      1, 1], [767, 64, 'D) POBREZA',    0, 0], [767, 64, 'E) TRISTEZA',   0, 0],
            [768, 64, 'A) CARPINTERO',1, 1], [768, 64, 'B) DOCTOR',     0, 0], [768, 64, 'C) ABOGADO',    0, 0], [768, 64, 'D) INGENIERO',  0, 0], [768, 64, 'E) PROFESOR',   0, 0],
            [769, 64, 'A) CAMA',      0, 0], [769, 64, 'B) SILLA',      0, 0], [769, 64, 'C) PLATO',      1, 1], [769, 64, 'D) SOPA',       0, 0], [769, 64, 'E) MESA',       0, 0],
            [770, 64, 'A) FRANCISCO', 0, 0], [770, 64, 'B) SANTIAGO',   0, 0], [770, 64, 'C) JUAN',       0, 0], [770, 64, 'D) SARA',       1, 1], [770, 64, 'E) GUILLÉN',    0, 0],
            [771, 64, 'A) DURO',      0, 0], [771, 64, 'B) ÁSPERO',     0, 0], [771, 64, 'C) LISO',       0, 0], [771, 64, 'D) SUAVE',      0, 0], [771, 64, 'E) DULCE',      1, 1],
            [772, 64, 'A) DIGESTIVO', 1, 1], [772, 64, 'B) ODIO',       0, 0], [772, 64, 'C) VISTA',      0, 0], [772, 64, 'D) OLFATO',     0, 0], [772, 64, 'E) TACTO',      0, 0],
            [773, 64, 'A) AUTOMÓVIL', 0, 0], [773, 64, 'B) BICICLETA',  0, 0], [773, 64, 'C) GUAYÍN',     0, 0], [773, 64, 'D) TELÉGRAFO',  1, 1], [773, 64, 'E) TREN',       0, 0],
            [774, 64, 'A) ABAJO',     0, 0], [774, 64, 'B) ACÁ',        0, 0], [774, 64, 'C) RECIENTE',   1, 1], [774, 64, 'D) ARRIBA',     0, 0], [774, 64, 'E) ALLÁ',       0, 0],
            [775, 64, 'A) HIDALGO',   0, 0], [775, 64, 'B) MORELOS',    0, 0], [775, 64, 'C) BRAVO',      0, 0], [775, 64, 'D) MATAMOROS',  0, 0], [775, 64, 'E) BOLÍVAR',    1, 1],
            [776, 64, 'A) DANÉS',     0, 0], [776, 64, 'B) GALGO',      0, 0], [776, 64, 'C) BULLDOG',    0, 0], [776, 64, 'D) PEKINÉS',    0, 0], [776, 64, 'E) LONGHORI',   1, 1],
            [777, 64, 'A) TELA',      1, 1], [777, 64, 'B) ALGODÓN',    0, 0], [777, 64, 'C) LINO',       0, 0], [777, 64, 'D) SEDA',       0, 0], [777, 64, 'E) LANA',       0, 0],
            [778, 64, 'A) IRA',       0, 0], [778, 64, 'B) ODIO',       0, 0], [778, 64, 'C) ALEGRÍA',    0, 0], [778, 64, 'D) PIEDAD',     0, 0], [778, 64, 'E) RAZONAMIENTO',1, 1],
            [779, 64, 'A) EDISON',    0, 0], [779, 64, 'B) FRANKLIN',   0, 0], [779, 64, 'C) MARCONI',    0, 0], [779, 64, 'D) FULTON',     0, 0], [779, 64, 'E) SHAKESPEARE', 1, 1],
            [780, 64, 'A) MARIPOSA',  1, 1], [780, 64, 'B) HALCÓN',     0, 0], [780, 64, 'C) AVESTRUZ',   0, 0], [780, 64, 'D) PETIRROJO',  0, 0], [780, 64, 'E) GOLONDRINA', 0, 0],
            [781, 64, 'A) DAR',       0, 0], [781, 64, 'B) PRESTAR',    0, 0], [781, 64, 'C) PERDER',     0, 0], [781, 64, 'D) AHORRAR',    1, 1], [781, 64, 'E) DERROCHAR',  0, 0],
            [782, 64, 'A) AUSTRALIA', 0, 0], [782, 64, 'B) CUBA',       0, 0], [782, 64, 'C) CÓRCEGA',    0, 0], [782, 64, 'D) IRLANDA',    0, 0], [782, 64, 'E) ESPAÑA',     1, 1],

            // ════════════════════════════════════════════════
            // SERIE X — Competence 65 (Anticipación / Series numéricas)
            // ════════════════════════════════════════════════
            [783, 65, 'A) 3 – 2',   0, 0], [783, 65, 'B) 2 – 1',   1, 1], [783, 65, 'C) 1 – 0',   0, 0], [783, 65, 'D) 2 – 0',   0, 0], [783, 65, 'E) 4 – 3',   0, 0],
            [784, 65, 'A) 34 – 38', 0, 0], [784, 65, 'B) 31 – 36', 0, 0], [784, 65, 'C) 32 – 37', 0, 0], [784, 65, 'D) 33 – 38', 1, 1], [784, 65, 'E) 36 – 39', 0, 0],
            [785, 65, 'A) 48 – 96', 0, 0], [785, 65, 'B) 56 – 112',0, 0], [785, 65, 'C) 64 – 128',1, 1], [785, 65, 'D) 72 – 144',0, 0], [785, 65, 'E) 80 – 160',0, 0],
            [786, 65, 'A) 3 – 3',   0, 0], [786, 65, 'B) 2 – 4',   0, 0], [786, 65, 'C) 4 – 2',   0, 0], [786, 65, 'D) 1 – 1',   0, 0], [786, 65, 'E) 2 – 2',   1, 1],
            [787, 65, 'A) 13 – 13',     0, 0], [787, 65, 'B) 12¾ – 13',  0, 0], [787, 65, 'C) 13 – 13¼',  1, 1], [787, 65, 'D) 13¼ – 13½', 0, 0], [787, 65, 'E) 12½ – 13',  0, 0],
            [788, 65, 'A) 20 – 21', 1, 1], [788, 65, 'B) 19 – 20', 0, 0], [788, 65, 'C) 23 – 24', 0, 0], [788, 65, 'D) 21 – 22', 0, 0], [788, 65, 'E) 18 – 19', 0, 0],
            [789, 65, 'A) ½ – ¼',   0, 0], [789, 65, 'B) ¼ – 1/16',0, 0], [789, 65, 'C) ¼ – ⅛',   1, 1], [789, 65, 'D) ⅛ – 1/16',0, 0], [789, 65, 'E) 1/16 – 1/32', 0, 0],
            [790, 65, 'A) 83.3 – 92.3', 0, 0], [790, 65, 'B) 84.3 – 93.3', 0, 0], [790, 65, 'C) 82.3 – 94.3', 0, 0], [790, 65, 'D) 86.3 – 95.3', 0, 0], [790, 65, 'E) 85.3 – 94.3', 1, 1],
            [791, 65, 'A) 6 – 8',   1, 1], [791, 65, 'B) 5 – 6',   0, 0], [791, 65, 'C) 6 – 9',   0, 0], [791, 65, 'D) 7 – 8',   0, 0], [791, 65, 'E) 5 – 7',   0, 0],
            [792, 65, 'A) 30 – 31', 0, 0], [792, 65, 'B) 31 – 32', 0, 0], [792, 65, 'C) 32 – 33', 0, 0], [792, 65, 'D) 33 – 34', 1, 1], [792, 65, 'E) 34 – 35', 0, 0],
            [793, 65, 'A) 10 – 25',  0, 0], [793, 65, 'B) 25 – 125', 1, 1], [793, 65, 'C) 20 – 100',0, 0], [793, 65, 'D) 20 – 125', 0, 0], [793, 65, 'E) 15 – 120', 0, 0],
        ];
*/
        //Arreglo con ids para PostgreeSQL con ERROR
        /*
        $answers = [
            // ════════════════════════════════════════════════
            // SERIE I — Competence 56 (Información)
            // ════════════════════════════════════════════════
            [617, 56, 'A) GRANO',        0, 0],
            [617, 56, 'B) PETRÓLEO',     1, 1],
            [617, 56, 'C) TREMENTINA',   0, 0],
            [617, 56, 'D) SEMILLAS',     0, 0],

            [618, 56, 'A) 1000 KILOGRAMOS',   1, 1],
            [618, 56, 'B) 2000 KILOGRAMOS',   0, 0],
            [618, 56, 'C) 3000 KILOGRAMOS',   0, 0],
            [618, 56, 'D) 4000 KILOGRAMOS',   0, 0],

            [619, 56, 'A) MAZATLÁN',   0, 0],
            [619, 56, 'B) VERACRUZ',   1, 1],
            [619, 56, 'C) PROGRESO',   0, 0],
            [619, 56, 'D) ACAPULCO',   0, 0],

            [620, 56, 'A) VER',     1, 1],
            [620, 56, 'B) OÍR',     0, 0],
            [620, 56, 'C) PROBAR',  0, 0],
            [620, 56, 'D) SENTIR',  0, 0],

            [621, 56, 'A) CORTEZA', 0, 0],
            [621, 56, 'B) FRUTO',   1, 1],
            [621, 56, 'C) HOJAS',   0, 0],
            [621, 56, 'D) RAÍZ',    0, 0],

            [622, 56, 'A) CARNERO',  0, 0],
            [622, 56, 'B) VACA',     0, 0],
            [622, 56, 'C) GALLINA',  0, 0],
            [622, 56, 'D) CERDO',    1, 1],

            [623, 56, 'A) ABDOMEN',   0, 0],
            [623, 56, 'B) CABEZA',    0, 0],
            [623, 56, 'C) GARGANTA',  1, 1],
            [623, 56, 'D) ESPALDA',   0, 0],

            [624, 56, 'A) MUERTE',      1, 1],
            [624, 56, 'B) ENFERMEDAD',  0, 0],
            [624, 56, 'C) FIEBRE',      0, 0],
            [624, 56, 'D) MALESTAR',    0, 0],

            [625, 56, 'A) PERFORAR', 0, 0],
            [625, 56, 'B) CORTAR',   0, 0],
            [625, 56, 'C) LEVANTAR', 1, 1],
            [625, 56, 'D) EXPRIMIR', 0, 0],

            [626, 56, 'A) PENTÁGONO',        0, 0],
            [626, 56, 'B) PARALELOGRAMO',    0, 0],
            [626, 56, 'C) HEXÁGONO',         1, 1],
            [626, 56, 'D) TRAPECIO',         0, 0],

            [627, 56, 'A) LLUVIA',       0, 0],
            [627, 56, 'B) VIENTO',       0, 0],
            [627, 56, 'C) ELECTRICIDAD', 1, 1],
            [627, 56, 'D) PRESIÓN',      0, 0],

            [628, 56, 'A) AGRICULTURA',  0, 0],
            [628, 56, 'B) MÚSICA',       1, 1],
            [628, 56, 'C) FOTOGRAFÍA',   0, 0],
            [628, 56, 'D) ESTENOGRAFÍA', 0, 0],

            [629, 56, 'A) AZULES',    0, 0],
            [629, 56, 'B) VERDES',    1, 1],
            [629, 56, 'C) ROJAS',     0, 0],
            [629, 56, 'D) AMARILLAS', 0, 0],

            [630, 56, 'A) PIE',     0, 0],
            [630, 56, 'B) PULGADA', 0, 0],
            [630, 56, 'C) YARDA',   1, 1],
            [630, 56, 'D) MILLA',   0, 0],

            [631, 56, 'A) ANIMALES', 1, 1],
            [631, 56, 'B) HIERBAS',  0, 0],
            [631, 56, 'C) BOSQUES',  0, 0],
            [631, 56, 'D) MINAS',    0, 0],

            [632, 56, 'A) MEDICINA',   0, 0],
            [632, 56, 'B) TEOLOGÍA',   0, 0],
            [632, 56, 'C) LEYES',      1, 1],
            [632, 56, 'D) PEDAGOGÍA',  0, 0],

            // ════════════════════════════════════════════════
            // SERIE II — Competence 57 (Juicio)
            // ════════════════════════════════════════════════
            [633, 57, 'A) LAS ESTRELLAS DESAPARECERÍAN.',         0, 0],
            [633, 57, 'B) LOS MESES SERÍAN MÁS LARGOS.',          0, 0],
            [633, 57, 'C) LA TIERRA ESTARÍA MÁS CALIENTE.',       1, 1],

            [634, 57, 'A) EL NOGAL ES FUERTE.',              1, 1],
            [634, 57, 'B) SE CORTA FÁCILMENTE.',             0, 0],
            [634, 57, 'C) SUS FRENOS NO SON BUENOS.',        0, 0],

            [635, 57, 'A) TIENE MÁS RUEDA.',         0, 0],
            [635, 57, 'B) ES MÁS PESADO.',            1, 1],
            [635, 57, 'C) SUS FRENOS NO SON BUENOS.', 0, 0],

            [636, 57, 'A) QUE LOS ROBLES SON DÉBILES.',                                    0, 0],
            [636, 57, 'B) QUE SON MEJORES LOS GOLPES PEQUEÑOS.',                           0, 0],
            [636, 57, 'C) QUE EL ESFUERZO CONSTANTE LOGRA RESULTADOS SORPRENDENTES.',      1, 1],

            [637, 57, 'A) QUE NO DEBEMOS VIGILARLA CUANDO ESTÉ EN EL FUEGO.',  0, 0],
            [637, 57, 'B) QUE TARDA EN HERVIR.',                                0, 0],
            [637, 57, 'C) QUE EL TIEMPO SE ALARGA CUANDO ESPERAMOS.',           1, 1],

            [638, 57, 'A) QUE EL PASTO SE SIEMBRA EN EL VERANO.',              0, 0],
            [638, 57, 'B) QUE DEBEMOS APROVECHAR NUESTRAS OPORTUNIDADES.',     1, 1],
            [638, 57, 'C) QUE EL PASTO NO DEBE CORTARSE EN LA NOCHE.',         0, 0],

            [639, 57, 'A) QUE UN ZAPATERO NO DEBE ABANDONAR SUS ZAPATOS.',         0, 0],
            [639, 57, 'B) QUE LOS ZAPATEROS NO DEBEN ESTAR OCIOSOS.',              0, 0],
            [639, 57, 'C) QUE DEBEMOS TRABAJAR EN LO QUE PODEMOS HACER MEJOR.',   1, 1],

            [640, 57, 'A) QUE EL PALO SIRVE PARA APRETAR.',                    0, 0],
            [640, 57, 'B) QUE LAS CUÑAS SIEMPRE SON DE MADERA.',               0, 0],
            [640, 57, 'C) NOS EXIGEN MÁS LAS PERSONAS QUE NOS CONOCEN.',       1, 1],

            [641, 57, 'A) LA MAQUINA LO HACE FLOTAR.',             0, 0],
            [641, 57, 'B) PORQUE TIENE GRANDES ESPACIOS HUECOS.',  1, 1],
            [641, 57, 'C) CONTIENE ALGO DE MADERA.',               0, 0],

            [642, 57, 'A) LAS ALAS OFRECEN UNA AMPLIA SUPERFICIE LIGERA.',  1, 1],
            [642, 57, 'B) MANTIENEN EL AIRE FUERA DEL CUERPO.',             0, 0],
            [642, 57, 'C) DISMINUYEN SU PESO.',                             0, 0],

            [643, 57, 'A) QUE LAS GOLONDRINAS REGRESAN.',                              0, 0],
            [643, 57, 'B) QUE UN SIMPLE DATO NO ES SUFICIENTE.',                       1, 1],
            [643, 57, 'C) QUE LOS PÁJAROS SE AGREGAN A NUESTROS PLACERES DE VERANO.', 0, 0],

            // ════════════════════════════════════════════════
            // SERIE III — Competence 58 (Vocabulario: I / O)
            // ════════════════════════════════════════════════
            [644, 58, 'I', 0, 0], [644, 58, 'O', 1, 1],
            [645, 58, 'I', 1, 1], [645, 58, 'O', 0, 0],
            [646, 58, 'I', 0, 0], [646, 58, 'O', 1, 1],
            [647, 58, 'I', 0, 0], [647, 58, 'O', 1, 1],
            [648, 58, 'I', 0, 0], [648, 58, 'O', 1, 1],
            [649, 58, 'I', 0, 0], [649, 58, 'O', 1, 1],
            [650, 58, 'I', 1, 1], [650, 58, 'O', 0, 0],
            [651, 58, 'I', 1, 1], [651, 58, 'O', 0, 0],
            [652, 58, 'I', 0, 0], [652, 58, 'O', 1, 1],
            [653, 58, 'I', 1, 1], [653, 58, 'O', 0, 0],
            [654, 58, 'I', 0, 0], [654, 58, 'O', 1, 1],
            [655, 58, 'I', 0, 0], [655, 58, 'O', 1, 1],
            [656, 58, 'I', 0, 0], [656, 58, 'O', 1, 1],
            [657, 58, 'I', 0, 0], [657, 58, 'O', 1, 1],
            [658, 58, 'I', 1, 1], [658, 58, 'O', 0, 0],
            [659, 58, 'I', 0, 0], [659, 58, 'O', 1, 1],
            [660, 58, 'I', 1, 1], [660, 58, 'O', 0, 0],
            [661, 58, 'I', 0, 0], [661, 58, 'O', 1, 1],
            [662, 58, 'I', 0, 0], [662, 58, 'O', 1, 1],
            [663, 58, 'I', 0, 0], [663, 58, 'O', 1, 1],
            [664, 58, 'I', 1, 1], [664, 58, 'O', 0, 0],
            [665, 58, 'I', 0, 0], [665, 58, 'O', 1, 1],
            [666, 58, 'I', 1, 1], [666, 58, 'O', 0, 0],
            [667, 58, 'I', 1, 1], [667, 58, 'O', 0, 0],
            [668, 58, 'I', 0, 0], [668, 58, 'O', 1, 1],
            [669, 58, 'I', 1, 1], [669, 58, 'O', 0, 0],
            [670, 58, 'I', 1, 1], [670, 58, 'O', 0, 0],
            [671, 58, 'I', 1, 1], [671, 58, 'O', 0, 0],   // SOBRIEDAD – FRUGALIDAD → Igual
            [672, 58, 'I', 0, 0], [672, 58, 'O', 1, 1],   // AUMENTAR – MENGUAR → Opuesto
            [673, 58, 'I', 1, 1], [673, 58, 'O', 0, 0],   // INCITAR – INSTIGAR → Igual


            // ════════════════════════════════════════════════
            // SERIE IV — Competence 59 (Síntesis)
            // ════════════════════════════════════════════════
            [674, 59, 'A) ALTURA - LONGITUD',         0, 0],
            [674, 59, 'B) CIRCUNFERENCIA - RADIO',    1, 1],
            [674, 59, 'C) LATITUD - RADIO',           0, 0],
            [674, 59, 'D) LONGITUD - CIRCUNFERENCIA', 0, 0],
            [674, 59, 'E) RADIO - ALTURA',            0, 0],

            [675, 59, 'A) HUESOS - CANTO',   0, 0],
            [675, 59, 'B) HUEVOS - PLUMAS',  0, 0],
            [675, 59, 'C) PICO - HUESOS',    1, 1],
            [675, 59, 'D) NIDO - HUEVOS',    0, 0],
            [675, 59, 'E) CANTO - PLUMAS',   0, 0],

            [676, 59, 'A) OYENTE - PIANO',   0, 0],
            [676, 59, 'B) PIANO - VIOLÍN',   0, 0],
            [676, 59, 'C) RITMO - SONIDO',   1, 1],
            [676, 59, 'D) SONIDO - OYENTE',  0, 0],
            [676, 59, 'E) VIOLÍN - ACORDES', 0, 0],

            [677, 59, 'A) ALIMENTO - DISCURSO',  0, 0],
            [677, 59, 'B) MÚSICA - ANFITRIÓN',   0, 0],
            [677, 59, 'C) PERSONAS - ALIMENTO',  1, 1],
            [677, 59, 'D) DISCURSO - PERSONAS',  0, 0],
            [677, 59, 'E) ANFITRIÓN - ALIMENTO', 0, 0],

            [678, 59, 'A) ARNÉS - ESTABLO',      0, 0],
            [678, 59, 'B) CASCOS - COLA',        1, 1],
            [678, 59, 'C) HERRADURAS - CASCO',   0, 0],
            [678, 59, 'D) ESTABLO - HERRADURAS', 0, 0],
            [678, 59, 'E) COLA - ARNÉS',         0, 0],

            [679, 59, 'A) CARTAS - JUGADORES',   0, 0],
            [679, 59, 'B) MULTAS - REGLAS',      0, 0],
            [679, 59, 'C) JUGADORES - REGLAS',   1, 1],
            [679, 59, 'D) CASTIGOS - CARTAS',    0, 0],
            [679, 59, 'E) REGLAS - CASTIGOS',    0, 0],

            [680, 59, 'A) COLOR - PESO',   0, 0],
            [680, 59, 'B) TAMAÑO - SABOR', 0, 0],
            [680, 59, 'C) SABOR - COLOR',  0, 0],
            [680, 59, 'D) VALOR - TAMAÑO', 0, 0],
            [680, 59, 'E) PESO - TAMAÑO',  1, 1],

            [681, 59, 'A) ACUERDOS - PERSONAS',  0, 0],
            [681, 59, 'B) PERSONAS - PALABRAS',  1, 1],
            [681, 59, 'C) PREGUNTAS - INGENIO',  0, 0],
            [681, 59, 'D) INGENIO - ACUERDOS',   0, 0],
            [681, 59, 'E) PALABRAS - INGENIO',   0, 0],

            [682, 59, 'A) ACREEDOR - DEUDOR',    1, 1],
            [682, 59, 'B) DEUDOR - PAGO',        0, 0],
            [682, 59, 'C) INTERÉS - ACREEDOR',   0, 0],
            [682, 59, 'D) HIPOTECA - PAGO',      0, 0],
            [682, 59, 'E) PAGO - INTERÉS',       0, 0],

            [683, 59, 'A) PAÍS - DERECHOS',      1, 1],
            [683, 59, 'B) OCUPACIÓN - PAÍS',     0, 0],
            [683, 59, 'C) DERECHOS - VOTO',      0, 0],
            [683, 59, 'D) PROPIEDAD - DERECHOS', 0, 0],
            [683, 59, 'E) VOTO - PAÍS',          0, 0],

            [684, 59, 'A) ANIMALES - MINERALES',    0, 0],
            [684, 59, 'B) ORDEN - COLECCIONES',     1, 1],
            [684, 59, 'C) COLECCIONES - VISITANTES',0, 0],
            [684, 59, 'D) MINERALES - COLECCIONES', 0, 0],
            [684, 59, 'E) VISITANTES - ORDEN',      0, 0],

            [685, 59, 'A) OBLIGACIÓN - ACUERDO',  1, 1],
            [685, 59, 'B) ACUERDO - RESPETO',     0, 0],
            [685, 59, 'C) AMISTAD - OBLIGACIÓN',  0, 0],
            [685, 59, 'D) RESPETO - AMISTAD',     0, 0],
            [685, 59, 'E) SATISFACCIÓN - OBLIGACIÓN', 0, 0],

            [686, 59, 'A) ANIMALES - MALEZA',   0, 0],
            [686, 59, 'B) FLORES - SOMBRAS',    0, 0],
            [686, 59, 'C) SOMBRAS - ÁRBOLES',   1, 1],
            [686, 59, 'D) MALEZA - FLORES',     0, 0],
            [686, 59, 'E) ÁRBOLES - ANIMALES',  0, 0],

            [687, 59, 'A) DIFICULTAD - FRACASO',       0, 0],
            [687, 59, 'B) DESALIENTO - IMPEDIMENTO',   0, 0],
            [687, 59, 'C) FRACASO - ESTÍMULO',         0, 0],
            [687, 59, 'D) IMPEDIMENTO - DIFICULTAD',   1, 1],
            [687, 59, 'E) ESTÍMULO - DESALIENTO',      0, 0],

            [688, 59, 'A) AVERSIÓN - DESAGRADO',  1, 1],
            [688, 59, 'B) DESAGRADO - TEMOR',     0, 0],
            [688, 59, 'C) TEMOR - IRA',           0, 0],
            [688, 59, 'D) IRA - AVERSIÓN',        0, 0],
            [688, 59, 'E) TIMIDEZ - DESAGRADO',   0, 0],

            [689, 59, 'A) ANUNCIOS - PAPEL',       0, 0],
            [689, 59, 'B) PAPEL - IMPRESIÓN',      1, 1],
            [689, 59, 'C) FOTOGRAFÍAS - ANUNCIOS', 0, 0],
            [689, 59, 'D) GRABADOS - IMPRESIÓN',   0, 0],
            [689, 59, 'E) IMPRESIÓN - FOTOGRAFÍAS',0, 0],

            [690, 59, 'A) ARGUMENTO - PÚBLICO',      0, 0],
            [690, 59, 'B) DESACUERDOS - ARGUMENTO',  1, 1],
            [690, 59, 'C) AVERSIÓN - RESUMEN',       0, 0],
            [690, 59, 'D) PÚBLICO - DESACUERDO',     0, 0],
            [690, 59, 'E) RESUMEN - ARGUMENTO',      0, 0],

            [691, 59, 'A) MAQUINARIA - CAÑONES', 0, 0],
            [691, 59, 'B) CAÑONES - VELAS',      0, 0],
            [691, 59, 'C) QUILLA - MAQUINARIA',  0, 0],
            [691, 59, 'D) TIMÓN - QUILLA',       1, 1],
            [691, 59, 'E) VELAS - TIMÓN',        0, 0],

// ════════════════════════════════════════════════
// SERIE V — Competence 60 (Aritmética)
// ════════════════════════════════════════════════
            [692, 60, 'A) 30', 0, 0], [692, 60, 'B) 15', 0, 0], [692, 60, 'C) 20', 1, 1], [692, 60, 'D) 25', 0, 0], [692, 60, 'E) 18', 0, 0],
            [693, 60, 'A) 7',  0, 0], [693, 60, 'B) 10', 0, 0], [693, 60, 'C) 15', 0, 0], [693, 60, 'D) 11', 1, 1], [693, 60, 'E) 13', 0, 0],
            [694, 60, 'A) 38', 0, 0], [694, 60, 'B) 45', 0, 0], [694, 60, 'C) 60', 0, 0], [694, 60, 'D) 55', 0, 0], [694, 60, 'E) 50', 1, 1],
            [695, 60, 'A) 25', 0, 0], [695, 60, 'B) 50', 1, 1], [695, 60, 'C) 75', 0, 0], [695, 60, 'D) 100',0, 0], [695, 60, 'E) 150',0, 0],
            [696, 60, 'A) 12', 1, 1], [696, 60, 'B) 8',  0, 0], [696, 60, 'C) 10', 0, 0], [696, 60, 'D) 19', 0, 0], [696, 60, 'E) 16', 0, 0],
            [697, 60, 'A) 12', 0, 0], [697, 60, 'B) 16', 0, 0], [697, 60, 'C) 18', 1, 1], [697, 60, 'D) 20', 0, 0], [697, 60, 'E) 24', 0, 0],
            [698, 60, 'A) 300',0, 0], [698, 60, 'B) 500',1, 1], [698, 60, 'C) 180',0, 0], [698, 60, 'D) 700',0, 0], [698, 60, 'E) 243',0, 0],
            [699, 60, 'A) 1',  0, 0], [699, 60, 'B) 6',  0, 0], [699, 60, 'C) 2',  1, 1], [699, 60, 'D) 4',  0, 0], [699, 60, 'E) 8',  0, 0],
            [700, 60, 'A) 14', 0, 0], [700, 60, 'B) 21', 0, 0], [700, 60, 'C) 24', 0, 0], [700, 60, 'D) 28', 1, 1], [700, 60, 'E) 32', 0, 0],
            [701, 60, 'A) 360',1, 1], [701, 60, 'B) 320',0, 0], [701, 60, 'C) 340',0, 0], [701, 60, 'D) 325',0, 0], [701, 60, 'E) 380',0, 0],
            [702, 60, 'A) 1',  0, 0], [702, 60, 'B) 2',  1, 1], [702, 60, 'C) 3',  0, 0], [702, 60, 'D) 4',  0, 0], [702, 60, 'E) 5',  0, 0],
            [703, 60, 'A) 18%',0, 0], [703, 60, 'B) 15%',0, 0], [703, 60, 'C) 20%',0, 0], [703, 60, 'D) 28%',0, 0], [703, 60, 'E) 25%',1, 1],

// ════════════════════════════════════════════════
// SERIE VI — Competence 61 (Comprensión Verbal)
// ════════════════════════════════════════════════
            [704, 61, 'Sí', 1, 1], [704, 61, 'No', 0, 0],
            [705, 61, 'Sí', 0, 0], [705, 61, 'No', 1, 1],
            [706, 61, 'Sí', 0, 0], [706, 61, 'No', 1, 1],
            [707, 61, 'Sí', 1, 1], [707, 61, 'No', 0, 0],
            [708, 61, 'Sí', 1, 1], [708, 61, 'No', 0, 0],
            [709, 61, 'Sí', 0, 0], [709, 61, 'No', 1, 1],
            [710, 61, 'Sí', 0, 0], [710, 61, 'No', 1, 1],
            [711, 61, 'Sí', 0, 0], [711, 61, 'No', 1, 1],
            [712, 61, 'Sí', 1, 1], [712, 61, 'No', 0, 0],
            [713, 61, 'Sí', 1, 1], [713, 61, 'No', 0, 0],
            [714, 61, 'Sí', 0, 0], [714, 61, 'No', 1, 1],
            [715, 61, 'Sí', 0, 0], [715, 61, 'No', 1, 1],
            [716, 61, 'Sí', 0, 0], [716, 61, 'No', 1, 1],
            [717, 61, 'Sí', 1, 1], [717, 61, 'No', 0, 0],
            [718, 61, 'Sí', 0, 0], [718, 61, 'No', 1, 1],
            [719, 61, 'Sí', 1, 1], [719, 61, 'No', 0, 0],
            [720, 61, 'Sí', 1, 1], [720, 61, 'No', 0, 0],
            [721, 61, 'Sí', 0, 0], [721, 61, 'No', 1, 1],
            [722, 61, 'Sí', 0, 0], [722, 61, 'No', 1, 1],
            [723, 61, 'Sí', 0, 0], [723, 61, 'No', 1, 1],
            [724, 61, 'Sí', 1, 1], [724, 61, 'No', 0, 0],
            [725, 61, 'Sí', 0, 0], [725, 61, 'No', 1, 1],
            [726, 61, 'Sí', 0, 0], [726, 61, 'No', 1, 1],

// ════════════════════════════════════════════════
// SERIE VII — Competence 62 (Analogías)
// ════════════════════════════════════════════════
            [727, 62, 'A) COMER',    1, 1], [727, 62, 'B) HAMBRE',   0, 0], [727, 62, 'C) AGUA',     0, 0], [727, 62, 'D) COCINA',   0, 0],
            [728, 62, 'A) AÑO',     1, 1], [728, 62, 'B) HORA',     0, 0], [728, 62, 'C) MINUTO',   0, 0], [728, 62, 'D) SEGUNDO',  0, 0],
            [729, 62, 'A) OLOR',    0, 0], [729, 62, 'B) HOJA',     0, 0], [729, 62, 'C) PLANTA',   1, 1], [729, 62, 'D) ESPINA',   0, 0],
            [730, 62, 'A) NEGRO',   0, 0], [730, 62, 'B) ESCLAVITUD',1, 1], [730, 62, 'C) LIBRE',    0, 0], [730, 62, 'D) SUFRIR',   0, 0],
            [731, 62, 'A) CANTAR',  0, 0], [731, 62, 'B) ESTUVO',   1, 1], [731, 62, 'C) HABLANDO', 0, 0], [731, 62, 'D) CANTÓ',    0, 0],
            [732, 62, 'A) SEMANA',  0, 0], [732, 62, 'B) JUEVES',   0, 0], [732, 62, 'C) DÍA',      0, 0], [732, 62, 'D) SÁBADO',   1, 1],
            [733, 62, 'A) BOTELLA', 0, 0], [733, 62, 'B) PESO',     0, 0], [733, 62, 'C) LIGERO',   1, 1], [733, 62, 'D) FLOTAR',   0, 0],
            [734, 62, 'A) TRISTEZA',1, 1], [734, 62, 'B) SUERTE',   0, 0], [734, 62, 'C) FRACASAR', 0, 0], [734, 62, 'D) TRABAJO',  0, 0],
            [735, 62, 'A) LOBO',    1, 1], [735, 62, 'B) LADRIDO',  0, 0], [735, 62, 'C) MORDIDA',  0, 0], [735, 62, 'D) AGARRAR',  0, 0],
            [736, 62, 'A) SIETE',    0, 0], [736, 62, 'B) CUARENTA Y CINCO', 0, 0], [736, 62, 'C) TREINTA Y CINCO', 0, 0], [736, 62, 'D) VEINTICINCO', 1, 1],
            [737, 62, 'A) MUERTE',  0, 0], [737, 62, 'B) ALEGRE',   1, 1], [737, 62, 'C) MORTAJA',  0, 0], [737, 62, 'D) DOCTOR',   0, 0],
            [738, 62, 'A) COMER',   0, 0], [738, 62, 'B) PÁJARO',   0, 0], [738, 62, 'C) VIDA',     1, 1], [738, 62, 'D) MALO',     0, 0],
            [739, 62, 'A) 18',      0, 0], [739, 62, 'B) 27',       1, 1], [739, 62, 'C) 36',       0, 0], [739, 62, 'D) 45',       0, 0],
            [740, 62, 'A) BEBER',   0, 0], [740, 62, 'B) CLARO',    0, 0], [740, 62, 'C) SED',      1, 1], [740, 62, 'D) PURO',     0, 0],
            [741, 62, 'A) ESTOS',   0, 0], [741, 62, 'B) AQUEL',    0, 0], [741, 62, 'C) ESE',      1, 1], [741, 62, 'D) ENTONCES', 0, 0],
            [742, 62, 'A) AGUA',    0, 0], [742, 62, 'B) PEZ',      0, 0], [742, 62, 'C) ESCAMA',   1, 1], [742, 62, 'D) NADAR',    0, 0],
            [743, 62, 'A) PATRIA',  0, 0], [743, 62, 'B) HONRADO',  1, 1], [743, 62, 'C) SANCIÓN',  0, 0], [743, 62, 'D) ESTUDIO',  0, 0],
            [744, 62, 'A) TERCERO', 0, 0], [744, 62, 'B) ÚLTIMO',   0, 0], [744, 62, 'C) CUARTO',   1, 1], [744, 62, 'D) POSTERIOR',0, 0],
            [745, 62, 'A) MARINA',  0, 0], [745, 62, 'B) SOLDADO',  0, 0], [745, 62, 'C) GENERAL',  1, 1], [745, 62, 'D) SARGENTO', 0, 0],
            [746, 62, 'A) PRONOMBRE',0, 0],[746, 62, 'B) ADVERBIO',  0, 0], [746, 62, 'C) VERBO',    1, 1], [746, 62, 'D) ADJETIVO', 0, 0],

// ════════════════════════════════════════════════
// SERIE VIII — Competence 63 (Ordenamiento)
// ════════════════════════════════════════════════
            [747, 63, 'VERDADERO', 1, 1], [747, 63, 'FALSO', 0, 0],
            [748, 63, 'VERDADERO', 0, 0], [748, 63, 'FALSO', 1, 1],
            [749, 63, 'VERDADERO', 1, 1], [749, 63, 'FALSO', 0, 0],
            [750, 63, 'VERDADERO', 1, 1], [750, 63, 'FALSO', 0, 0],
            [751, 63, 'VERDADERO', 1, 1], [751, 63, 'FALSO', 0, 0],
            [752, 63, 'VERDADERO', 0, 0], [752, 63, 'FALSO', 1, 1],
            [753, 63, 'VERDADERO', 0, 0], [753, 63, 'FALSO', 1, 1],
            [754, 63, 'VERDADERO', 1, 1], [754, 63, 'FALSO', 0, 0],
            [755, 63, 'VERDADERO', 1, 1], [755, 63, 'FALSO', 0, 0],
            [756, 63, 'VERDADERO', 0, 0], [756, 63, 'FALSO', 1, 1],
            [757, 63, 'VERDADERO', 0, 0], [757, 63, 'FALSO', 1, 1],
            [758, 63, 'VERDADERO', 0, 0], [758, 63, 'FALSO', 1, 1],
            [759, 63, 'VERDADERO', 1, 1], [759, 63, 'FALSO', 0, 0],
            [760, 63, 'VERDADERO', 1, 1], [760, 63, 'FALSO', 0, 0],
            [761, 63, 'VERDADERO', 1, 1], [761, 63, 'FALSO', 0, 0],
            [762, 63, 'VERDADERO', 1, 1], [762, 63, 'FALSO', 0, 0],
            [763, 63, 'VERDADERO', 0, 0], [763, 63, 'FALSO', 1, 1],

// ════════════════════════════════════════════════
// SERIE IX — Competence 64 (Clasificación)
// ════════════════════════════════════════════════
            [764, 64, 'A) SALTAR',    0, 0], [764, 64, 'B) CORRER',     0, 0], [764, 64, 'C) BRINCAR',    0, 0], [764, 64, 'D) PARARSE',    1, 1], [764, 64, 'E) CAMINAR',    0, 0],
            [765, 64, 'A) MONARQUÍA', 0, 0], [765, 64, 'B) COMUNISTA',  0, 0], [765, 64, 'C) DEMÓCRATA',  0, 0], [765, 64, 'D) ANARQUISTA', 0, 0], [765, 64, 'E) CATÓLICO',   1, 1],
            [766, 64, 'A) MUERTE',    0, 0], [766, 64, 'B) DUELO',      0, 0], [766, 64, 'C) PASEO',      1, 1], [766, 64, 'D) POBREZA',    0, 0], [766, 64, 'E) TRISTEZA',   0, 0],
            [767, 64, 'A) CARPINTERO',1, 1], [767, 64, 'B) DOCTOR',     0, 0], [767, 64, 'C) ABOGADO',    0, 0], [767, 64, 'D) INGENIERO',  0, 0], [767, 64, 'E) PROFESOR',   0, 0],
            [768, 64, 'A) CAMA',      0, 0], [768, 64, 'B) SILLA',      0, 0], [768, 64, 'C) PLATO',      1, 1], [768, 64, 'D) SOPA',       0, 0], [768, 64, 'E) MESA',       0, 0],
            [769, 64, 'A) FRANCISCO', 0, 0], [769, 64, 'B) SANTIAGO',   0, 0], [769, 64, 'C) JUAN',       0, 0], [769, 64, 'D) SARA',       1, 1], [769, 64, 'E) GUILLÉN',    0, 0],
            [770, 64, 'A) DURO',      0, 0], [770, 64, 'B) ÁSPERO',     0, 0], [770, 64, 'C) LISO',       0, 0], [770, 64, 'D) SUAVE',      0, 0], [770, 64, 'E) DULCE',      1, 1],
            [771, 64, 'A) DIGESTIVO', 1, 1], [771, 64, 'B) ODIO',       0, 0], [771, 64, 'C) VISTA',      0, 0], [771, 64, 'D) OLFATO',     0, 0], [771, 64, 'E) TACTO',      0, 0],
            [772, 64, 'A) AUTOMÓVIL', 0, 0], [772, 64, 'B) BICICLETA',  0, 0], [772, 64, 'C) GUAYÍN',     0, 0], [772, 64, 'D) TELÉGRAFO',  1, 1], [772, 64, 'E) TREN',       0, 0],
            [773, 64, 'A) ABAJO',     0, 0], [773, 64, 'B) ACÁ',        0, 0], [773, 64, 'C) RECIENTE',   1, 1], [773, 64, 'D) ARRIBA',     0, 0], [773, 64, 'E) ALLÁ',       0, 0],
            [774, 64, 'A) HIDALGO',   0, 0], [774, 64, 'B) MORELOS',    0, 0], [774, 64, 'C) BRAVO',      0, 0], [774, 64, 'D) MATAMOROS',  0, 0], [774, 64, 'E) BOLÍVAR',    1, 1],
            [775, 64, 'A) DANÉS',     0, 0], [775, 64, 'B) GALGO',      0, 0], [775, 64, 'C) BULLDOG',    0, 0], [775, 64, 'D) PEKINÉS',    0, 0], [775, 64, 'E) LONGHORI',   1, 1],
            [776, 64, 'A) TELA',      1, 1], [776, 64, 'B) ALGODÓN',    0, 0], [776, 64, 'C) LINO',       0, 0], [776, 64, 'D) SEDA',       0, 0], [776, 64, 'E) LANA',       0, 0],
            [777, 64, 'A) IRA',       0, 0], [777, 64, 'B) ODIO',       0, 0], [777, 64, 'C) ALEGRÍA',    0, 0], [777, 64, 'D) PIEDAD',     0, 0], [777, 64, 'E) RAZONAMIENTO',1, 1],
            [778, 64, 'A) EDISON',    0, 0], [778, 64, 'B) FRANKLIN',   0, 0], [778, 64, 'C) MARCONI',    0, 0], [778, 64, 'D) FULTON',     0, 0], [778, 64, 'E) SHAKESPEARE', 1, 1],
            [779, 64, 'A) MARIPOSA',  1, 1], [779, 64, 'B) HALCÓN',     0, 0], [779, 64, 'C) AVESTRUZ',   0, 0], [779, 64, 'D) PETIRROJO',  0, 0], [779, 64, 'E) GOLONDRINA', 0, 0],
            [780, 64, 'A) DAR',       0, 0], [780, 64, 'B) PRESTAR',    0, 0], [780, 64, 'C) PERDER',     0, 0], [780, 64, 'D) AHORRAR',    1, 1], [780, 64, 'E) DERROCHAR',  0, 0],
            [781, 64, 'A) AUSTRALIA', 0, 0], [781, 64, 'B) CUBA',       0, 0], [781, 64, 'C) CÓRCEGA',    0, 0], [781, 64, 'D) IRLANDA',    0, 0], [781, 64, 'E) ESPAÑA',     1, 1],

// ════════════════════════════════════════════════
// SERIE X — Competence 65 (Series Numéricas)
// ════════════════════════════════════════════════
            [782, 65, 'A) 3 – 2',   0, 0], [782, 65, 'B) 2 – 1',   1, 1], [782, 65, 'C) 1 – 0',   0, 0], [782, 65, 'D) 2 – 0',   0, 0], [782, 65, 'E) 4 – 3',   0, 0],
            [783, 65, 'A) 34 – 38', 0, 0], [783, 65, 'B) 31 – 36', 0, 0], [783, 65, 'C) 32 – 37', 0, 0], [783, 65, 'D) 33 – 38', 1, 1], [783, 65, 'E) 36 – 39', 0, 0],
            [784, 65, 'A) 48 – 96', 0, 0], [784, 65, 'B) 56 – 112',0, 0], [784, 65, 'C) 64 – 128',1, 1], [784, 65, 'D) 72 – 144',0, 0], [784, 65, 'E) 80 – 160',0, 0],
            [785, 65, 'A) 3 – 3',   0, 0], [785, 65, 'B) 2 – 4',   0, 0], [785, 65, 'C) 4 – 2',   0, 0], [785, 65, 'D) 1 – 1',   0, 0], [785, 65, 'E) 2 – 2',   1, 1],
            [786, 65, 'A) 13 – 13',     0, 0], [786, 65, 'B) 12¾ – 13',  0, 0], [786, 65, 'C) 13 – 13¼',  1, 1], [786, 65, 'D) 13¼ – 13½', 0, 0], [786, 65, 'E) 12½ – 13',  0, 0],
            [787, 65, 'A) 20 – 21', 1, 1], [787, 65, 'B) 19 – 20', 0, 0], [787, 65, 'C) 23 – 24', 0, 0], [787, 65, 'D) 21 – 22', 0, 0], [787, 65, 'E) 18 – 19', 0, 0],
            [788, 65, 'A) ½ – ¼',   0, 0], [788, 65, 'B) ¼ – 1/16',0, 0], [788, 65, 'C) ¼ – ⅛',   1, 1], [788, 65, 'D) ⅛ – 1/16',0, 0], [788, 65, 'E) 1/16 – 1/32', 0, 0],
            [789, 65, 'A) 83.3 – 92.3', 0, 0], [789, 65, 'B) 84.3 – 93.3', 0, 0], [789, 65, 'C) 82.3 – 94.3', 0, 0], [789, 65, 'D) 86.3 – 95.3', 0, 0], [789, 65, 'E) 85.3 – 94.3', 1, 1]
        ];
*/

        //CORRECTO PARA POSTGREESQL
        $answers = [
            // ════════════════════════════════════════════════
            // SERIE I — Competence 56 (Información)
            // ════════════════════════════════════════════════
            [617, 56, 'A) GRANO',        0, 0],
            [617, 56, 'B) PETRÓLEO',     1, 1],
            [617, 56, 'C) TREMENTINA',   0, 0],
            [617, 56, 'D) SEMILLAS',     0, 0],

            [618, 56, 'A) 1000 KILOGRAMOS',   1, 1],
            [618, 56, 'B) 2000 KILOGRAMOS',   0, 0],
            [618, 56, 'C) 3000 KILOGRAMOS',   0, 0],
            [618, 56, 'D) 4000 KILOGRAMOS',   0, 0],

            [619, 56, 'A) MAZATLÁN',   0, 0],
            [619, 56, 'B) VERACRUZ',   1, 1],
            [619, 56, 'C) PROGRESO',   0, 0],
            [619, 56, 'D) ACAPULCO',   0, 0],

            [620, 56, 'A) VER',     1, 1],
            [620, 56, 'B) OÍR',     0, 0],
            [620, 56, 'C) PROBAR',  0, 0],
            [620, 56, 'D) SENTIR',  0, 0],

            [621, 56, 'A) CORTEZA', 0, 0],
            [621, 56, 'B) FRUTO',   1, 1],
            [621, 56, 'C) HOJAS',   0, 0],
            [621, 56, 'D) RAÍZ',    0, 0],

            [622, 56, 'A) CARNERO',  0, 0],
            [622, 56, 'B) VACA',     0, 0],
            [622, 56, 'C) GALLINA',  0, 0],
            [622, 56, 'D) CERDO',    1, 1],

            [623, 56, 'A) ABDOMEN',   0, 0],
            [623, 56, 'B) CABEZA',    0, 0],
            [623, 56, 'C) GARGANTA',  1, 1],
            [623, 56, 'D) ESPALDA',   0, 0],

            [624, 56, 'A) MUERTE',      1, 1],
            [624, 56, 'B) ENFERMEDAD',  0, 0],
            [624, 56, 'C) FIEBRE',      0, 0],
            [624, 56, 'D) MALESTAR',    0, 0],

            [625, 56, 'A) PERFORAR', 0, 0],
            [625, 56, 'B) CORTAR',   0, 0],
            [625, 56, 'C) LEVANTAR', 1, 1],
            [625, 56, 'D) EXPRIMIR', 0, 0],

            [626, 56, 'A) PENTÁGONO',        0, 0],
            [626, 56, 'B) PARALELOGRAMO',    0, 0],
            [626, 56, 'C) HEXÁGONO',         1, 1],
            [626, 56, 'D) TRAPECIO',         0, 0],

            [627, 56, 'A) LLUVIA',       0, 0],
            [627, 56, 'B) VIENTO',       0, 0],
            [627, 56, 'C) ELECTRICIDAD', 1, 1],
            [627, 56, 'D) PRESIÓN',      0, 0],

            [628, 56, 'A) AGRICULTURA',  0, 0],
            [628, 56, 'B) MÚSICA',       1, 1],
            [628, 56, 'C) FOTOGRAFÍA',   0, 0],
            [628, 56, 'D) ESTENOGRAFÍA', 0, 0],

            [629, 56, 'A) AZULES',    0, 0],
            [629, 56, 'B) VERDES',    1, 1],
            [629, 56, 'C) ROJAS',     0, 0],
            [629, 56, 'D) AMARILLAS', 0, 0],

            [630, 56, 'A) PIE',     0, 0],
            [630, 56, 'B) PULGADA', 0, 0],
            [630, 56, 'C) YARDA',   1, 1],
            [630, 56, 'D) MILLA',   0, 0],

            [631, 56, 'A) ANIMALES', 1, 1],
            [631, 56, 'B) HIERBAS',  0, 0],
            [631, 56, 'C) BOSQUES',  0, 0],
            [631, 56, 'D) MINAS',    0, 0],

            [632, 56, 'A) MEDICINA',   0, 0],
            [632, 56, 'B) TEOLOGÍA',   0, 0],
            [632, 56, 'C) LEYES',      1, 1],
            [632, 56, 'D) PEDAGOGÍA',  0, 0],

            // ════════════════════════════════════════════════
            // SERIE II — Competence 57 (Juicio)
            // ════════════════════════════════════════════════
            [633, 57, 'A) LAS ESTRELLAS DESAPARECERÍAN.',         0, 0],
            [633, 57, 'B) LOS MESES SERÍAN MÁS LARGOS.',          0, 0],
            [633, 57, 'C) LA TIERRA ESTARÍA MÁS CALIENTE.',       1, 1],

            [634, 57, 'A) EL NOGAL ES FUERTE.',              1, 1],
            [634, 57, 'B) SE CORTA FÁCILMENTE.',             0, 0],
            [634, 57, 'C) SUS FRENOS NO SON BUENOS.',        0, 0],

            [635, 57, 'A) TIENE MÁS RUEDA.',         0, 0],
            [635, 57, 'B) ES MÁS PESADO.',            1, 1],
            [635, 57, 'C) SUS FRENOS NO SON BUENOS.', 0, 0],

            [636, 57, 'A) QUE LOS ROBLES SON DÉBILES.',                                    0, 0],
            [636, 57, 'B) QUE SON MEJORES LOS GOLPES PEQUEÑOS.',                           0, 0],
            [636, 57, 'C) QUE EL ESFUERZO CONSTANTE LOGRA RESULTADOS SORPRENDENTES.',      1, 1],

            [637, 57, 'A) QUE NO DEBEMOS VIGILARLA CUANDO ESTÉ EN EL FUEGO.',  0, 0],
            [637, 57, 'B) QUE TARDA EN HERVIR.',                                0, 0],
            [637, 57, 'C) QUE EL TIEMPO SE ALARGA CUANDO ESPERAMOS.',           1, 1],

            [638, 57, 'A) QUE EL PASTO SE SIEMBRA EN EL VERANO.',              0, 0],
            [638, 57, 'B) QUE DEBEMOS APROVECHAR NUESTRAS OPORTUNIDADES.',     1, 1],
            [638, 57, 'C) QUE EL PASTO NO DEBE CORTARSE EN LA NOCHE.',         0, 0],

            [639, 57, 'A) QUE UN ZAPATERO NO DEBE ABANDONAR SUS ZAPATOS.',         0, 0],
            [639, 57, 'B) QUE LOS ZAPATEROS NO DEBEN ESTAR OCIOSOS.',              0, 0],
            [639, 57, 'C) QUE DEBEMOS TRABAJAR EN LO QUE PODEMOS HACER MEJOR.',   1, 1],

            [640, 57, 'A) QUE EL PALO SIRVE PARA APRETAR.',                    0, 0],
            [640, 57, 'B) QUE LAS CUÑAS SIEMPRE SON DE MADERA.',               0, 0],
            [640, 57, 'C) NOS EXIGEN MÁS LAS PERSONAS QUE NOS CONOCEN.',       1, 1],

            [641, 57, 'A) LA MAQUINA LO HACE FLOTAR.',             0, 0],
            [641, 57, 'B) PORQUE TIENE GRANDES ESPACIOS HUECOS.',  1, 1],
            [641, 57, 'C) CONTIENE ALGO DE MADERA.',               0, 0],

            [642, 57, 'A) LAS ALAS OFRECEN UNA AMPLIA SUPERFICIE LIGERA.',  1, 1],
            [642, 57, 'B) MANTIENEN EL AIRE FUERA DEL CUERPO.',             0, 0],
            [642, 57, 'C) DISMINUYEN SU PESO.',                             0, 0],

            [643, 57, 'A) QUE LAS GOLONDRINAS REGRESAN.',                              0, 0],
            [643, 57, 'B) QUE UN SIMPLE DATO NO ES SUFICIENTE.',                       1, 1],
            [643, 57, 'C) QUE LOS PÁJAROS SE AGREGAN A NUESTROS PLACERES DE VERANO.', 0, 0],

            // ════════════════════════════════════════════════
            // SERIE III — Competence 58 (Vocabulario: I / O)
            // ════════════════════════════════════════════════
            [644, 58, 'I', 0, 0], [644, 58, 'O', 1, 1],   // SALADO – DULCE → Opuesto
            [645, 58, 'I', 1, 1], [645, 58, 'O', 0, 0],   // ALEGRE – REGOCIJARSE → Igual
            [646, 58, 'I', 0, 0], [646, 58, 'O', 1, 1],   // MAYOR – MENOR → Opuesto
            [647, 58, 'I', 0, 0], [647, 58, 'O', 1, 1],   // SENTARSE – PARARSE → Opuesto
            [648, 58, 'I', 0, 0], [678, 58, 'O', 1, 1],   // DESPERDICIAR – APROVECHAR → Opuesto
            [649, 58, 'I', 0, 0], [649, 58, 'O', 1, 1],   // CONOCER – NEGAR → Opuesto
            [650, 58, 'I', 1, 1], [650, 58, 'O', 0, 0],   // TÓNICO – ESTIMULAR → Igual
            [651, 58, 'I', 1, 1], [651, 58, 'O', 0, 0],   // REBAJAR – DENIGRAR → Igual
            [652, 58, 'I', 0, 0], [652, 58, 'O', 1, 1],   // PROHIBIR – PERMITIR → Opuesto
            [653, 58, 'I', 1, 1], [653, 58, 'O', 0, 0],   // OSADO – AUDAZ → Igual
            [654, 58, 'I', 0, 0], [654, 58, 'O', 1, 1],   // ARREBATADO – PRUDENTE → Opuesto
            [655, 58, 'I', 0, 0], [655, 58, 'O', 1, 1],   // OBTUSO – AGUDO → Opuesto
            [656, 58, 'I', 0, 0], [656, 58, 'O', 1, 1],   // INEPTO – EXPERTO → Opuesto
            [657, 58, 'I', 1, 1], [657, 58, 'O', 0, 0],   // ESQUIVAR – REHUIR → Igual
            [658, 58, 'I', 0, 0], [658, 58, 'O', 1, 1],   // REVELARSE – SOMETERSE → Opuesto
            [659, 58, 'I', 0, 0], [659, 58, 'O', 1, 1],   // MONOTONÍA – VARIEDAD → Opuesto
            [660, 58, 'I', 1, 1], [660, 58, 'O', 0, 0],   // CONFORTAR – CONSOLAR → Igual
            [661, 58, 'I', 0, 0], [661, 58, 'O', 1, 1],   // EXPELER – RETENER → Opuesto
            [662, 58, 'I', 1, 1], [662, 58, 'O', 0, 0],   // DÓCIL – SUMISO → Igual
            [663, 58, 'I', 0, 0], [663, 58, 'O', 1, 1],   // TRANSITORIO – PERMANENTE → Opuesto
            [664, 58, 'I', 0, 0], [664, 58, 'O', 1, 1],   // SEGURIDAD – RIESGO → Opuesto
            [665, 58, 'I', 0, 0], [665, 58, 'O', 1, 1],   // APROVECHAR – OBJETAR → Opuesto
            [666, 58, 'I', 1, 1], [666, 58, 'O', 0, 0],   // EXPELER – ARROJAR → Igual
            [667, 58, 'I', 1, 1], [667, 58, 'O', 0, 0],   // ENGAÑO – IMPOSTURA → Igual
            [668, 58, 'I', 1, 1], [668, 58, 'O', 0, 0],   // MITIGAR – APACIGUAR → Igual
            [669, 58, 'I', 0, 0], [669, 58, 'O', 1, 1],   // INICIATIVA – APLICAR → Opuesto
            [670, 58, 'I', 1, 1], [670, 58, 'O', 0, 0],   // REVERENCIA – VENERACIÓN → Igual
            [671, 58, 'I', 1, 1], [671, 58, 'O', 0, 0],   // SOBRIEDAD – FRUGALIDAD → Igual
            [672, 58, 'I', 0, 0], [672, 58, 'O', 1, 1],   // AUMENTAR – MENGUAR → Opuesto
            [673, 58, 'I', 1, 1], [673, 58, 'O', 0, 0],   // INCITAR – INSTIGAR → Igual

            // ════════════════════════════════════════════════
            // SERIE IV — Competence 59 (Síntesis: 2 correctas por pregunta)
            // ════════════════════════════════════════════════
            [674, 59, 'A) ALTURA - LONGITUD',         0, 0],
            [674, 59, 'B) CIRCUNFERENCIA - RADIO',    1, 1],
            [674, 59, 'C) LATITUD - RADIO',           0, 0],
            [674, 59, 'D) LONGITUD - CIRCUNFERENCIA', 0, 0],
            [674, 59, 'E) RADIO - ALTURA',            0, 0],

            [675, 59, 'A) HUESOS - CANTO',   0, 0],
            [675, 59, 'B) HUEVOS - PLUMAS',  0, 0],
            [675, 59, 'C) PICO - HUESOS',    1, 1],
            [675, 59, 'D) NIDO - HUEVOS',    0, 0],
            [675, 59, 'E) CANTO - PLUMAS',   0, 0],

            [676, 59, 'A) OYENTE - PIANO',   0, 0],
            [676, 59, 'B) PIANO - VIOLÍN',   0, 0],
            [676, 59, 'C) RITMO - SONIDO',   1, 1],
            [676, 59, 'D) SONIDO - OYENTE',  0, 0],
            [676, 59, 'E) VIOLÍN - ACORDES', 0, 0],

            [677, 59, 'A) ALIMENTO - DISCURSO',  0, 0],
            [677, 59, 'B) MÚSICA - ANFITRIÓN',   0, 0],
            [677, 59, 'C) PERSONAS - ALIMENTO',  1, 1],
            [677, 59, 'D) DISCURSO - PERSONAS',  0, 0],
            [677, 59, 'E) ANFITRIÓN - ALIMENTO', 0, 0],

            [678, 59, 'A) ARNÉS - ESTABLO',      0, 0],
            [678, 59, 'B) CASCOS - COLA',        1, 1],
            [678, 59, 'C) HERRADURAS - CASCO',   0, 0],
            [678, 59, 'D) ESTABLO - HERRADURAS', 0, 0],
            [678, 59, 'E) COLA - ARNÉS',         0, 0],

            [679, 59, 'A) CARTAS - JUGADORES',   0, 0],
            [679, 59, 'B) MULTAS - REGLAS',      0, 0],
            [679, 59, 'C) JUGADORES - REGLAS',   1, 1],
            [679, 59, 'D) CASTIGOS - CARTAS',    0, 0],
            [679, 59, 'E) REGLAS - CASTIGOS',    0, 0],

            [680, 59, 'A) COLOR - PESO',   0, 0],
            [680, 59, 'B) TAMAÑO - SABOR', 0, 0],
            [680, 59, 'C) SABOR - COLOR',  0, 0],
            [680, 59, 'D) VALOR - TAMAÑO', 0, 0],
            [680, 59, 'E) PESO - TAMAÑO',  1, 1],

            [681, 59, 'A) ACUERDOS - PERSONAS',  0, 0],
            [681, 59, 'B) PERSONAS - PALABRAS',  1, 1],
            [681, 59, 'C) PREGUNTAS - INGENIO',  0, 0],
            [681, 59, 'D) INGENIO - ACUERDOS',   0, 0],
            [681, 59, 'E) PALABRAS - INGENIO',   0, 0],

            [682, 59, 'A) ACREEDOR - DEUDOR',    1, 1],
            [682, 59, 'B) DEUDOR - PAGO',        0, 0],
            [682, 59, 'C) INTERÉS - ACREEDOR',   0, 0],
            [682, 59, 'D) HIPOTECA - PAGO',      0, 0],
            [682, 59, 'E) PAGO - INTERÉS',       0, 0],

            [683, 59, 'A) PAÍS - DERECHOS',      1, 1],
            [683, 59, 'B) OCUPACIÓN - PAÍS',     0, 0],
            [683, 59, 'C) DERECHOS - VOTO',      0, 0],
            [683, 59, 'D) PROPIEDAD - DERECHOS', 0, 0],
            [683, 59, 'E) VOTO - PAÍS',          0, 0],

            [684, 59, 'A) ANIMALES - MINERALES',    0, 0],
            [684, 59, 'B) ORDEN - COLECCIONES',     1, 1],
            [684, 59, 'C) COLECCIONES - VISITANTES',0, 0],
            [684, 59, 'D) MINERALES - COLECCIONES', 0, 0],
            [684, 59, 'E) VISITANTES - ORDEN',      0, 0],

            [685, 59, 'A) OBLIGACIÓN - ACUERDO',  1, 1],
            [685, 59, 'B) ACUERDO - RESPETO',     0, 0],
            [685, 59, 'C) AMISTAD - OBLIGACIÓN',  0, 0],
            [685, 59, 'D) RESPETO - AMISTAD',     0, 0],
            [685, 59, 'E) SATISFACCIÓN - OBLIGACIÓN', 0, 0],

            [686, 59, 'A) ANIMALES - MALEZA',   0, 0],
            [686, 59, 'B) FLORES - SOMBRAS',    0, 0],
            [686, 59, 'C) SOMBRAS - ÁRBOLES',   1, 1],
            [686, 59, 'D) MALEZA - FLORES',     0, 0],
            [686, 59, 'E) ÁRBOLES - ANIMALES',  0, 0],

            [687, 59, 'A) DIFICULTAD - FRACASO',       0, 0],
            [687, 59, 'B) DESALIENTO - IMPEDIMENTO',   0, 0],
            [687, 59, 'C) FRACASO - ESTÍMULO',         0, 0],
            [687, 59, 'D) IMPEDIMENTO - DIFICULTAD',   1, 1],
            [687, 59, 'E) ESTÍMULO - DESALIENTO',      0, 0],

            [688, 59, 'A) AVERSIÓN - DESAGRADO',  1, 1],
            [688, 59, 'B) DESAGRADO - TEMOR',     0, 0],
            [688, 59, 'C) TEMOR - IRA',           0, 0],
            [688, 59, 'D) IRA - AVERSIÓN',        0, 0],
            [688, 59, 'E) TIMIDEZ - DESAGRADO',   0, 0],

            [689, 59, 'A) ANUNCIOS - PAPEL',       0, 0],
            [689, 59, 'B) PAPEL - IMPRESIÓN',      1, 1],
            [689, 59, 'C) FOTOGRAFÍAS - ANUNCIOS', 0, 0],
            [689, 59, 'D) GRABADOS - IMPRESIÓN',   0, 0],
            [689, 59, 'E) IMPRESIÓN - FOTOGRAFÍAS',0, 0],

            [690, 59, 'A) ARGUMENTO - PÚBLICO',      0, 0],
            [690, 59, 'B) DESACUERDOS - ARGUMENTO',  1, 1],
            [690, 59, 'C) AVERSIÓN - RESUMEN',       0, 0],
            [690, 59, 'D) PÚBLICO - DESACUERDO',     0, 0],
            [690, 59, 'E) RESUMEN - ARGUMENTO',      0, 0],

            [691, 59, 'A) MAQUINARIA - CAÑONES', 0, 0],
            [691, 59, 'B) CAÑONES - VELAS',      0, 0],
            [691, 59, 'C) QUILLA - MAQUINARIA',  0, 0],
            [691, 59, 'D) TIMÓN - QUILLA',       1, 1],
            [691, 59, 'E) VELAS - TIMÓN',        0, 0],

            // ════════════════════════════════════════════════
            // SERIE V — Competence 60 (Concentración / Aritmética)
            // ════════════════════════════════════════════════
            [692, 60, 'A) 30', 0, 0], [692, 60, 'B) 15', 0, 0], [692, 60, 'C) 20', 1, 1], [692, 60, 'D) 25', 0, 0], [692, 60, 'E) 18', 0, 0],
            [693, 60, 'A) 7',  0, 0], [693, 60, 'B) 10', 0, 0], [693, 60, 'C) 15', 0, 0], [693, 60, 'D) 11', 1, 1], [693, 60, 'E) 13', 0, 0],
            [694, 60, 'A) 38', 0, 0], [694, 60, 'B) 45', 0, 0], [694, 60, 'C) 60', 0, 0], [694, 60, 'D) 55', 0, 0], [694, 60, 'E) 50', 1, 1],
            [695, 60, 'A) 25', 0, 0], [695, 60, 'B) 50', 1, 1], [695, 60, 'C) 75', 0, 0], [695, 60, 'D) 100',0, 0], [695, 60, 'E) 150',0, 0],
            [696, 60, 'A) 12', 1, 1], [696, 60, 'B) 8',  0, 0], [696, 60, 'C) 10', 0, 0], [696, 60, 'D) 19', 0, 0], [696, 60, 'E) 16', 0, 0],
            [697, 60, 'A) 12', 0, 0], [697, 60, 'B) 16', 0, 0], [697, 60, 'C) 18', 1, 1], [697, 60, 'D) 20', 0, 0], [697, 60, 'E) 24', 0, 0],
            [698, 60, 'A) 300',0, 0], [698, 60, 'B) 500',1, 1], [698, 60, 'C) 180',0, 0], [698, 60, 'D) 700',0, 0], [698, 60, 'E) 243',0, 0],
            [699, 60, 'A) 1',  0, 0], [699, 60, 'B) 6',  0, 0], [699, 60, 'C) 2',  1, 1], [699, 60, 'D) 4',  0, 0], [699, 60, 'E) 8',  0, 0],
            [700, 60, 'A) 14', 0, 0], [700, 60, 'B) 21', 0, 0], [700, 60, 'C) 24', 0, 0], [700, 60, 'D) 28', 1, 1], [700, 60, 'E) 32', 0, 0],
            [701, 60, 'A) 360',1, 1], [701, 60, 'B) 320',0, 0], [701, 60, 'C) 340',0, 0], [701, 60, 'D) 325',0, 0], [701, 60, 'E) 380',0, 0],
            [702, 60, 'A) 1',  0, 0], [702, 60, 'B) 2',  1, 1], [702, 60, 'C) 3',  0, 0], [702, 60, 'D) 4',  0, 0], [702, 60, 'E) 5',  0, 0],
            [703, 60, 'A) 18%',0, 0], [703, 60, 'B) 15%',0, 0], [703, 60, 'C) 20%',0, 0], [703, 60, 'D) 28%',0, 0], [703, 60, 'E) 25%',1, 1],

            // ════════════════════════════════════════════════
            // SERIE VI — Competence 61 (Análisis: Sí / No)
            // ════════════════════════════════════════════════
            [704, 61, 'Sí', 1, 1], [704, 61, 'No', 0, 0],
            [705, 61, 'Sí', 0, 0], [705, 61, 'No', 1, 1],
            [706, 61, 'Sí', 0, 0], [706, 61, 'No', 1, 1],
            [707, 61, 'Sí', 1, 1], [707, 61, 'No', 0, 0],
            [708, 61, 'Sí', 1, 1], [708, 61, 'No', 0, 0],
            [709, 61, 'Sí', 0, 0], [709, 61, 'No', 1, 1],
            [710, 61, 'Sí', 0, 0], [710, 61, 'No', 1, 1],
            [711, 61, 'Sí', 0, 0], [711, 61, 'No', 1, 1],
            [712, 61, 'Sí', 1, 1], [712, 61, 'No', 0, 0],
            [713, 61, 'Sí', 1, 1], [713, 61, 'No', 0, 0],
            [714, 61, 'Sí', 0, 0], [714, 61, 'No', 1, 1],
            [715, 61, 'Sí', 0, 0], [715, 61, 'No', 1, 1],
            [716, 61, 'Sí', 0, 0], [716, 61, 'No', 1, 1],
            [717, 61, 'Sí', 1, 1], [717, 61, 'No', 0, 0],
            [718, 61, 'Sí', 0, 0], [718, 61, 'No', 1, 1],
            [719, 61, 'Sí', 0, 0], [719, 61, 'No', 1, 1],
            [720, 61, 'Sí', 1, 1], [720, 61, 'No', 0, 0],
            [721, 61, 'Sí', 0, 0], [721, 61, 'No', 1, 1],
            [722, 61, 'Sí', 1, 1], [722, 61, 'No', 0, 0],
            [723, 61, 'Sí', 1, 1], [723, 61, 'No', 0, 0],

            // ════════════════════════════════════════════════
            // SERIE VII — Competence 62 (Abstracción / Analogías)
            // ════════════════════════════════════════════════
            [724, 62, 'A) COMER',    1, 1], [724, 62, 'B) HAMBRE',   0, 0], [724, 62, 'C) AGUA',     0, 0], [724, 62, 'D) COCINA',   0, 0],
            [725, 62, 'A) AÑO',     1, 1], [725, 62, 'B) HORA',     0, 0], [725, 62, 'C) MINUTO',   0, 0], [725, 62, 'D) SEGUNDO',  0, 0],
            [726, 62, 'A) OLOR',    0, 0], [726, 62, 'B) HOJA',     0, 0], [726, 62, 'C) PLANTA',   1, 1], [726, 62, 'D) ESPINA',   0, 0],
            [727, 62, 'A) NEGRO',   0, 0], [727, 62, 'B) ESCLAVITUD',1, 1], [727, 62, 'C) LIBRE',    0, 0], [727, 62, 'D) SUFRIR',   0, 0],
            [728, 62, 'A) CANTAR',  0, 0], [728, 62, 'B) ESTUVO',   1, 1], [728, 62, 'C) HABLANDO', 0, 0], [728, 62, 'D) CANTÓ',    0, 0],
            [729, 62, 'A) SEMANA',  0, 0], [729, 62, 'B) JUEVES',   0, 0], [729, 62, 'C) DÍA',      0, 0], [729, 62, 'D) SÁBADO',   1, 1],
            [730, 62, 'A) BOTELLA', 0, 0], [730, 62, 'B) PESO',     0, 0], [730, 62, 'C) LIGERO',   1, 1], [730, 62, 'D) FLOTAR',   0, 0],
            [731, 62, 'A) TRISTEZA',1, 1], [731, 62, 'B) SUERTE',   0, 0], [731, 62, 'C) FRACASAR', 0, 0], [731, 62, 'D) TRABAJO',  0, 0],
            [732, 62, 'A) LOBO',    1, 1], [732, 62, 'B) LADRIDO',  0, 0], [732, 62, 'C) MORDIDA',  0, 0], [732, 62, 'D) AGARRAR',  0, 0],
            [733, 62, 'A) SIETE',    0, 0], [733, 62, 'B) CUARENTA Y CINCO', 0, 0], [733, 62, 'C) TREINTA Y CINCO', 0, 0], [733, 62, 'D) VEINTICINCO', 1, 1],
            [734, 62, 'A) MUERTE',  0, 0], [734, 62, 'B) ALEGRE',   1, 1], [734, 62, 'C) MORTAJA',  0, 0], [734, 62, 'D) DOCTOR',   0, 0],
            [735, 62, 'A) COMER',   0, 0], [735, 62, 'B) PÁJARO',   0, 0], [735, 62, 'C) VIDA',     1, 1], [735, 62, 'D) MALO',     0, 0],
            [736, 62, 'A) 18',      0, 0], [736, 62, 'B) 27',       1, 1], [736, 62, 'C) 36',       0, 0], [736, 62, 'D) 45',       0, 0], // Corregido el elemento inicial de la pregunta (740 -> 736)
            [737, 62, 'A) BEBER',   0, 0], [737, 62, 'B) CLARO',    0, 0], [737, 62, 'C) SED',      1, 1], [737, 62, 'D) PURO',     0, 0],
            [738, 62, 'A) ESTOS',   0, 0], [738, 62, 'B) AQUEL',    0, 0], [738, 62, 'C) ESE',      1, 1], [738, 62, 'D) ENTONCES', 0, 0],
            [739, 62, 'A) AGUA',    0, 0], [739, 62, 'B) PEZ',      0, 0], [739, 62, 'C) ESCAMA',   1, 1], [739, 62, 'D) NADAR',    0, 0],
            [740, 62, 'A) PATRIA',  0, 0], [740, 62, 'B) HONRADO',  1, 1], [740, 62, 'C) SANCIÓN',  0, 0], [740, 62, 'D) ESTUDIO',  0, 0],
            [741, 62, 'A) TERCERO', 0, 0], [741, 62, 'B) ÚLTIMO',   0, 0], [741, 62, 'C) CUARTO',   1, 1], [741, 62, 'D) POSTERIOR',0, 0],
            [742, 62, 'A) MARINA',  0, 0], [742, 62, 'B) SOLDADO',  0, 0], [742, 62, 'C) GENERAL',  1, 1], [742, 62, 'D) SARGENTO', 0, 0],
            [743, 62, 'A) PRONOMBRE',0, 0],[743, 62, 'B) ADVERBIO',  0, 0], [743, 62, 'C) VERBO',    1, 1], [743, 62, 'D) ADJETIVO', 0, 0],

            // ════════════════════════════════════════════════
            // SERIE VIII — Competence 63 (Planeación: V / F)
            // ════════════════════════════════════════════════
            [744, 63, 'VERDADERO', 1, 1], [744, 63, 'FALSO', 0, 0],
            [745, 63, 'VERDADERO', 0, 0], [745, 63, 'FALSO', 1, 1],
            [746, 63, 'VERDADERO', 1, 1], [746, 63, 'FALSO', 0, 0],
            [747, 63, 'VERDADERO', 1, 1], [747, 63, 'FALSO', 0, 0],
            [748, 63, 'VERDADERO', 1, 1], [748, 63, 'FALSO', 0, 0],
            [749, 63, 'VERDADERO', 0, 0], [749, 63, 'FALSO', 1, 1],
            [750, 63, 'VERDADERO', 0, 0], [750, 63, 'FALSO', 1, 1],
            [751, 63, 'VERDADERO', 1, 1], [751, 63, 'FALSO', 0, 0],
            [752, 63, 'VERDADERO', 1, 1], [752, 63, 'FALSO', 0, 0],
            [753, 63, 'VERDADERO', 0, 0], [753, 63, 'FALSO', 1, 1],
            [754, 63, 'VERDADERO', 0, 0], [754, 63, 'FALSO', 1, 1],
            [755, 63, 'VERDADERO', 0, 0], [755, 63, 'FALSO', 1, 1],
            [756, 63, 'VERDADERO', 1, 1], [756, 63, 'FALSO', 0, 0],
            [757, 63, 'VERDADERO', 1, 1], [757, 63, 'FALSO', 0, 0],
            [758, 63, 'VERDADERO', 1, 1], [758, 63, 'FALSO', 0, 0],
            [759, 63, 'VERDADERO', 1, 1], [759, 63, 'FALSO', 0, 0],
            [760, 63, 'VERDADERO', 0, 0], [760, 63, 'FALSO', 1, 1],

            // ════════════════════════════════════════════════
            // SERIE IX — Competence 64 (Organización / Clasificación)
            // ════════════════════════════════════════════════
            [761, 64, 'A) SALTAR',    0, 0], [761, 64, 'B) CORRER',     0, 0], [761, 64, 'C) BRINCAR',    0, 0], [761, 64, 'D) PARARSE',    1, 1], [761, 64, 'E) CAMINAR',    0, 0],
            [762, 64, 'A) MONARQUÍA', 0, 0], [762, 64, 'B) COMUNISTA',  0, 0], [762, 64, 'C) DEMÓCRATA',  0, 0], [762, 64, 'D) ANARQUISTA', 0, 0], [762, 64, 'E) CATÓLICO',   1, 1],
            [763, 64, 'A) MUERTE',    0, 0], [763, 64, 'B) DUELO',      0, 0], [763, 64, 'C) PASEO',      1, 1], [763, 64, 'D) POBREZA',    0, 0], [763, 64, 'E) TRISTEZA',   0, 0],
            [764, 64, 'A) CARPINTERO',1, 1], [764, 64, 'B) DOCTOR',     0, 0], [764, 64, 'C) ABOGADO',    0, 0], [764, 64, 'D) INGENIERO',  0, 0], [764, 64, 'E) PROFESOR',   0, 0],
            [765, 64, 'A) CAMA',      0, 0], [765, 64, 'B) SILLA',      0, 0], [765, 64, 'C) PLATO',      1, 1], [765, 64, 'D) SOPA',       0, 0], [765, 64, 'E) MESA',       0, 0],
            [766, 64, 'A) FRANCISCO', 0, 0], [766, 64, 'B) SANTIAGO',   0, 0], [766, 64, 'C) JUAN',       0, 0], [766, 64, 'D) SARA',       1, 1], [766, 64, 'E) GUILLÉN',    0, 0], // Corregido el elemento inicial de la pregunta (770 -> 766)
            [767, 64, 'A) DURO',      0, 0], [767, 64, 'B) ÁSPERO',     0, 0], [767, 64, 'C) LISO',       0, 0], [767, 64, 'D) SUAVE',      0, 0], [767, 64, 'E) DULCE',      1, 1],
            [768, 64, 'A) DIGESTIVO', 1, 1], [768, 64, 'B) ODIO',       0, 0], [768, 64, 'C) VISTA',      0, 0], [768, 64, 'D) OLFATO',     0, 0], [768, 64, 'E) TACTO',      0, 0],
            [769, 64, 'A) AUTOMÓVIL', 0, 0], [769, 64, 'B) BICICLETA',  0, 0], [769, 64, 'C) GUAYÍN',     0, 0], [769, 64, 'D) TELÉGRAFO',  1, 1], [769, 64, 'E) TREN',       0, 0],
            [770, 64, 'A) ABAJO',     0, 0], [770, 64, 'B) ACÁ',        0, 0], [770, 64, 'C) RECIENTE',   1, 1], [770, 64, 'D) ARRIBA',     0, 0], [770, 64, 'E) ALLÁ',       0, 0],
            [771, 64, 'A) HIDALGO',   0, 0], [771, 64, 'B) MORELOS',    0, 0], [771, 64, 'C) BRAVO',      0, 0], [771, 64, 'D) MATAMOROS',  0, 0], [771, 64, 'E) BOLÍVAR',    1, 1],
            [772, 64, 'A) DANÉS',     0, 0], [772, 64, 'B) GALGO',      0, 0], [772, 64, 'C) BULLDOG',    0, 0], [772, 64, 'D) PEKINÉS',    0, 0], [772, 64, 'E) LONGHORI',   1, 1],
            [773, 64, 'A) TELA',      1, 1], [773, 64, 'B) ALGODÓN',    0, 0], [773, 64, 'C) LINO',       0, 0], [773, 64, 'D) SEDA',       0, 0], [773, 64, 'E) LANA',       0, 0],
            [774, 64, 'A) IRA',       0, 0], [774, 64, 'B) ODIO',       0, 0], [774, 64, 'C) ALEGRÍA',    0, 0], [774, 64, 'D) PIEDAD',     0, 0], [774, 64, 'E) RAZONAMIENTO',1, 1],
            [775, 64, 'A) EDISON',    0, 0], [775, 64, 'B) FRANKLIN',   0, 0], [775, 64, 'C) MARCONI',    0, 0], [775, 64, 'D) FULTON',     0, 0], [775, 64, 'E) SHAKESPEARE', 1, 1],
            [776, 64, 'A) MARIPOSA',  1, 1], [776, 64, 'B) HALCÓN',     0, 0], [776, 64, 'C) AVESTRUZ',   0, 0], [776, 64, 'D) PETIRROJO',  0, 0], [776, 64, 'E) GOLONDRINA', 0, 0],
            [777, 64, 'A) DAR',       0, 0], [777, 64, 'B) PRESTAR',    0, 0], [777, 64, 'C) PERDER',     0, 0], [777, 64, 'D) AHORRAR',    1, 1], [777, 64, 'E) DERROCHAR',  0, 0],
            [778, 64, 'A) AUSTRALIA', 0, 0], [778, 64, 'B) CUBA',       0, 0], [778, 64, 'C) CÓRCEGA',    0, 0], [778, 64, 'D) IRLANDA',    0, 0], [778, 64, 'E) ESPAÑA',     1, 1],

            // ════════════════════════════════════════════════
            // SERIE X — Competence 65 (Anticipación / Series numéricas)
            // ════════════════════════════════════════════════
            // ════════════════════════════════════════════════
            // SERIE X — Competence 65 (Anticipación / Series numéricas)
            // ════════════════════════════════════════════════
            [779, 65, 'A) 3 – 2',   0, 0], [779, 65, 'B) 2 – 1',   1, 1], [779, 65, 'C) 1 – 0',   0, 0], [779, 65, 'D) 2 – 0',   0, 0], [779, 65, 'E) 4 – 3',   0, 0],
            [780, 65, 'A) 34 – 38', 0, 0], [780, 65, 'B) 31 – 36', 0, 0], [780, 65, 'C) 32 – 37', 0, 0], [780, 65, 'D) 33 – 38', 1, 1], [780, 65, 'E) 36 – 39', 0, 0],
            [781, 65, 'A) 48 – 96', 0, 0], [781, 65, 'B) 56 – 112',0, 0], [781, 65, 'C) 64 – 128',1, 1], [781, 65, 'D) 72 – 144',0, 0], [781, 65, 'E) 80 – 160',0, 0],
            [782, 65, 'A) 3 – 3',   0, 0], [782, 65, 'B) 2 – 4',   0, 0], [782, 65, 'C) 4 – 2',   0, 0], [782, 65, 'D) 1 – 1',   0, 0], [782, 65, 'E) 2 – 2',   1, 1],
            [783, 65, 'A) 13 – 13',     0, 0], [783, 65, 'B) 12¾ – 13',  0, 0], [783, 65, 'C) 13 – 13¼',  1, 1], [783, 65, 'D) 13¼ – 13½', 0, 0], [783, 65, 'E) 12½ – 13',  0, 0],
            [784, 65, 'A) 20 – 21', 1, 1], [784, 65, 'B) 19 – 20', 0, 0], [784, 65, 'C) 23 – 24', 0, 0], [784, 65, 'D) 21 – 22', 0, 0], [784, 65, 'E) 18 – 19', 0, 0],
            [785, 65, 'A) ½ – ¼',   0, 0], [785, 65, 'B) ¼ – 1/16',0, 0], [785, 65, 'C) ¼ – ⅛',   1, 1], [785, 65, 'D) ⅛ – 1/16',0, 0], [785, 65, 'E) 1/16 – 1/32', 0, 0],
            [786, 65, 'A) 83.3 – 92.3', 0, 0], [786, 65, 'B) 84.3 – 93.3', 0, 0], [786, 65, 'C) 82.3 – 94.3', 0, 0], [786, 65, 'D) 86.3 – 95.3', 0, 0], [786, 65, 'E) 85.3 – 94.3', 1, 1],
            [787, 65, 'A) 6 – 8',   1, 1], [787, 65, 'B) 5 – 6',   0, 0], [787, 65, 'C) 6 – 9',   0, 0], [787, 65, 'D) 7 – 8',   0, 0], [787, 65, 'E) 5 – 7',   0, 0],
            [788, 65, 'A) 30 – 31', 0, 0], [788, 65, 'B) 31 – 32', 0, 0], [788, 65, 'C) 32 – 33', 0, 0], [788, 65, 'D) 33 – 34', 1, 1], [788, 65, 'E) 34 – 35', 0, 0],
            [789, 65, 'A) 10 – 25',  0, 0], [789, 65, 'B) 25 – 125', 1, 1], [789, 65, 'C) 20 – 100',0, 0], [789, 65, 'D) 20 – 125', 0, 0], [789, 65, 'E) 15 – 120', 0, 0],
        ];



        $dataToInsert = array_map(fn($a) => [
            'question_id'   => $a[0],
            'competence_id' => $a[1],
            'text'          => $a[2],
            'is_correct'    => $a[3],
            'weight'        => $a[4],
            'created_at'    => $now,
            'updated_at'    => $now,
        ], $answers);

        foreach (array_chunk($dataToInsert, 100) as $chunk) {
            DB::table('answers')->insert($chunk);
        }
    }
}
