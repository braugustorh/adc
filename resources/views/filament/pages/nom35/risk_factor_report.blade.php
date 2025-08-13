<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado General</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            color: #007bff;
            font-size: 24px;
            margin: 0;
        }
        .header p {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }
        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .risk-level {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 12px;
            color: white;
            font-weight: bold;
        }
        .Muy-Alto { background: #dc3545; }
        .Alto { background: #ff9800; }
        .Medio { background: #ffc107; }
        .Bajo { background: #28a745; }
        .Nulo { background: #6c757d; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        .risk-bar {
            height: 20px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            margin: 10px 0;
        }
        .risk-bar-fill {
            height: 100%;
        }
        .conclusion {
            background: #e9ecef;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .chart-container {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 20px 0;
        }
        .chart-bar {
            display: flex;
            align-items: flex-end;
            gap: 15px;
            height: 220px; /* altura máxima */
        }
        .chart-item {
            width: 60px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
            border-radius: 6px 6px 0 0;
            color: white;
            font-size: 12px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .chart-item span:first-child {
            margin-bottom: 5px;
        }
        /* Colores por nivel */
        .Muy-Alto { background-color: #c0392b; }
        .Alto { background-color: #e74c3c; }
        .Medio { background-color: #f39c12; }
        .Bajo { background-color: #27ae60; }
        .Nulo { background-color: #95a5a6; }

        /* Page breaks for PDF */
        .page-break {
            page-break-before: always;
        }

        .page-break-after {
            page-break-after: always;
        }

        @page {
            margin: 20px;
        }
    </style>
</head>
<body>

<!-- Encabezado -->
<div class="header">
    <h1>Resultado General</h1>
    <p>Guía de Referencia II - Norma Oficial Mexicana NOM-035-STPS-2018</p>
    <p>Empresa: {{ $company??'' }}</p>
</div>

<!-- Información Inicial -->
<div class="info-box">
    <p><strong>Fecha inicial de aplicación:</strong> {{ $reportDate}}</p>
    <p><strong>Fecha final de aplicación:</strong> {{ $period}}</p>
    <p><strong>Encuestados:</strong> {{$responsesTotalG2}}</p>
    <p><strong>Efectivos:</strong> {{$responsesTotalG2}}</p>
    <p><strong>Puntos Obtenidos:</strong> {{$calificacionG2}}</p>
    <p><strong>Calificación Final:</strong> <span class="risk-level {{$resultCuestionario==='Muy Alto'?'Muy-Alto':$resultCuestionario}}">{{$resultCuestionario}} </span></p>
</div>

<!-- Calificación por Categoría -->
<div class="section">
    <h2>Calificación por Categoría</h2>
    <table>
        <thead>
        <tr>
            <th>Categoría</th>
            <th>Muy alto</th>
            <th>Alto</th>
            <th>Medio</th>
            <th>Bajo</th>
            <th>Nulo o despreciable</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($categories as $categoria)
            <tr>
                <td>{{ $categoria['nombre'] }}</td>
                <td>{{ $categoria['very_high'] }}</td>
                <td>{{ $categoria['high'] }}</td>
                <td>{{ $categoria['medium'] }}</td>
                <td>{{ $categoria['low'] }}</td>
                <td>{{ $categoria['null'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="page-break"></div>
<!-- Calificación por Dominio -->
<div class="section">
    <h2>Calificación por Dominio</h2>
    <table>
        <thead>
        <tr>
            <th>Dominio</th>
            <th>Muy alto</th>
            <th>Alto</th>
            <th>Medio</th>
            <th>Bajo</th>
            <th>Nulo o despreciable</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($dominios as $dominio)
            <tr>
                <td>{{ $dominio['nombre'] }}</td>
                <td>{{ $dominio['very_high'] }}</td>
                <td>{{ $dominio['high'] }}</td>
                <td>{{ $dominio['medium'] }}</td>
                <td>{{ $dominio['low'] }}</td>
                <td>{{ $dominio['null'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="page-break"></div>
<!-- Calificación Final y Gráfico -->
<div class="conclusion">
    <h2>Calificación Final</h2>
    <div class="chart-container">
        @php
            $generalResults=[];
            $total =$generalResults['very_high'] + $generalResults['high'] +
                     $generalResults['medium'] + $generalResults['low'] +
                     $generalResults['null'];
            $maxHeight = 200; // Altura máxima en px para la barra más alta
            $maxValue = max($generalResults['very_high'], $generalResults['high'],
                     $generalResults['medium'], $generalResults['low'],
                     $generalResults['null']);
        @endphp
        <div class="chart-container">
            <div class="chart-bar">
                <div class="chart-item Muy-Alto" style="height: {{ $total > 0 ? ((($generalResults['very_high']/ $maxValue) * $maxHeight)+40) : 0 }}px;">
                    <span>{{$generalResults['very_high']}}</span>
                    <span>Muy Alto</span>
                </div>
                <div class="chart-item Alto" style="height: {{ $total > 0 ? ((($generalResults['high'] / $maxValue) * $maxHeight)+40) : 0 }}px;">
                    <span>{{$generalResults['high']}}</span>
                    <span>Alto</span>
                </div>
                <div class="chart-item Medio" style="height: {{ $total > 0 ? ((($generalResults['medium'] / $maxValue) * $maxHeight)+40) : 0 }}px;">
                    <span>{{$generalResults['medium']}}</span>
                    <span>Medio</span>
                </div>
                <div class="chart-item Bajo" style="height: {{ $total > 0 ? ((($generalResults['low'] / $maxValue) * $maxHeight)+40) : 0 }}px;">
                    <span>{{$generalResults['low']}}</span>
                    <span>Bajo</span>
                </div>
                <div class="chart-item Nulo" style="height: {{ $total > 0 ? ((($generalResults['null'] / $maxValue) * $maxHeight)+40) : 20 }}px;">
                    <span>{{$generalResults['null']}}</span>
                    <span>Nulo</span>
                </div>
            </div>
        </div>
    </div>
    <p>Valor: {{ $calificacionG2 }}</p>
</div>

<!-- Necesidad de Acción -->
<div class="conclusion">
    <h2>Necesidad de Acción</h2>
    <p>{{$recommendations}}</p>
</div>

</body>

</html>
