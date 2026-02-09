<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Competence;
use Illuminate\Support\Facades\DB;

class KostickSeeder extends Seeder
{
    public function run()
    {
        // 1. CONFIGURACIÓN
        $kostickTypeId = 12; // Asegúrate que este ID coincida con tu tabla evaluation_types
        $answerTypeId = 2;   // Usamos el tipo 2 (Opción Múltiple / Radio Buttons)

        DB::transaction(function () use ($kostickTypeId, $answerTypeId) {

            // 2. COMPETENCIA GENÉRICA (Contenedor)
            // Aunque Kostick se califica por letras en las respuestas,
            // agrupamos las preguntas bajo una competencia general para mantener orden.
            $competence = Competence::firstOrCreate(
                ['evaluations_type_id' => $kostickTypeId],
                ['name' => 'Inventario de Percepción (Kostick)'],
                ['description' => 'Evalúa estilos administrativos y desempeño en el trabajo mediante 20 dimensiones.'],
                ['level' => 1], // Nivel 1 para competencia general
                ['status' => true]
            );

            // 3. LOS 90 PARES (Preguntas y Factores)
            // Formato: [Indice] => [['Frase 1', 'Letra1'], ['Frase 2', 'Letra2']]
            $pairs = [
                1 => [['Soy trabajador tenaz', 'G'], ['No soy de humor variable', 'Z']],
                2 => [['Me gusta hacer el trabajo mejor que los demás', 'A'], ['Me gusta seguir con lo que he empezado hasta terminarlo', 'N']],
                3 => [['Me gusta enseñar a la gente cómo hacer las cosas', 'P'], ['Me gusta hacer las cosas lo mejor posible', 'A']],
                4 => [['Me gusta hacer cosas graciosas', 'X'], ['Me gusta decir a la gente lo que tiene que hacer', 'P']],
                5 => [['Me gusta pertenecer a grupos', 'B'], ['Me gusta ser tomado en cuenta por los grupos', 'X']],
                6 => [['Me gusta tener un amigo íntimo', 'O'], ['Me gusta hacer amistad con el grupo', 'B']],
                7 => [['Yo cambio rápidamente cuando lo creo necesario', 'E'], ['Yo intento tener amigos íntimos', 'O']],
                8 => [['Me gusta "pagar con la misma moneda" cuando alguien me ofende', 'K'], ['Me gusta hacer cosas nuevas y diferentes', 'E']],
                9 => [['Quiero que mi jefe me estime', 'F'], ['Me gusta decir a la gente cuando está equivocada', 'K']],
                10 => [['Me gusta seguir las instrucciones que me dan', 'W'], ['Me gusta agradar a mis superiores', 'F']],

                11 => [['Me esfuerzo mucho', 'G'], ['Soy ordenado, pongo todo en su lugar', 'C']],
                12 => [['Consigo que la gente haga lo que yo quiero', 'L'], ['No me altero fácilmente', 'Z']],
                13 => [['Me gusta decir al grupo lo que tiene que hacer', 'P'], ['Siempre continúo un trabajo hasta que está hecho', 'N']],
                14 => [['Me gusta ser animado e interesante', 'X'], ['Yo quiero tener mucho éxito', 'A']],
                15 => [['Me gusta encajar con grupos', 'B'], ['Me gusta ayudar a la gente a tomar decisiones', 'P']],
                16 => [['Me preocupa cuando alguien no me estima', 'O'], ['Me gusta que la gente note mi presencia', 'X']],
                17 => [['Me gusta probar cosas nuevas', 'E'], ['Prefiero trabajar con otras personas que solo', 'B']],
                18 => [['A veces culpo a otros cuando las cosas salen mal', 'K'], ['Me molesta cuando no le caigo bien a alguien', 'O']],
                19 => [['Me gusta complacer a mis superiores', 'F'], ['Me gusta intentar trabajos nuevos y diferentes', 'E']],
                20 => [['Me gusta recibir instrucciones detalladas para hacer un trabajo', 'W'], ['Me gusta decírselo a la gente cuando me molestan', 'K']],

                21 => [['Siempre me esfuerzo mucho', 'G'], ['Me gusta ir paso a paso con gran cuidado', 'D']],
                22 => [['Soy un buen dirigente', 'L'], ['Organizo muy bien el trabajo de un puesto', 'C']],
                23 => [['Me enfado con facilidad', 'I'], ['Soy lento tomando decisiones', 'Z']],
                24 => [['Me gusta trabajar en varias actividades al mismo tiempo', 'X'], ['Cuando estoy en grupo me gusta estar callado', 'N']],
                25 => [['Me gusta que me inviten', 'B'], ['Me gusta hacer las cosas mejor que los demás', 'A']],
                26 => [['Me gusta hacer amigos íntimos', 'O'], ['Me gusta aconsejar a los demás', 'P']],
                27 => [['Me gusta hacer cosas nuevas y diferentes', 'E'], ['Me gusta hablar de mis éxitos', 'X']],
                28 => [['Cuando tengo razón me gusta luchar por ella', 'K'], ['Me gusta pertenecer a un grupo', 'B']],
                29 => [['Evito ser diferente a los demás', 'F'], ['Intento acercarme mucho a la gente', 'O']],
                30 => [['Me gusta que me digan exactamente cómo hacer las cosas', 'W'], ['Me aburro fácilmente', 'E']],

                31 => [['Trabajo mucho', 'G'], ['Pienso y planeo mucho', 'R']],
                32 => [['Yo dirijo al grupo', 'L'], ['Los pequeños detalles me interesan', 'D']],
                33 => [['Tomo decisiones fácil y rápidamente', 'I'], ['Guardo mis cosas cuidadosa y ordenadamente', 'C']],
                34 => [['Hago las cosas aprisa', 'T'], ['Yo no me enojo ni me pongo triste a menudo', 'Z']],
                35 => [['Quiero ser parte del grupo', 'B'], ['Quiero hacer un solo trabajo a la vez', 'N']],
                36 => [['Intento hacer amigos íntimos', 'O'], ['Intento ocupar puestos de responsabilidad', 'A']],
                37 => [['Me gusta hacer cosas nuevas y diferentes', 'E'], ['Me gusta que los demás obedezcan', 'P']],
                38 => [['Lucho por lo que creo', 'K'], ['Me gusta llamar la atención', 'X']],
                39 => [['Me gusta agradar a mis superiores', 'F'], ['Me gusta estar con la gente', 'B']],
                40 => [['Me gusta seguir las reglas con cuidado', 'W'], ['Me gusta que la gente me conozca muy bien', 'O']],

                41 => [['Me esfuerzo mucho', 'G'], ['Soy muy amigable', 'S']],
                42 => [['La gente piensa que soy un buen dirigente', 'L'], ['Pienso con cuidado y largo tiempo', 'R']],
                43 => [['A menudo me arriesgo', 'I'], ['Me gusta ocuparme de los detalles', 'D']],
                44 => [['La gente piensa que trabajo deprisa', 'T'], ['Me gusta tener mis cosas ordenadas', 'C']],
                45 => [['Me gusta jugar y hacer deportes', 'V'], ['Soy muy agradable', 'Z']],
                46 => [['Me gusta que la gente sea amable conmigo', 'O'], ['Siempre termino el trabajo que empiezo', 'N']],
                47 => [['Me gusta experimentar y probar cosas nuevas', 'E'], ['Me gusta hacer bien el trabajo', 'A']],
                48 => [['Me gusta que me traten justamente', 'K'], ['Me gusta decir a los demás cómo hacer las cosas', 'P']],
                49 => [['Me gusta hacer aquello que esperan de mí', 'F'], ['Me gusta llamar la atención', 'X']],
                50 => [['Me gusta seguir las instrucciones con cuidado', 'W'], ['Me gusta estar con la gente', 'B']],

                51 => [['Siempre trato de hacer mi trabajo perfecto', 'G'], ['Me dicen que soy prácticamente incansable', 'V']],
                52 => [['Soy el tipo de líder que la gente obedece', 'L'], ['Hago amigos fácilmente', 'S']],
                53 => [['A menudo tomo riesgos', 'I'], ['Dedico mucho tiempo a pensar', 'R']],
                54 => [['Trabajo a un paso rápido y constante', 'T'], ['Me gusta trabajar con detalles', 'D']],
                55 => [['Tengo mucha energía para juegos y deportes', 'V'], ['Tengo mis cosas muy ordenadas', 'C']],
                56 => [['Me llevo bien con todo el mundo', 'S'], ['Soy de temperamento estable', 'Z']],
                57 => [['Quiero conocer nueva gente y hacer cosas nuevas', 'E'], ['Siempre quiero terminar el trabajo que empiezo', 'N']],
                58 => [['Normalmente lucho por lo que creo', 'K'], ['No me gusta perder', 'A']],
                59 => [['Me gusta hacer lo que mis superiores dicen', 'F'], ['Me gusta que la gente haga lo que yo digo', 'P']],
                60 => [['Me gusta seguir las reglas', 'W'], ['Me gusta ser el centro de atención', 'X']],

                61 => [['Trabajo duro', 'G'], ['Soy un buen líder', 'T']],
                62 => [['Soy bueno para influir en la gente', 'L'], ['Me arriesgo a hacer cosas', 'V']],
                63 => [['Tomo decisiones rápidas', 'I'], ['Trabajo deprisa', 'S']],
                64 => [['Normalmente trabajo con gran rapidez', 'T'], ['Tengo mucha energía', 'R']],
                65 => [['Disfruto mucho trabajando', 'V'], ['Me gusta tener la atención de la gente', 'D']],
                66 => [['Trato de lograr que la gente esté de acuerdo conmigo', 'S'], ['Me gusta pensar mucho', 'C']],
                67 => [['Me gusta el trabajo que requiere pensar', 'R'], ['Me gusta trabajar con detalles', 'Z']],
                68 => [['Me gusta trabajar con detalles', 'K'], ['Me gusta organizar mi trabajo', 'N']],
                69 => [['Me gusta que mi trabajo esté ordenado', 'F'], ['No me enojo fácilmente', 'A']],
                70 => [['Me gusta que me digan qué hacer', 'W'], ['Siempre termino lo que empiezo', 'P']],

                71 => [['Me gusta trabajar mucho', 'G'], ['Me gusta tomar decisiones rápidas', 'I']],
                72 => [['Me gusta decirle a la gente lo que tiene que hacer', 'L'], ['Hago las cosas deprisa', 'T']],
                73 => [['Me gusta tomar decisiones rápidas', 'I'], ['Tengo mucha energía', 'V']],
                74 => [['Trabajo deprisa', 'T'], ['Me gusta conocer gente', 'S']],
                75 => [['Tengo mucha energía', 'V'], ['Me gusta pensar mucho', 'R']],
                76 => [['Hago amigos fácilmente', 'S'], ['Me gusta trabajar con detalles', 'D']],
                77 => [['Me gusta pensar mucho', 'R'], ['Me gusta tener mis cosas ordenadas', 'C']],
                78 => [['Me gusta trabajar con detalles', 'D'], ['No me enojo fácilmente', 'Z']],
                79 => [['Me gusta organizar mi trabajo', 'F'], ['Me gusta terminar mi trabajo', 'N']],
                80 => [['Me gusta que me digan cómo hacer las cosas', 'W'], ['Me gusta trabajar duro', 'A']],

                81 => [['Soy un trabajador tenaz', 'G'], ['Me gusta tomar el mando', 'L']],
                82 => [['Soy un buen dirigente', 'L'], ['Tomo decisiones rápida y fácilmente', 'I']],
                83 => [['Tomo decisiones rápidas', 'I'], ['Hago las cosas deprisa', 'T']],
                84 => [['Trabajo deprisa', 'T'], ['Soy muy activo', 'V']],
                85 => [['No me gusta conocer gente. ', 'V'], ['Soy muy sociable', 'S']],
                86 => [['Hago muchísimos amigos ', 'S'], ['Dedico mucho tiempo a pensar', 'R']],
                87 => [['Me gusta trabajar con problemas teóricos. ', 'R'], ['Me gusta el trabajo de detalle', 'D']],
                88 => [['Me gusta el trabajo de detalle', 'D'], ['Me gusta organizar mi trabajo.', 'C']],
                89 => [['Pongo las cosas en su lugar', 'C'], ['Siempre soy agradable.', 'Z']],
                90 => [['Me gusta que me digan qué hacer', 'W'], ['Siempre termino lo que empiezo', 'N']],
            ];

            foreach ($pairs as $index => $options) {
                // 1. Crear Pregunta (Par)
                $question = Question::create([
                    'evaluations_type_id' => $kostickTypeId,
                    'question'           => 'Par ' . $index,
                    'answer_type_id'     => $answerTypeId, // 2 = Opción Múltiple
                    'order'              => $index,
                    'competence_id'      => $competence->id,
                    'status'          => true,
                ]);

                // 2. Crear las 2 Opciones (Frases)
                foreach ($options as $opt) {
                    Answer::create([
                        'question_id' => $question->id,
                        'text'        => $opt[0],
                        'code'        => $opt[1], // Letra del factor Kostick
                        'is_correct' => false, // No hay respuestas "correctas" en Kostick
                        'weight'      => 1,       // Valor estándar
                    ]);
                }
            }
        });
    }
}
