<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluación Face to Face</title>
    <style>
        html{
            margin: 0;
        }
body {
            font-family: Arial, sans-serif;
            margin-top: 0px;
            margin-right: 0px;
            margin-left: 0px;
            margin-bottom: 0px;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 100%;
            background: white;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
    text-align: center;
            color: #333;
        }
        table {
    width: 100%;
    border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
    border: 1px solid #ccc;
            text-align: left;
            padding: 8px;
        }
        th {
    background-color: #eee;
        }
        .signature {
    margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="display: flex; align-items: center; justify-content: center;">
            <img src="{{ public_path('img/logo_header_home.jpg')}}" alt="Logo" width="150" style="margin-right: 10px;"/>
            <h1 style="margin: 0;">
                Evaluación Face to Face
            </h1>
        </div>


        <p><strong>Fecha:</strong> {{ $evaluation->evaluation_date }}</p>
        <p><strong>Tipo de Evaluación:</strong> {{$evaluation->initial && $evaluation->follow_up && $evaluation->consolidated?($evaluation->final?'final':'consolidada'):($evaluation->initial && $evaluation->follow_up?'Seguimiento':'Inicial')}}</p>

        <h2>Responsables</h2>
        <p><strong>Responsable de la Evaluación:</strong> {{$evaluation->supervisor->name.' '.$evaluation->supervisor->first_name.' '.$evaluation->supervisor->last_name}} </p>
        <p><strong>Colaborador Evaluado:</strong>{{$evaluation->user->name.' '.$evaluation->user->first_name.' '.$evaluation->user->last_name}} </p>

        <h2>Cultura</h2>
        <table>
            <tr>
                <th>Tema</th>
                <th>Comentarios y compromiso</th>
                <th>Fecha Programada</th>
                <th>% Avance</th>
            </tr>
            @foreach($evaluation->cultureTopics as $culture)
            <tr>
                <td>{{$culture->theme??null}}</td>
                <td>
                    <strong>Comentarios:</strong>
                    {{$culture->comments??null}}<br>
                    <strong>Compromisos:</strong>
                    {{$culture->commitments??null}}
                </td>
                <td>{{$culture->scheduled_date??null}}</td>
                <td>{{$culture->progress??null}}</td>
            </tr>

        </table>
        @endforeach
        <h2>Desempeño</h2>
        <table>
            <tr>
                <th>
                    Evaluación 360

                </th>
                <th>
                    Potencial
                </th>
                <th>
                    Resultado 9 box

                </th>
            </tr>
            <tr>
                <td>
                    @if($eva360)
                        {{$eva360}}
                    @else
                        <div class="mt-3 text-sm/6 sm:text-xs/6 text-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        No hay información de la evaluación 360
                                    </span>
                        </div>
                    @endif
                </td>
                <td>
                    @if($evaPotential)
                        <div class="mt-3 text-3xl/8 font-semibold sm:text-2xl/8 text-center">{{$evaPotential}}</div>
                        <div class="mt-3 text-sm/6 sm:text-xs/6 text-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Última evaluación cargada
                            </span>

                        </div>
                    @else
                        <div class="mt-3 text-sm/6 sm:text-xs/6 text-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                No existe psicometría
                            </span>

                        </div>
                    @endif
                </td>
                <td>
                    @if($quadrant)
                        <strong>Box:</strong> {{$quadrant}}
                        <br><!-- Aquí va el resultado de la evaluación -->
                        <strong>Interpretación</strong>
                        {{$interpretation}}
                    @else
                        <div class="mt-3 text-sm/6 sm:text-xs/6 text-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                No existe resultado 9 box
                            </span>

                        </div>
                    @endif
                </td>
            </tr>
        </table>
        <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
            <thead class="align-bottom">
            <tr>
                <th class="px-3 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Indicadores</th>
                @foreach (['En', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'] as $month)
                    <th class="px-3 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                        {{ $month }}
                    </th>
                @endforeach
            </tr>

            </thead>
            <tbody>
            @foreach ($indicadores as $indicator)
                <tr>
                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                        <div class="flex px-2 py-1">
                            <div class="flex flex-col justify-center px-3">
                                <h6 class="mb-0 text-sm leading-normal"> {{ $indicator->name }}</h6> <!-- Usa el nombre del indicador -->
                            </div>
                        </div>
                    </td>
                    @php
                        $months = array_fill(1, 12, 0); // Inicializa un arreglo con 12 meses
                        foreach ($indicator->progresses as $progress) {
                            $months[$progress->month] = $progress->progress_value; // Llena el mes con su valor
                        }
                    @endphp
                    @foreach ($months as $progressValue)
                        <td class="px-3 py-3 font-bold text-center align-middle bg-transparent border-b border-gray-200 shadow-none text-xs border-b-solid tracking-none whitespace-nowrap text-slate-500">
                            {{ $progressValue }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
        <table>
            @foreach($evaluation->performanceEvaluations as $performance)
            <tr>
                <th>Fortalezas:</th>
                <td>{{$performance->comments}}</td>
            </tr>
                <tr>
                    <th>Oportunidades:</th>
                    <td>{{$performance->commitments}}</td>
                </tr>
            @endforeach
        </table>

        <h2>Desarrollo</h2>
        <table>
            @if($evaluation->performanceFeedback && count($evaluation->performanceFeedback) > 0)
                @foreach($evaluation->performanceFeedback as $performance)
                    <tr>
                        <th>Fortalezas auto detectadas:</th>
                        <td>{{$performance->strengths}}</td>
                    </tr>
                    <tr>
                        <th>Áreas de oportunidad auto detectadas:</th>
                        <td>{{$performance->opportunities}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2">No hay información de retroalimentación disponible</td>
                </tr>
            @endif
        </table>


        <h2>Aspectos a Trabajar</h2>
        <table>
            <tr>
                <th>Área</th>
                <th>Tipo de Aprendizaje</th>
                <th>Fecha Programada</th>
                <th>% Avance</th>
            </tr>
            @if($evaluation->developmentPlans)
                @foreach($evaluation->developmentPlans as $plan)
                    <tr>
                        <td>{{$plan->development_area}}</td>
                        <td>{{$plan->learning_type===''}}</td>
                        <td>{{$plan->scheduled_date}}</td>
                        <td>{{$plan->progress}}</td>
                    </tr>
                @endforeach
            @endif
        </table>

        <h2>Asuntos Varios</h2>
        @if($evaluation->miscellaneousTopics)
            <table>
                <thead>
                    <tr>
                        <th>Tema</th>
                        <th>De</th>
                        <th>Comentario</th>
                        <th>Seguimiento</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($evaluation->miscellaneousTopics as $topic)
                    <tr>
                        <td>{{$topic->topic}}</td>
                        <td>{{$topic->who_says}}</td>
                        <td>{{$topic->comments}}</td>
                        <td>{{$topic->follow_up}}</td>

                    </tr>
                @endforeach

                </tbody>
            </table>
        @endif


        <div class="signature">
            <p><strong>Nombre y Firma Jefe:</strong> ______________________</p>
            <p><strong>Nombre y Firma Colaborador:</strong> ______________________</p>
        </div>
    </div>
</body>
</html>
