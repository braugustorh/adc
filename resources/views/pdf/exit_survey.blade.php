<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Entrevista de Salida - {{ $user->name }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0056b3;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #0056b3;
            font-size: 24px;
            margin: 0;
            padding-top: 10px;
        }
        .info-card {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 30px;
        }
        .info-row {
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            color: #6c757d;
            margin-right: 10px;
        }
        .info-value {
            font-weight: 500;
        }
        .section-title {
            background-color: #0056b3;
            color: white;
            padding: 8px 15px;
            font-size: 16px;
            border-radius: 5px 5px 0 0;
            margin-top: 20px;
        }
        .questions-container {
            border: 1px solid #dee2e6;
            border-top: none;
            padding: 15px;
            background-color: white;
            padding-bottom: 30px;
        }
        .question-block {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .question-text {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #212529;
            font-size: 14px;
        }
        .answer-box {
            background-color: #f8f9fa;
            border-left: 4px solid #0056b3;
            padding: 10px;
            font-size: 14px;
        }
        .rating-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            color: white;
            font-size: 12px;
            text-transform: uppercase;
        }
        .rating-muy_bueno { background-color: #28a745; }
        .rating-bueno { background-color: #5cb85c; }
        .rating-regular { background-color: #ffc107; color: black; }
        .rating-malo { background-color: #dc3545; }
        .rating-muy_malo { background-color: #c82333; }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #adb5bd;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Entrevista de Salida</h1>
    </div>

    <div class="info-card">
        <div class="info-row">
            <span class="info-label">Colaborador:</span>
            <span class="info-value">{{ $user->name }} {{ $user->first_name }} {{ $user->last_name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Fecha:</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($survey->created_at)->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Estatus:</span>
            <span class="info-value">{{ ucfirst($survey->status) }}</span>
        </div>
    </div>

    <div class="section-title">Detalle de Respuestas</div>
    <div class="questions-container">
        @foreach($questions as $field => $question)
            @php
                $answer = $survey->$field;
                if(is_null($answer)) continue;

                // Formatear ratings
                $isRating = in_array($field, [
                    'physical_environment_rating', 'induction_rating', 'training_rating',
                    'motivation_rating', 'recognition_rating', 'salary_rating',
                    'supervisor_treatment_rating', 'rh_treatment_rating'
                ]);
            @endphp

            <div class="question-block">
                <span class="question-text">{{ $question }}</span>
                <div class="answer-box">
                    @if(is_array($answer))
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach($answer as $item)
                                <li>{{ ucfirst(str_replace('_', ' ', $item)) }}</li>
                            @endforeach
                        </ul>
                    @elseif($isRating)
                        <span class="rating-badge rating-{{ $answer }}">{{ ucfirst(str_replace('_', ' ', $answer)) }}</span>
                    @elseif($field === 'met_expectations')
                        {{ $answer ? 'Sí' : 'No' }}
                    @else
                        {!! nl2br(e($answer)) !!}
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="footer">
        Generado el {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>

