<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Queja de Violencia Laboral</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { background-color: #dc2626; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .section { margin: 20px 0; padding: 15px; border-left: 4px solid #dc2626; background-color: #f8f8f8; }
        .field { margin: 10px 0; }
        .label { font-weight: bold; color: #dc2626; }
        .urgent { background-color: #fef2f2; border: 2px solid #dc2626; padding: 15px; margin: 20px 0; border-radius: 8px; }
        h1 { margin: 0; font-size: 24px; }
        h2 { color: #dc2626; font-size: 18px; margin-top: 0; }
        h3 { color: #333; font-size: 16px; margin-top: 0; }
    </style>
</head>
<body>
<div class="header">
    <h1>🚨 NUEVA QUEJA DE VIOLENCIA LABORAL</h1>
    <p>Se ha recibido una nueva queja que requiere atención inmediata</p>
</div>

<div class="urgent">
    <h2>⚠️ ATENCIÓN URGENTE REQUERIDA</h2>
    <p>Esta queja debe ser atendida con la máxima prioridad y confidencialidad según el protocolo de la empresa.</p>
    <p><strong>Fecha de presentación:</strong> {{ \Carbon\Carbon::parse($data['fecha_presentacion'])->format('d/m/Y') }}</p>
    <p><strong>Lugar:</strong> {{ $data['ciudad'] }}, {{ $data['estado'] }}</p>
</div>

<div class="section">
    <h3>DATOS DE LA PERSONA QUE PRESENTA LA QUEJA</h3>
    <div class="field"><span class="label">Nombre:</span> {{ $data['quejoso_nombre'] }}</div>
    <div class="field"><span class="label">Puesto:</span> {{ $data['quejoso_puesto'] }}</div>
    <div class="field"><span class="label">Teléfono:</span> {{ $data['quejoso_telefono'] }}</div>
    <div class="field"><span class="label">Área:</span> {{ $data['quejoso_area'] }}</div>
    <div class="field"><span class="label">Jefe/a Inmediato:</span> {{ $data['quejoso_jefe_inmediato'] }}</div>
</div>

<div class="section">
    <h3>DATOS DE LA PERSONA SOBRE LA QUE SE PRESENTA LA QUEJA</h3>
    <div class="field"><span class="label">Nombre:</span> {{ $data['acusado_nombre'] }}</div>
    <div class="field"><span class="label">Puesto:</span> {{ $data['acusado_puesto'] }}</div>
    <div class="field"><span class="label">Teléfono:</span> {{ $data['acusado_telefono'] ?? 'No proporcionado' }}</div>
    <div class="field"><span class="label">Área:</span> {{ $data['acusado_area'] }}</div>
    <div class="field"><span class="label">Jefe/a Inmediato:</span> {{ $data['acusado_jefe_inmediato'] ?? 'No proporcionado' }}</div>
</div>

<div class="section">
    <h3>DECLARACIÓN DE HECHOS</h3>
    <div class="field"><span class="label">Fecha de ocurrencia:</span> {{ \Carbon\Carbon::parse($data['fecha_ocurrencia'])->format('d/m/Y') }}</div>
    <div class="field"><span class="label">Hora de ocurrencia:</span> {{ $data['hora_ocurrencia'] }}</div>
    <div class="field"><span class="label">Lugar de ocurrencia:</span> {{ $data['lugar_ocurrencia'] }}</div>
    <div class="field"><span class="label">Frecuencia:</span> {{ $data['frecuencia'] }}</div>
</div>

<div class="section">
    <h3>DETALLES DEL HOSTIGAMIENTO</h3>
    <div class="field">
        <span class="label">¿Cómo se manifestó el hostigamiento o acoso sexual?</span>
        <p>{{ $data['manifestacion_hostigamiento'] }}</p>
    </div>
    <div class="field">
        <span class="label">Actitud de la persona que le hostigó/acosó:</span>
        <p>{{ $data['actitud_hostigador'] }}</p>
    </div>
    <div class="field">
        <span class="label">Reacción inmediata del quejoso:</span>
        <p>{{ $data['reaccion_inmediata'] }}</p>
    </div>
</div>

<div class="section">
    <h3>IMPACTO Y AFECTACIONES</h3>
    <div class="field">
        <span class="label">¿Es un caso aislado o conoce de otros?</span>
        <p>{{ $data['caso_aislado'] }}</p>
    </div>
    <div class="field">
        <span class="label">Afectación emocional:</span>
        <p>{{ $data['afectacion_emocional'] }}</p>
    </div>
    <div class="field">
        <span class="label">Afectación en el rendimiento:</span>
        <p>{{ $data['afectacion_rendimiento'] }}</p>
    </div>
    <div class="field">
        <span class="label">Causa particular del hostigamiento:</span>
        <p>{{ $data['causa_particular'] }}</p>
    </div>
    <div class="field">
        <span class="label">Percepción del ambiente laboral:</span>
        <p>{{ $data['percepcion_ambiente_laboral'] }}</p>
    </div>
    <div class="field">
        <span class="label">Afectación a largo plazo:</span>
        <p>{{ $data['afectacion_largo_plazo'] }}</p>
    </div>
    <div class="field">
        <span class="label">¿Necesita apoyo psicológico?</span>
        <p>{{ $data['necesita_apoyo_psicologico'] }}</p>
    </div>
</div>

<div class="urgent">
    <h3>ACCIONES INMEDIATAS REQUERIDAS</h3>
    <ul>
        <li>Contactar al quejoso en un plazo máximo de 24 horas</li>
        <li>Iniciar investigación según protocolo interno</li>
        <li>Documentar todas las acciones tomadas</li>
        <li>Evaluar medidas de protección inmediatas</li>
        <li>Mantener estricta confidencialidad</li>
    </ul>
</div>

<p style="text-align: center; margin-top: 30px; font-size: 12px; color: #666;">
    Este correo es confidencial y debe ser tratado con la máxima discreción.<br>
    Generado automáticamente desde el sistema SEDyCO el {{ now()->format('d/m/Y H:i:s') }}
</p>
</body>
</html>
