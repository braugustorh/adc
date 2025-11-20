<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado Individual Norma 035}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #333;
            line-height: 1.6;
            background-color: #ffffff;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            color: #007bff;
            font-size: 26px;
            margin: 10px 0;
        }
        .header p {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .info-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .info-item strong {
            display: block;
            color: #007bff;
        }
        .small-text {
            font-size: 0.625rem; /* 10px si el font-size base es 16px */
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 40px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background: #007bff;
            color: white;
            font-weight: bold;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .risk-level {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }
        .muy-alto { background: #dc3545; } /* Rojo */
        .alto { background: #ff9800; } /* Naranja */
        .medio { background: #ffc107; color: #333; } /* Amarillo */
        .bajo { background: #28a745; } /* Verde */
        .nulo { background: #6c757d; } /* Gris */
        .final-risk {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            background: #e9ecef;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .final-risk h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }
        .final-risk .score {
            font-size: 48px;
            font-weight: bold;
            color: #007bff;
            margin: 10px 0;
        }
        .final-risk .risk-level {
            font-size: 18px;
            padding: 10px 20px;
        }
        .recommendation {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
            line-height: 1.8;
        }
        /* Page breaks for PDF */
        .page-break {
            page-break-before: always;
        }

        .page-break-after {
            page-break-after: always;
        }
        .conclusion {
            background: #e9ecef;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        @page {
            margin: 20px;
        }
    </style>
</head>
<body>
@foreach($users as $empleado)
<!-- Encabezado -->
<div class="header">
    <h1>Resultado Individual</h1>
    <p>Guía de Referencia {{$guia}} - Norma Oficial Mexicana NOM-035-STPS-2018</p>
    <p>{{$guiaName}}</p>
</div>

<!-- Información del Empleado -->
<div class="info-grid">
    <div class="info-item">
        <strong>Nombre de la empresa:</strong>
        {{ $empleado['empresa'] }}
    </div>
    <div class="info-item">
        <strong>Nombre del encuestado:</strong>
        {{ $empleado['nombre'] }}
    </div>
    <div class="info-item">
        <strong>Fecha de aplicación:</strong>
        {{ $empleado['fecha_aplicacion'] }}
    </div>
    <div class="info-item">
        <strong>Puesto:</strong>
        {{ $empleado['puesto'] }}
    </div>
</div>

<!-- Tabla de Resultados -->
<table>
    <thead>
    <tr>
        <th>Categoría</th>
        <th>Puntos</th>
        <th>Riesgo</th>
        <th>Dominio</th>
        <th>Puntos</th>
        <th>Riesgo</th>
        <th>Dimensión</th>
        <th>Valor</th>
        <th>Nivel de Riesgo</th>
    </tr>
    </thead>
    <tbody>
    @foreach($empleado['structure'] as $categoriaKey => $categoria)
        @php $firstDominio = true; @endphp
        @foreach($categoria['domains'] as $dominioKey => $dominio)
            @php $firstDimension = true; @endphp
            @foreach($dominio['dimensions'] as $dimension)
                <tr>
                    @if($firstDominio)
                        <td rowspan="{{ collect($categoria['domains'])->sum(fn($d) => count($d['dimensions'])) }}">
                            {{ $categoria['name'] }}
                        </td>
                        <td rowspan="{{ collect($categoria['domains'])->sum(fn($d) => count($d['dimensions'])) }}">
                            {{ $categoria['score'] }}
                        </td>
                        <td rowspan="{{ collect($categoria['domains'])->sum(fn($d) => count($d['dimensions'])) }}">
                           <span class="risk-level {{ strtolower(str_replace(' ', '-', $categoria['level'])) }}" style="font-size: 9px;">
                            {{$categoria['level']}}
                            </span>
                        </td>
                    @endif

                    @if($firstDimension)
                        <td rowspan="{{ collect($dominio['dimensions'])->count() }}">
                            {{ $dominio['name'] }}
                        </td>
                        <td rowspan="{{ collect($dominio['dimensions'])->count() }}">
                            {{ $dominio['score'] }}
                        </td>
                        <td rowspan="{{ collect($dominio['dimensions'])->count() }}">
                            <span class="risk-level {{ strtolower(str_replace(' ', '-', $dominio['level'])) }}" style="font-size: 10px;">
                             {{$dominio['level']   }}
                            </span>
                        </td>
                    @endif

                    <td>{{ $dimension['name'] }}</td>
                    <td>{{ $dimension['score'] }}</td>
                    <td>
                        <span class="risk-level {{ strtolower(str_replace(' ', '-', $dimension['level'])) }}" >
                            {{ $dimension['level'] }}
                        </span>
                    </td>
                </tr>
                @php
                    $firstDominio = false;
                    $firstDimension = false;
                @endphp
            @endforeach
        @endforeach
    @endforeach
    </tbody>
</table>

<!-- Nivel de Riesgo Final -->
<div class="final-risk">
    <h2>Nivel de Riesgo</h2>
    <div class="score">{{ $empleado['total_score'] }}</div>
    <span class="risk-level {{ strtolower(str_replace(' ', '-', $empleado['risk_level'])) }}">{{ $empleado['risk_level'] }}</span>
</div>
<div class="conclusion">
    <h2>Necesidad de Acción</h2>
    <p>{{ $empleado['recommendation'] }}</p>
</div>
    <div class="page-break"></div>

@endforeach
</body>
</html>
