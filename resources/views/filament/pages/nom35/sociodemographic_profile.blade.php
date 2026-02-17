<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Sociodemográfico - NOM-035</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .header h1 {
            color: #007bff;
            font-size: 24px;
            margin: 10px 0;
        }
        .header p {
            font-size: 14px;
            color: #555;
            margin: 5px 0;
        }
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .section h2 {
            color: #007bff;
            font-size: 18px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .section h3 {
            color: #495057;
            font-size: 16px;
            margin-top: 15px;
            margin-bottom: 10px;
        }
        .data-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }
        .data-item {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 6px;
            border-left: 3px solid #007bff;
        }
        .data-item strong {
            color: #007bff;
            display: block;
            margin-bottom: 5px;
        }
        .data-item span {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th {
            background: #007bff;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 13px;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #dee2e6;
            font-size: 12px;
        }
        table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .chart-container {
            margin: 15px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .bar-chart {
            display: flex;
            align-items: flex-end;
            height: 200px;
            gap: 10px;
            margin-top: 10px;
        }
        .bar {
            flex: 1;
            background: #007bff;
            border-radius: 4px 4px 0 0;
            position: relative;
            min-height: 20px;
        }
        .bar-label {
            text-align: center;
            font-size: 11px;
            margin-top: 5px;
            color: #555;
        }
        .bar-value {
            position: absolute;
            top: -20px;
            width: 100%;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
        }
        .risk-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            color: white;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        .risk-muy-alto { background: #dc3545; }
        .risk-alto { background: #ff9800; }
        .risk-medio { background: #ffc107; color: #333; }
        .risk-bajo { background: #28a745; }
        .risk-nulo { background: #6c757d; }
        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 13px;
        }
        .alert-info {
            background: #d1ecf1;
            border-left: 4px solid #0c5460;
            color: #0c5460;
        }
        .percentage {
            font-size: 11px;
            color: #6c757d;
            margin-left: 5px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>Perfil Sociodemográfico</h1>
        <p><strong>Empresa:</strong> {{ $company }}</p>
        <p><strong>Fecha del Reporte:</strong> {{ $reportDate }}</p>
        <p><strong>Período:</strong> {{ $period }}</p>
        <p><strong>Guía Aplicada:</strong> Guía {{ $guiaType }} - NOM-035-STPS-2018</p>
    </div>

    <!-- Resumen General -->
    <div class="section">
        <h2>Resumen General</h2>
        <div class="alert alert-info">
            <strong>Total de Colaboradores:</strong> {{ $totalCollaborators }}
            <br>
            Este reporte presenta el perfil sociodemográfico de la plantilla laboral de acuerdo a la <strong>Guía V de la NOM-035-STPS-2018</strong>.
            Los datos se presentan de forma agregada para respetar la confidencialidad.
        </div>
    </div>

    <!-- SECCIÓN 1: DATOS PERSONALES -->
    <div class="section">
        <h2>1. Datos Personales</h2>

        <!-- Distribución por Sexo -->
        <h3>1.1 Distribución por Sexo</h3>
        <table>
            <thead>
                <tr>
                    <th>Sexo</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profileData['sex'] as $sex => $count)
                    @if($count > 0)
                    <tr>
                        <td>{{ $sex }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ number_format(($count / $totalCollaborators) * 100, 1) }}%</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <!-- Distribución por Edad -->
        <h3>1.2 Distribución por Rango de Edad</h3>
        <table>
            <thead>
                <tr>
                    <th>Rango de Edad</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profileData['age'] as $range => $count)
                    @if($count > 0)
                    <tr>
                        <td>{{ $range }} años</td>
                        <td>{{ $count }}</td>
                        <td>{{ number_format(($count / $totalCollaborators) * 100, 1) }}%</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <!-- Estado Civil -->
        <h3>1.3 Estado Civil</h3>
        <table>
            <thead>
                <tr>
                    <th>Estado Civil</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profileData['marital_status'] as $status => $count)
                    @if($count > 0)
                    <tr>
                        <td>{{ $status ?? 'No especificado' }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ number_format(($count / $totalCollaborators) * 100, 1) }}%</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <!-- Nivel de Estudios -->
        <h3>1.4 Nivel de Estudios</h3>
        <table>
            <thead>
                <tr>
                    <th>Nivel Educativo</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profileData['scholarship'] as $level => $count)
                    @if($count > 0)
                    <tr>
                        <td>{{ $level ?? 'No especificado' }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ number_format(($count / $totalCollaborators) * 100, 1) }}%</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- SECCIÓN 2: DATOS LABORALES -->
    <div class="section">
        <h2>2. Datos Laborales</h2>

        <!-- Distribución por Departamento -->
        <h3>2.1 Distribución por Departamento/Área</h3>
        <table>
            <thead>
                <tr>
                    <th>Departamento</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profileData['department'] as $dept => $count)
                    @if($count > 0)
                    <tr>
                        <td>{{ $dept ?? 'No especificado' }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ number_format(($count / $totalCollaborators) * 100, 1) }}%</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <!-- Distribución por Puesto -->
        <h3>2.2 Distribución por Puesto</h3>
        <table>
            <thead>
                <tr>
                    <th>Puesto</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profileData['position'] as $pos => $count)
                    @if($count > 0)
                    <tr>
                        <td>{{ $pos ?? 'No especificado' }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ number_format(($count / $totalCollaborators) * 100, 1) }}%</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <!-- Tipo de Contratación -->
        <h3>2.3 Tipo de Contratación</h3>
        <table>
            <thead>
                <tr>
                    <th>Tipo de Contrato</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profileData['contract_type'] as $type => $count)
                    @if($count > 0)
                    <tr>
                        <td>{{ $type ?? 'No especificado' }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ number_format(($count / $totalCollaborators) * 100, 1) }}%</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <!-- Tipo de Personal -->
        <h3>2.4 Tipo de Personal</h3>
        <table>
            <thead>
                <tr>
                    <th>Tipo de Personal</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profileData['staff_type'] as $type => $count)
                    @if($count > 0)
                    <tr>
                        <td>{{ $type ?? 'No especificado' }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ number_format(($count / $totalCollaborators) * 100, 1) }}%</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <!-- Tipo de Jornada -->
        <h3>2.5 Tipo de Jornada</h3>
        <table>
            <thead>
                <tr>
                    <th>Jornada</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profileData['work_shift'] as $shift => $count)
                    @if($count > 0)
                    <tr>
                        <td>{{ $shift ?? 'No especificado' }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ number_format(($count / $totalCollaborators) * 100, 1) }}%</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <!-- Rotación de Turnos -->
        <h3>2.6 Rotación de Turnos</h3>
        <table>
            <thead>
                <tr>
                    <th>Rota Turnos</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profileData['rotates_shifts'] as $rotates => $count)
                    @if($count > 0)
                    <tr>
                        <td>{{ $rotates }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ number_format(($count / $totalCollaborators) * 100, 1) }}%</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- SECCIÓN 3: EXPERIENCIA LABORAL -->
    <div class="section">
        <h2>3. Experiencia Laboral</h2>

        <!-- Tiempo en el Puesto Actual -->
        <h3>3.1 Tiempo en el Puesto Actual</h3>
        <table>
            <thead>
                <tr>
                    <th>Rango</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profileData['time_in_position'] as $range => $count)
                    @if($count > 0)
                    <tr>
                        <td>{{ $range }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ number_format(($count / $totalCollaborators) * 100, 1) }}%</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <!-- Experiencia Laboral Total -->
        <h3>3.2 Experiencia Laboral Total</h3>
        <table>
            <thead>
                <tr>
                    <th>Rango</th>
                    <th>Cantidad</th>
                    <th>Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profileData['experience_years'] as $range => $count)
                    @if($count > 0)
                    <tr>
                        <td>{{ $range }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ number_format(($count / $totalCollaborators) * 100, 1) }}%</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- SECCIÓN 4: ANÁLISIS DE RIESGO PSICOSOCIAL SEGMENTADO (Solo para Guía II y III) -->
    @if(($level === 2 || $level === 3 ) && $riskAnalysis)
    <div class="section" style="page-break-before: always;">
        <h2>4. Análisis de Riesgo Psicosocial Segmentado</h2>

        <div class="alert alert-info">
            <strong>Nota:</strong> Este análisis muestra cómo se distribuyen los niveles de riesgo psicosocial
            según las diferentes variables sociodemográficas. Permite identificar grupos vulnerables que requieren
            atención prioritaria.
        </div>

        <!-- 4.1 Análisis por Sexo -->
        @if(isset($riskAnalysis['by_sex']) && count($riskAnalysis['by_sex']) > 0)
        <h3>4.1 Riesgo por Sexo</h3>
        <table>
            <thead>
                <tr>
                    <th>Sexo</th>
                    <th>N° Colaboradores</th>
                    <th>Puntuación Promedio</th>
                    <th>Nivel de Riesgo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riskAnalysis['by_sex'] as $sex => $data)
                <tr>
                    <td>{{ $sex }}</td>
                    <td>{{ $data['count'] }}</td>
                    <td>{{ $data['avg_score'] }}</td>
                    <td>
                        @php
                            $riskClass = strtolower(str_replace(' ', '-', $data['risk_level']));
                        @endphp
                        <span class="risk-badge risk-{{ $riskClass }}">{{ $data['risk_level'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- 4.2 Análisis por Edad -->
        @if(isset($riskAnalysis['by_age']) && count($riskAnalysis['by_age']) > 0)
        <h3>4.2 Riesgo por Rango de Edad</h3>
        <table>
            <thead>
                <tr>
                    <th>Rango de Edad</th>
                    <th>N° Colaboradores</th>
                    <th>Puntuación Promedio</th>
                    <th>Nivel de Riesgo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riskAnalysis['by_age'] as $age => $data)
                <tr>
                    <td>{{ $age }} años</td>
                    <td>{{ $data['count'] }}</td>
                    <td>{{ $data['avg_score'] }}</td>
                    <td>
                        @php
                            $riskClass = strtolower(str_replace(' ', '-', $data['risk_level']));
                        @endphp
                        <span class="risk-badge risk-{{ $riskClass }}">{{ $data['risk_level'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- 4.3 Análisis por Departamento -->
        @if(isset($riskAnalysis['by_department']) && count($riskAnalysis['by_department']) > 0)
        <h3>4.3 Riesgo por Departamento</h3>
        <table>
            <thead>
                <tr>
                    <th>Departamento</th>
                    <th>N° Colaboradores</th>
                    <th>Puntuación Promedio</th>
                    <th>Nivel de Riesgo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riskAnalysis['by_department'] as $dept => $data)
                <tr>
                    <td>{{ $dept }}</td>
                    <td>{{ $data['count'] }}</td>
                    <td>{{ $data['avg_score'] }}</td>
                    <td>
                        @php
                            $riskClass = strtolower(str_replace(' ', '-', $data['risk_level']));
                        @endphp
                        <span class="risk-badge risk-{{ $riskClass }}">{{ $data['risk_level'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- 4.4 Análisis por Tipo de Contratación -->
        @if(isset($riskAnalysis['by_contract']) && count($riskAnalysis['by_contract']) > 0)
        <h3>4.4 Riesgo por Tipo de Contratación</h3>
        <table>
            <thead>
                <tr>
                    <th>Tipo de Contrato</th>
                    <th>N° Colaboradores</th>
                    <th>Puntuación Promedio</th>
                    <th>Nivel de Riesgo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riskAnalysis['by_contract'] as $contract => $data)
                <tr>
                    <td>{{ $contract }}</td>
                    <td>{{ $data['count'] }}</td>
                    <td>{{ $data['avg_score'] }}</td>
                    <td>
                        @php
                            $riskClass = strtolower(str_replace(' ', '-', $data['risk_level']));
                        @endphp
                        <span class="risk-badge risk-{{ $riskClass }}">{{ $data['risk_level'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- 4.5 Análisis por Tipo de Jornada -->
        @if(isset($riskAnalysis['by_shift']) && count($riskAnalysis['by_shift']) > 0)
        <h3>4.5 Riesgo por Tipo de Jornada</h3>
        <table>
            <thead>
                <tr>
                    <th>Jornada</th>
                    <th>N° Colaboradores</th>
                    <th>Puntuación Promedio</th>
                    <th>Nivel de Riesgo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riskAnalysis['by_shift'] as $shift => $data)
                <tr>
                    <td>{{ $shift }}</td>
                    <td>{{ $data['count'] }}</td>
                    <td>{{ $data['avg_score'] }}</td>
                    <td>
                        @php
                            $riskClass = strtolower(str_replace(' ', '-', $data['risk_level']));
                        @endphp
                        <span class="risk-badge risk-{{ $riskClass }}">{{ $data['risk_level'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- 4.6 Análisis por Rotación de Turnos -->
        @if(isset($riskAnalysis['by_rotation']) && count($riskAnalysis['by_rotation']) > 0)
        <h3>4.6 Riesgo por Rotación de Turnos</h3>
        <table>
            <thead>
                <tr>
                    <th>Rota Turnos</th>
                    <th>N° Colaboradores</th>
                    <th>Puntuación Promedio</th>
                    <th>Nivel de Riesgo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riskAnalysis['by_rotation'] as $rotation => $data)
                <tr>
                    <td>{{ $rotation }}</td>
                    <td>{{ $data['count'] }}</td>
                    <td>{{ $data['avg_score'] }}</td>
                    <td>
                        @php
                            $riskClass = strtolower(str_replace(' ', '-', $data['risk_level']));
                        @endphp
                        <span class="risk-badge risk-{{ $riskClass }}">{{ $data['risk_level'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    @endif

    <!-- SECCIÓN 5: ANÁLISIS COMPARATIVO POR CATEGORÍAS (Solo para Guía II y III) -->
    @if(($level === 2 || $level === 3) && $categoryAnalysis)
    <div class="section" style="page-break-before: always;">
        <h2>5. Análisis Comparativo: Riesgo por Categorías según Variables Sociodemográficas</h2>

        <div class="alert alert-info">
            <strong>Análisis Estratégico:</strong> Esta sección contrasta los niveles de riesgo psicosocial por categoría
            (Ambiente de Trabajo, Factores de la Actividad, Organización del Tiempo, Liderazgo{{ $level === 3 ? ', Entorno Organizacional' : '' }})
            según las variables sociodemográficas clave. Permite identificar qué grupos específicos presentan mayor vulnerabilidad en cada área.
        </div>

        <!-- 5.1 Hallazgos Clave -->
        @if(isset($categoryAnalysis['top_risks']) && count($categoryAnalysis['top_risks']) > 0)
        <h3>5.1 Grupos de Mayor Riesgo Identificados</h3>
        <table>
            <thead>
                <tr>
                    <th>Variable</th>
                    <th>Segmento</th>
                    <th>Categoría</th>
                    <th>N° Personas</th>
                    <th>Puntuación</th>
                    <th>Nivel de Riesgo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categoryAnalysis['top_risks'] as $risk)
                @php
                    $rowBg = '#fff';
                    if ($risk['risk_level'] === 'Muy Alto') {
                        $rowBg = '#ffe5e5';
                    } elseif ($risk['risk_level'] === 'Alto') {
                        $rowBg = '#fff3e0';
                    }
                @endphp
                <tr style="background: {{ $rowBg }};">
                    <td><strong>{{ $risk['dimension'] }}</strong></td>
                    <td>{{ $risk['segment'] }}</td>
                    <td>{{ $risk['category'] }}</td>
                    <td>{{ $risk['count'] }}</td>
                    <td>{{ $risk['avg_score'] }}</td>
                    <td>
                        @php
                            $riskClass = strtolower(str_replace(' ', '-', $risk['risk_level']));
                        @endphp
                        <span class="risk-badge risk-{{ $riskClass }}">{{ $risk['risk_level'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- 5.2 Comparativo por Sexo -->
        @if(isset($categoryAnalysis['by_sex']) && count($categoryAnalysis['by_sex']) > 0)
        <h3 style="margin-top: 30px;">5.2 Riesgo por Categoría según Sexo</h3>

        @if(isset($chartPaths['sex']) && file_exists($chartPaths['sex']))
        <div style="text-align: center; margin: 20px 0;">
            <img src="{{ $chartPaths['sex'] }}" alt="Gráfica por Sexo" style="max-width: 100%; height: auto;">
        </div>
        @endif

        <table style="margin-top: 15px;">
            <thead>
                <tr>
                    <th>Sexo</th>
                    <th>Categoría</th>
                    <th>Puntuación Promedio</th>
                    <th>Nivel de Riesgo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categoryAnalysis['by_sex'] as $sex => $categories)
                    @foreach($categories as $categoryKey => $data)
                    <tr>
                        <td><strong>{{ $sex }}</strong></td>
                        <td>{{ $data['name'] }}</td>
                        <td>{{ $data['avg_score'] }}</td>
                        <td>
                            @php
                                $riskClass = strtolower(str_replace(' ', '-', $data['risk_level']));
                            @endphp
                            <span class="risk-badge risk-{{ $riskClass }}">{{ $data['risk_level'] }}</span>
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- 5.3 Comparativo por Edad -->
        @if(isset($categoryAnalysis['by_age']) && count($categoryAnalysis['by_age']) > 0)
        <h3 style="margin-top: 30px;">5.3 Riesgo por Categoría según Rango de Edad</h3>

        @if(isset($chartPaths['age']) && file_exists($chartPaths['age']))
        <div style="text-align: center; margin: 20px 0;">
            <img src="{{ $chartPaths['age'] }}" alt="Gráfica por Edad" style="max-width: 100%; height: auto;">
        </div>
        @endif

        <table style="margin-top: 15px;">
            <thead>
                <tr>
                    <th>Rango de Edad</th>
                    <th>Categoría</th>
                    <th>Puntuación Promedio</th>
                    <th>Nivel de Riesgo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categoryAnalysis['by_age'] as $age => $categories)
                    @foreach($categories as $categoryKey => $data)
                    <tr>
                        <td><strong>{{ $age }} años</strong></td>
                        <td>{{ $data['name'] }}</td>
                        <td>{{ $data['avg_score'] }}</td>
                        <td>
                            @php
                                $riskClass = strtolower(str_replace(' ', '-', $data['risk_level']));
                            @endphp
                            <span class="risk-badge risk-{{ $riskClass }}">{{ $data['risk_level'] }}</span>
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- 5.4 Comparativo por Tipo de Contratación -->
        @if(isset($categoryAnalysis['by_contract']) && count($categoryAnalysis['by_contract']) > 0)
        <h3 style="margin-top: 30px;">5.4 Riesgo por Categoría según Tipo de Contratación</h3>

        @if(isset($chartPaths['contract']) && file_exists($chartPaths['contract']))
        <div style="text-align: center; margin: 20px 0;">
            <img src="{{ $chartPaths['contract'] }}" alt="Gráfica por Contratación" style="max-width: 100%; height: auto;">
        </div>
        @endif

        <table style="margin-top: 15px;">
            <thead>
                <tr>
                    <th>Tipo de Contrato</th>
                    <th>Categoría</th>
                    <th>Puntuación Promedio</th>
                    <th>Nivel de Riesgo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categoryAnalysis['by_contract'] as $contract => $categories)
                    @foreach($categories as $categoryKey => $data)
                    <tr>
                        <td><strong>{{ $contract }}</strong></td>
                        <td>{{ $data['name'] }}</td>
                        <td>{{ $data['avg_score'] }}</td>
                        <td>
                            @php
                                $riskClass = strtolower(str_replace(' ', '-', $data['risk_level']));
                            @endphp
                            <span class="risk-badge risk-{{ $riskClass }}">{{ $data['risk_level'] }}</span>
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    @endif

</body>
</html>

