<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carátula General Norma 035</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 5px;
            color: #333;
            line-height: 1.6;
            background-color: #ffffff;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            color: #007bff;
            font-size: 24px;
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
            margin-bottom: 15px;
        }
        .info-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .info-item strong {
            display: block;
            color: #007bff;
        }
        .final-score {
            text-align: center;
            margin: 10px 0;
            padding: 20px;
            background: #e9ecef;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .final-score h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .final-score .score {
            font-size: 48px;
            font-weight: bold;
            color: #007bff;
        }
        .risk-level {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
        }
        .muy-alto { background: #dc3545; }
        .alto { background: #ff9800; }
        .medio { background: #ffc107; color: #333; }
        .bajo { background: #28a745; }
        .nulo { background: #6c757d; }
        .tables-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 40px;
        }
        .table-section {
            width: 48%;
        }
        .table-section h3 {
            text-align: center;
            color: #007bff;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .charts-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        .chart-section {
            width: 80%;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .chart-section h3 {
            text-align: center;
            color: #007bff;
            margin-bottom: 15px;
        }
        .bar-chart {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .bar-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .bar-label {
            width: 250px;
            text-align: right;
            font-size: 12px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .bar {
            width: 200px; /* Ancho fijo para el contenedor */
            height: 20px;
            background: #e9ecef; /* Fondo gris claro para el contenedor */
            border-radius: 10px;
            position: relative;
            overflow: hidden; /* Asegura que el fill no se desborde */
        }

        .bar-fill {
            height: 100%;
            background: #007bff;
            border-radius: 10px 0 0 10px; /* Solo redondea el lado izquierdo */
            transition: width 0.3s ease; /* Animación opcional para debug */
        }

        .bar-value {
            position: absolute;
            right: 10px;
            top: 0;
            color: #333;
            font-size: 12px;
            line-height: 20px;
            z-index: 1; /* Asegura que el valor esté sobre el fill */
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #666;
        }
        @page {
            margin: 40px;
        }
    </style>
</head>
<body>

<!-- Encabezado -->
<div class="header">
    <h1>Carátula General</h1>
    <p>Guía de Referencia {{$guia}} - Norma Oficial Mexicana NOM-035-STPS-2018</p>
    <p>Resumen de la aplicación de cuestionario {{$guia}} Para identificar factores de Riesgo Psicosocial {{$complement}}</p>
    <p>Entre 16 y 50 colaboradores</p>
</div>

<!-- Información General -->
<div class="info-grid">
    <div class="info-item">
        <strong>Nombre de la empresa:</strong>
        {{ $company }}
    </div>
    <div class="info-item">
        <strong>Fecha inicial de aplicación:</strong>
        {{ $period}}
    </div>

</div>

<!-- Calificación Final -->
<div class="final-score">
    <h2>Calificación Final</h2>
    <div class="score">{{$calificacionG2}}</div>
    <span class="risk-level {{ strtolower(str_replace(' ', '-', $resultCuestionario)) }}">{{ $resultCuestionario }}</span>
</div>

<!-- Tablas de Categorías y Dominios -->
<div class="tables-container">
    <div class="table-section">
        <h3>Categorías</h3>
        <table>
            <thead>
            <tr>
                <th>Categoría</th>
                <th>Calificación</th>
                <th>Nivel de Riesgo</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($categories as $categoria)
                <tr>
                    <td>{{ $categoria['name'] }}</td>
                    <td>{{ $categoria['result'] }}</td>
                    <td><span class="risk-level {{ strtolower(str_replace(' ', '-', $categoria['risk_level'])) }}">{{ $categoria['risk_level'] }}</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="table-section">
        <h3>Dominios</h3>
        <table>
            <thead>
            <tr>
                <th>Dominio</th>
                <th>Calificación</th>
                <th>Nivel de Riesgo</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($domains as $dominio)
                <tr>
                    <td>{{ $dominio['name'] }}</td>
                    <td>{{ $dominio['result'] }}</td>
                    <td><span class="risk-level {{ strtolower(str_replace(' ', '-', $dominio['risk_level'])) }}">{{ $dominio['risk_level'] }}</span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Gráficos -->
<div class="charts-container">
    <div class="chart-section">
        <h3>Categorías</h3>
        <div class="bar-chart">
            @php
                $maxCategoria = max(array_column($categories, 'result'));
            @endphp
            @foreach ($categories as $categoria)
                <div class="bar-item">
                    <div class="bar-label">{{ $categoria['name'] }}</div>
                    <div class="bar"> <!-- Ancho fijo para el contenedor -->
                        <div class="bar-fill" style="width: {{ ($categoria['result'] / $maxCategoria) * 90 }}%;"></div>
                        <div class="bar-value">{{ $categoria['result'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="chart-section">
        <h3>Dominios</h3>
        <div class="bar-chart">
            @php
                $maxDominio = max(array_column($domains, 'result'));
            @endphp
            @foreach ($domains as $dominio)
                <div class="bar-item">
                    <div class="bar-label">{{ $dominio['name'] }}</div>
                    <div class="bar">
                        <div class="bar-fill" style="width: {{ ($dominio['result'] / $maxDominio) * 90 }}%;"></div>
                        <div class="bar-value">{{ $dominio['result'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Pie de Página -->
<div class="footer">
    Generado según Norma Oficial Mexicana NOM-035-STPS-2018
</div>

</body>
</html>
