# 📊 Sistema de Gráficas en Reportes NOM-035

## Descripción

El sistema genera gráficas dinámicas para el **Reporte de Perfil Sociodemográfico** (Guía II y III) usando **QuickChart.io** y **PDFShift** para la conversión a PDF.

## Características

- ✅ Gráficas comparativas por **Sexo**, **Edad** y **Tipo de Contratación**
- ✅ Análisis de riesgo psicosocial segmentado por categorías
- ✅ Conversión a base64 para máxima compatibilidad con PDFShift
- ✅ Logging detallado para diagnóstico de problemas
- ✅ Fallbacks múltiples para garantizar visualización

## Tecnologías Utilizadas

- **QuickChart.io**: Generación de gráficas desde configuración JSON
- **PDFShift**: Conversión de HTML a PDF con soporte para imágenes base64
- **Chart.js**: Biblioteca de gráficas (via QuickChart)
- **Laravel**: Framework principal

## Flujo de Generación

```
1. Recopilar datos de evaluaciones NOM-035
   ↓
2. Analizar por variables sociodemográficas (sexo, edad, contrato)
   ↓
3. Generar configuración JSON para cada gráfica
   ↓
4. Obtener URLs de QuickChart con las gráficas renderizadas
   ↓
5. Descargar imágenes PNG
   ↓
6. Convertir a base64 para inclusión en HTML
   ↓
7. Renderizar vista Blade con imágenes embebidas
   ↓
8. Enviar a PDFShift para conversión a PDF
```

## Métodos Principales

### `downloadSociodemographicProfile()`
Método principal que orquesta todo el proceso de generación del reporte.

**Ubicación:** `app/Filament/Pages/Nom035.php`

### `generateCategoryRiskAnalysis()`
Analiza los riesgos por categoría según variables sociodemográficas.

### `generateCategoryBySexChart()`
Genera la URL de QuickChart para la gráfica comparativa por sexo.

### `generateCategoryByAgeChart()`
Genera la URL de QuickChart para la gráfica comparativa por edad.

### `generateCategoryByContractChart()`
Genera la URL de QuickChart para la gráfica comparativa por tipo de contratación.

## Logging y Diagnóstico

El sistema incluye logging detallado para facilitar el diagnóstico:

```php
Log::info('📊 Iniciando generación de gráficas');
Log::info('🔄 Generando gráfica por Sexo...');
Log::info('📍 URL de gráfica generada', ['url' => $chartUrl]);
Log::info('🖼️ Descargando imagen');
Log::info('✅ Imagen guardada correctamente');
```

### Revisar logs:

```bash
# Ver últimas 100 líneas
tail -n 100 storage/logs/laravel.log

# Filtrar solo mensajes de gráficas
grep -E "📊|🔄|📍|🖼️|✅|⚠️" storage/logs/laravel.log
```

## Configuración Requerida

### 1. API Key de PDFShift

Agregar en `.env`:
```env
PDFSHIFT_API_KEY=tu_api_key_aqui
```

Configurar en `config/services.php`:
```php
'pdfshift' => [
    'api_key' => env('PDFSHIFT_API_KEY'),
],
```

### 2. Habilitar `allow_url_fopen` en PHP

Verificar en `php.ini`:
```ini
allow_url_fopen = On
```

### 3. Directorio temporal

El sistema crea automáticamente:
```
storage/app/livewire-tmp/
```

## Solución de Problemas

### Las gráficas no aparecen en el PDF

**Revisar logs:**
1. Busca mensajes con emoji 📊 🔄 📍 🖼️
2. Verifica que todos terminen con ✅
3. Si hay ⚠️, identifica la causa

**Causas comunes:**
- ❌ No hay conexión a internet (QuickChart no responde)
- ❌ `allow_url_fopen` deshabilitado
- ❌ No hay evaluaciones NOM-035 completadas
- ❌ API key de PDFShift incorrecta

### Error al descargar imágenes

```
⚠️ No se pudo descargar la imagen de Sexo
```

**Solución:**
```bash
# Verificar configuración PHP
php -i | grep allow_url_fopen

# Debe mostrar: allow_url_fopen => On => On
```

### No hay datos de categoryAnalysis

```
⚠️ No hay datos de categoryAnalysis[by_sex]
```

**Causa:** No hay suficientes evaluaciones de NOM-035.

**Solución:** Asegurarse de que haya usuarios con evaluaciones completadas.

## Vista del Reporte

El reporte incluye:

### Sección 1-3: Datos Sociodemográficos
- Distribución por sexo, edad, estado civil, etc.
- Datos laborales (departamento, puesto, contrato)
- Experiencia laboral

### Sección 4: Análisis de Riesgo Segmentado
- Riesgo promedio por sexo
- Riesgo promedio por edad
- Riesgo promedio por tipo de contrato
- Riesgo promedio por departamento
- Riesgo promedio por jornada laboral

### Sección 5: Análisis Comparativo (CON GRÁFICAS)
- **5.1** Grupos de mayor riesgo identificados
- **5.2** Riesgo por categoría según Sexo 📊
- **5.3** Riesgo por categoría según Edad 📊
- **5.4** Riesgo por categoría según Tipo de Contratación 📊

## Archivos Relacionados

```
app/Filament/Pages/Nom035.php                          # Lógica principal
resources/views/filament/pages/nom35/
  └── sociodemographic_profile.blade.php               # Vista del reporte
storage/logs/laravel.log                               # Logs del sistema
```

## Mantenimiento

### Actualizar estilos de gráficas

Modificar la configuración JSON en los métodos `generateCategoryBy*Chart()`:

```php
'options' => [
    'plugins' => [
        'title' => [
            'font' => ['size' => 18] // Cambiar tamaño
        ]
    ]
]
```

### Cambiar colores

```php
$colors = [
    'Masculino' => '#3b82f6',  // Azul
    'Femenino' => '#ec4899',   // Rosa
    'Otro' => '#8b5cf6'        // Morado
];
```

### Ajustar tamaño de imágenes

Las gráficas de QuickChart son 1000x600px por defecto. Para cambiar:

```
https://quickchart.io/chart?width=800&height=400&c={config}
```

## Referencias

- [QuickChart Documentation](https://quickchart.io/documentation/)
- [PDFShift Documentation](https://pdfshift.io/documentation)
- [Chart.js Documentation](https://www.chartjs.org/docs/)
- [NOM-035-STPS-2018](http://www.stps.gob.mx/bp/secciones/dgsst/normatividad/normas/Nom-035.pdf)

---

**Última actualización:** 2026-02-17  
**Versión:** 1.0

