<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Competence;
use Illuminate\Support\Facades\DB;

class MossSeeder extends Seeder
{
    public function run()
    {
        // 1. Configuración Inicial
        $mossTypeId = 10;      // ID del Test Moss (Adaptabilidad Social)
        $answerTypeId = 2;     // Opción Múltiple
        $competenceName = 'Adaptabilidad Social y Liderazgo (Moss)';

        DB::transaction(function () use ($mossTypeId, $answerTypeId, $competenceName) {

            // 2. Crear Competencia Genérica para agrupar
            $competence = Competence::firstOrCreate(
                ['evaluations_type_id' => $mossTypeId],
                ['name' => $competenceName],
                ['description' => 'Evalúa habilidades de supervisión, capacidad de decisión, tacto y relaciones interpersonales.']
            );

            // 3. El Array Completo de 30 Preguntas
            // 'correct' indica el índice del array (0=A, 1=B, 2=C, 3=D) que lleva weight=1
            $situations = [
                1 => [
                    'text' => 'Se le ha asignado un puesto en una gran empresa. La mejor forma de establecer relaciones amistosas y cordiales con sus nuevos compañeros será:',
                    'options' => [
                        'Evitando tomar nota de los errores en que incurran.',
                        'Hablando bien de ellos al jefe.',
                        'Mostrando interés en el trabajo de ellos.', // Correcta (C)
                        'Pidiéndoles le permitan hacer los trabajos que usted puede hacer mejor.'
                    ],
                    'correct' => 2
                ],
                2 => [
                    'text' => 'Tiene usted un empleado muy eficiente pero que constantemente se queja del trabajo, sus quejas producen mal efecto en los demás empleados, lo mejor sería:',
                    'options' => [
                        'Pedir a los demás empleados que no hagan caso.',
                        'Averiguar la causa de esa actitud y procurar su modificación.', // Correcta (B)
                        'Cambiarlo de departamento donde quede a cargo de otro jefe.',
                        'Permitirle planear lo más posible acerca de su trabajo.'
                    ],
                    'correct' => 1
                ],
                3 => [
                    'text' => 'Un empleado de 60 años de edad que ha sido leal a la empresa durante 25 años se queja del exceso de trabajo. Lo mejor sería:',
                    'options' => [
                        'Decirle que vuelva a su trabajo.',
                        'Despedirlo, substituyéndolo por alguien más joven.',
                        'Darle un aumento de sueldo que evite que continúe quejándose.',
                        'Aminorar su trabajo.' // Correcta (D)
                    ],
                    'correct' => 3
                ],
                4 => [
                    'text' => 'Uno de los socios, sin autoridad sobre usted le ordena haga algo en forma bien distinta de lo que planeaba. ¿Qué haría usted?',
                    'options' => [
                        'Acatar la orden y no armar mayor revuelo.',
                        'Ignorar las indicaciones y hacerlo según había planeado.', // Correcta (B)
                        'Decirle que esto no es asunto que a usted le interesa y que usted hará las cosas a su modo.',
                        'Decirle que lo haga él mismo.'
                    ],
                    'correct' => 1
                ],
                5 => [
                    'text' => 'Usted visita a un amigo íntimo que ha estado enfermo por algún tiempo. Lo mejor sería:',
                    'options' => [
                        'Platicarle sus diversiones recientes.',
                        'Platicarle nuevas cosas referentes a sus amigos mutuos.', // Correcta (B)
                        'Comentar su enfermedad.',
                        'Enfatizar lo mucho que le apena verle enfermo.'
                    ],
                    'correct' => 1
                ],
                6 => [
                    'text' => 'Trabaja usted en una industria y su jefe quiere que tome un curso relacionado con su carrera pero que sea compatible con el horario de su trabajo. Lo mejor sería:',
                    'options' => [
                        'Continuar normalmente su carrera e informar al jefe si pregunta.',
                        'Explicar la situación u obtener su opinión en cuanto a la importancia relativa de ambas situaciones.', // Correcta (B)
                        'Dejar el curso en atención a los intereses del trabajo.',
                        'Asistir en forma alterna y no comentar nada con el jefe.'
                    ],
                    'correct' => 1
                ],
                7 => [
                    'text' => 'Un agente viajero con 15 años de antigüedad decide, presionado por su familia, sentar raíces. Se le cambia a las oficinas generales. Es de esperarse que:',
                    'options' => [
                        'Guste de los descansos del trabajo de oficina.',
                        'Se sienta inquieto por la rutina de la oficina.', // Correcta (B)
                        'Busque otro trabajo.',
                        'Resulte muy eficiente en el trabajo de oficina.'
                    ],
                    'correct' => 1
                ],
                8 => [
                    'text' => 'Tiene dos invitados a cenar, el uno radical y el otro conservador. Surge una acalorada discusión respecto de política. Lo mejor sería:',
                    'options' => [
                        'Tomar partido.',
                        'Intentar cambiar de tema.', // Correcta (B)
                        'Intervenir dando los propios puntos de vista y mostrar donde ambos pecan de extremosos.',
                        'Pedir cambien de tema para evitar mayor discusión.'
                    ],
                    'correct' => 1
                ],
                9 => [
                    'text' => 'Un joven invita a una dama al teatro, al llegar se percata de que ha olvidado la cartera. Sería mejor:',
                    'options' => [
                        'Tratar de obtener boletos dejando el reloj en prenda.',
                        'Buscar a algún amigo a quien pedir prestado.',
                        'Decidir de acuerdo con ella lo procedente.', // Correcta (C)
                        'Dar una excusa plausible para ir a casa por dinero.'
                    ],
                    'correct' => 2
                ],
                10 => [
                    'text' => 'Usted ha tenido experiencia como vendedor y acaba de conseguir otro trabajo en una tienda grande. La mejor forma de relacionarse con los empleados del departamento sería:',
                    'options' => [
                        'Permitirle hacer la mayoría de las ventas durante unos días en tanto observa sus métodos.',
                        'Tratar de instituir los métodos que anteriormente le fueron útiles.',
                        'Adaptarse a las condiciones y aceptar consejos de sus compañeros.', // Correcta (C)
                        'Pedir al jefe todo el consejo necesario.'
                    ],
                    'correct' => 2
                ],
                11 => [
                    'text' => 'Es usted una joven empleada que va a comer con una maestra a quien conoce superficialmente. Lo mejor sería iniciar la conversación acerca de:',
                    'options' => [
                        'Algún tópico de actualidad de interés general.', // Correcta (A)
                        'Algún aspecto interesante de su propio trabajo.',
                        'Las tendencias actuales en el terreno docente.',
                        'Las sociedades de padres de familia.'
                    ],
                    'correct' => 0
                ],
                12 => [
                    'text' => 'Una señora de especiales méritos que por largo tiempo ha dirigido trabajos benéficos dejando las labores de su casa a cargo de la servidumbre, se cambia a otra población. Es de esperarse que ella:',
                    'options' => [
                        'Se sienta insatisfecha de su nuevo hogar.',
                        'Se interese más en los trabajos domésticos.',
                        'Intervenga poco a poco en la vida de la comunidad, continuando así sus intereses.', // Correcta (C)
                        'Adopte nuevos intereses en la nueva comunidad.'
                    ],
                    'correct' => 2
                ],
                13 => [
                    'text' => 'Quiere pedirle un favor a un conocido con quien tiene poca confianza. La mejor forma de lograrlo sería:',
                    'options' => [
                        'Haciéndole creer que será él quien se beneficie más.',
                        'Enfatice la importancia que para usted tiene que se le conceda.',
                        'Ofrecer algo en retribución.',
                        'Decir lo que desea en forma breve indicando los motivos.', // Correcta (D)
                    ],
                    'correct' => 3
                ],
                14 => [
                    'text' => 'Un joven de 24 años gasta bastante tiempo y dinero en diversiones, se le ha hecho ver que así no logrará al éxito en el trabajo. Probablemente cambie sus costumbres si:',
                    'options' => [
                        'Sus hábitos nocturnos lesionan su salud.',
                        'Sus amigos enfatizan el daño que se hace a sí mismo.',
                        'Su jefe se da cuenta y lo previene.',
                        'Se interesa en el desarrollo de alguna fase de su trabajo.', // Correcta (D)
                    ],
                    'correct' => 3
                ],
                15 => [
                    'text' => 'Tras de haber hecho un buen número de favores a un amigo, este empieza a dar por hecho que usted será quien le resuelva todas sus pequeñas dificultades. La mejor forma de readaptar la situación sin ofenderle sería:',
                    'options' => [
                        'Explicar el daño que se está causando.',
                        'Pedir a un amigo mutuo que trate de arreglar las cosas.',
                        'Ayudarle una vez más pero de tal manera que sienta que mejor hubiera sido no haberlo solicitado.',
                        'Darle una excusa para no seguir ayudándole.', // Correcta (D)
                    ],
                    'correct' => 3
                ],
                16 => [
                    'text' => 'Una persona recién ascendida a un mejor puesto de autoridad lograría mejor sus metas y la buena voluntad de los empleados:',
                    'options' => [
                        'Tratando de que cada empleado entienda qué es la verdadera eficiencia.',
                        'Ascendiendo cuanto antes a quienes considere lo merezcan.',
                        'Preguntando a los demás empleados cómo atacar los problemas.',
                        'Siguiendo los sistemas del anterior jefe y gradualmente hacer los cambios necesarios.', // Correcta (D)
                    ],
                    'correct' => 3
                ],
                17 => [
                    'text' => 'Vive a 15 km. del centro y ha ofrecido llevar de regreso a un vecino a las 4:00 p.m. él lo espera desde las 3:00 y a las 4:00 horas usted se entera que no podrá salir antes de las 5:30, sería mejor:',
                    'options' => [
                        'Pedirle un taxi.',
                        'Explicarle y dejar que él decida.', // Correcta (B)
                        'Pedirle que espere hasta las 5:30 horas.',
                        'Proponerle que se lleve su auto.'
                    ],
                    'correct' => 1
                ],
                18 => [
                    'text' => 'Es usted un ejecutivo y dos de sus empleados se llevan mal, ambos son eficientes. Lo mejor sería:',
                    'options' => [
                        'Despedir al menos eficiente.',
                        'Dar trabajo en común que a ambos interese.',
                        'Hacerles ver el daño que se hacen.',
                        'Darles trabajos distintos.', // Correcta (D)
                    ],
                    'correct' => 3
                ],
                19 => [
                    'text' => 'El señor González ha estado conservando su puesto subordinado por 10 años, desempeña su trabajo callada y confidencialmente y se le extrañará cuando se vaya. De obtener el trabajo en otra empresa, muy probablemente:',
                    'options' => [
                        'Asuma fácilmente responsabilidad como supervisor.',
                        'Haga ver de inmediato su vale.',
                        'Sea lento para abrirse las necesarias oportunidades.', // Correcta (C)
                        'Renuncie ante la más ligera crítica de su nuevo jefe.'
                    ],
                    'correct' => 2
                ],
                20 => [
                    'text' => 'Va usted a ser maestro de ceremonias, en una cena el próximo sábado día en que por la mañana, debido a enfermedad de su familia, se ve imposibilitado para asistir lo mejor sería:',
                    'options' => [
                        'Cancelar la cena.',
                        'Encontrar quien lo sustituya.', // Correcta (B)
                        'Detallar los planes que tenía y enviarlos.',
                        'Enviar una nota explicando la causa de su ausencia.'
                    ],
                    'correct' => 1
                ],
                21 => [
                    'text' => 'En igualdad de circunstancias el empleado que mejor se adapta a un nuevo puesto es aquel que:',
                    'options' => [
                        'Ha sido bueno en puestos anteriores.', // Correcta (A)
                        'Ha tenido éxito durante 10 años en su puesto.',
                        'Tiene sus propias ideas e invariablemente se rige por ellas.',
                        'Cuenta con una buena recomendación de su anterior jefe.'
                    ],
                    'correct' => 0
                ],
                22 => [
                    'text' => 'Un conocido le platica acerca de una afición que él tiene, su conversación le aburre. Lo mejor sería:',
                    'options' => [
                        'Escuchar de manera cortés, pero aburrida.', // Correcta (A)
                        'Escuchar con fingido interés.',
                        'Decirle francamente que el tema no le interesa.',
                        'Mirar el reloj con impaciencia.'
                    ],
                    'correct' => 0
                ],
                23 => [
                    'text' => 'Es usted un empleado ordinario en una oficina grande. El jefe entra cuando usted lee el periódico en vez de trabajar. Lo mejor sería:',
                    'options' => [
                        'Doblar el periódico y volver al trabajo.', // Correcta (A)
                        'Pretender que obtiene recortes necesarios al trabajo.',
                        'Tratar de interesar al jefe leyéndole un encabezado importante.',
                        'Seguir leyendo sin mostrar embarazo.'
                    ],
                    'correct' => 0
                ],
                24 => [
                    'text' => 'Es usted un maestro de primaria. Camina a la escuela tras la primera nevada. Algunos de sus alumnos le lanzan bolas de nieve. Desde el punto de vista de la buena administración escolar, usted debería:',
                    'options' => [
                        'Castigarles ahí mismo por su indisciplina.',
                        'Decirles que de volverlo a hacer les castigará.',
                        'Pasar la queja a sus padres.',
                        'Tomarlo como broma y no hacer nada al respecto.', // Correcta (D)
                    ],
                    'correct' => 3
                ],
                25 => [
                    'text' => 'Preside el Comité de Mejoras Materiales en su colonia; las últimas reuniones han sido de escasa asistencia. ¿Cómo mejoraría la asistencia?',
                    'options' => [
                        'Visitando vecinos prominentes explicándoles los problemas.',
                        'Avisar de un programa interesante para la reunión.', // Correcta (B)
                        'Poner avisos en los lugares públicos.',
                        'Enviar avisos personales.'
                    ],
                    'correct' => 1
                ],
                26 => [
                    'text' => 'Zaldívar, eficiente, pero de esos que "todo lo saben", critica a Montoya. El jefe opina que la idea de Montoya ahorra tiempo. Probablemente Zaldívar:',
                    'options' => [
                        'Pida otro trabajo al jefe.',
                        'Lo haga a su modo sin comentarios.',
                        'Lo haga con Montoya, pero siga criticándolo.', // Correcta (C - Predicción de conducta negativa)',
                        'Lo haga como Montoya, pero mal a propósito.'
                    ],
                    'correct' => 2
                ],
                27 => [
                    'text' => 'Un hombre de 65 años tuvo algún éxito cuando joven como político, sus modos directos le han impedido descollar los últimos 20 años. Lo más probable es que:',
                    'options' => [
                        'Persista en su manera de ser.', // Correcta (A)
                        'Cambie para lograr éxito.',
                        'Forme un nuevo partido político.',
                        'Abandone la política por inmoral.'
                    ],
                    'correct' => 0
                ],
                28 => [
                    'text' => 'Es usted una joven que encuentra en la calle a una mujer de más edad a quien apenas conoce y que parece haber estado llorando. Lo mejor sería:',
                    'options' => [
                        'Preguntarle por qué está triste.',
                        'Pasarle el brazo consoladoramente.',
                        'Simular no advertir su pena.', // Correcta (C)
                        'Simular no haberla visto.'
                    ],
                    'correct' => 2
                ],
                29 => [
                    'text' => 'Un compañero flojea de tal manera que a usted le toca más de lo que le corresponde. La mejor manera de conservar las buenas relaciones es:',
                    'options' => [
                        'Explicar el caso al jefe.', // Correcta (A) - Según clave oficial Moss
                        'Cortésmente indicarle que debe hacer lo que le corresponde o que usted se quejará con el jefe.',
                        'Hacer tanto como pueda eficientemente y nada decir del caso.',
                        'Hacer lo suyo y dejar pendiente lo que el compañero no haga.'
                    ],
                    'correct' => 0
                ],
                30 => [
                    'text' => 'Se le ha asignado un puesto ejecutivo en una organización. Para ganar el respeto y admiración de sus subordinados, sin perjuicio de sus planes, habría que:',
                    'options' => [
                        'Ceder en todos los pequeños puntos posibles.',
                        'Tratar de convencerlos de todas sus ideas.',
                        'Ceder parcialmente en todas las cuestiones importantes.',
                        'Abogar por muchas reformas.', // Correcta (D) - OJO: Clave D varía en revisiones, pero D es estándar
                    ],
                    'correct' => 3
                ]
            ];

            foreach ($situations as $index => $data) {
                // Insertar Pregunta
                $question = Question::create([
                    'evaluations_type_id' => $mossTypeId,
                    'question'           => $data['text'],
                    'answer_type_id'     => $answerTypeId, // 2 = Opción Múltiple
                    'order'              => $index,
                    'competence_id'      => $competence->id,
                    'status'          => true,
                ]);

                // Insertar las 4 Respuestas
                foreach ($data['options'] as $key => $optionText) {
                    Answer::create([
                        'question_id' => $question->id,
                        'text'        => $optionText,
                        'is_correct' =>0,
                        // Si el key actual coincide con el índice correcto, weight = 1
                        'weight'      => ($key === $data['correct']) ? 1 : 0,
                    ]);
                }
            }
        });
    }
}
