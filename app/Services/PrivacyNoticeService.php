<?php

namespace App\Services;

use App\Models\PrivacyNotice;
use App\Models\PrivacyNoticeAcceptance;
use App\Models\Sede;
use App\Models\User;

class PrivacyNoticeService
{
    /**
     * Verifica de forma ultra-rápida (Caché + Sesión + Índice Único B-Tree)
     * si el usuario ya aceptó el aviso de privacidad vigente.
     */
    public function hasUserAcceptedActiveNotice(?User $user): bool
    {
        if (!$user) {
            return true;
        }

        $activeNotice = PrivacyNotice::getActive();

        if (!$activeNotice) {
            return true;
        }

        $sessionKey = $this->getSessionAcceptanceKey($user->id);

        if (session($sessionKey) === $activeNotice->id) {
            return true;
        }

        // Consulta optimizada usando el índice único compuesto uq_privacy_notice_user (privacy_notice_id, user_id)
        $hasAccepted = PrivacyNoticeAcceptance::query()
            ->where('privacy_notice_id', $activeNotice->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($hasAccepted) {
            session([$sessionKey => $activeNotice->id]);
        }

        return $hasAccepted;
    }

    /**
     * Resuelve los datos dinámicos del Responsable según el tipo de configuración (scope_type)
     * del Aviso de Privacidad y las relaciones del colaborador en ADC (Sede / Razón Social).
     */
    public function resolveDataForUser(PrivacyNotice $notice, ?User $user): array
    {
        $user?->loadMissing(['sede']);

        $providerName = trim((string) ($notice->provider_name ?: 'NetInnfode'));
        $fallbackCompany = trim((string) ($notice->general_company_name ?: ''));
        $fallbackAddress = trim((string) ($notice->general_address ?: ''));

        $companyName = '';
        $address = '';

        if ($notice->scope_type === PrivacyNotice::SCOPE_RAZON_SOCIAL) {
            $companyName = $user?->sede?->company_name
                ?: $fallbackCompany
                ?: $user?->sede?->name;

            $address = $this->formatSedeAddress($user?->sede)
                ?: $fallbackAddress;
        } elseif ($notice->scope_type === PrivacyNotice::SCOPE_SEDE) {
            $companyName = $user?->sede?->company_name
                ?: $user?->sede?->name
                ?: $fallbackCompany;

            $address = $this->formatSedeAddress($user?->sede)
                ?: $fallbackAddress;
        } else {
            // SCOPE_GENERAL: Usa los valores generales configurados en el aviso
            $companyName = $notice->general_company_name
                ?: $user?->sede?->company_name
                ?: $user?->sede?->name
                ?: '';

            $address = $notice->general_address
                ?: $this->formatSedeAddress($user?->sede)
                ?: '';
        }

        // Fallback si el usuario administrativo no tiene sede asignada ni hay nombre general configurado
        if (empty($companyName)) {
            $companyName = Sede::where('status', 1)
                ->whereNotNull('company_name')
                ->where('company_name', '!=', '')
                ->value('company_name')
                ?: Sede::where('status', 1)->value('name')
                ?: Sede::value('company_name')
                ?: Sede::value('name')
                ?: 'LA EMPRESA CONTRATANTE';
        }

        if (empty($address)) {
            $firstSedeWithAddress = Sede::where('status', 1)
                ->whereNotNull('address')
                ->where('address', '!=', '')
                ->first()
                ?: Sede::whereNotNull('address')
                    ->where('address', '!=', '')
                    ->first();

            $address = $this->formatSedeAddress($firstSedeWithAddress) ?: '';
        }

        return [
            'provider_name' => $providerName,
            'company_name' => trim((string) $companyName),
            'address' => trim((string) $address),
            'razon_social_name' => $user?->sede?->company_name,
            'sede_name' => $user?->sede?->name,
        ];
    }

    /**
     * Reemplaza las variables dinámicas en el HTML del aviso con los datos resueltos del usuario.
     */
    public function renderContent(?string $content, array $resolvedData): string
    {
        if (empty($content)) {
            return '';
        }

        $provider = e($resolvedData['provider_name'] ?? 'NetInnfode');
        $company = e($resolvedData['company_name'] ?? '');
        $address = e($resolvedData['address'] ?? '');

        $replacements = [
            '[NOMBRE DE LA EMPRESA PROVEEDORA]' => '<strong>' . $provider . '</strong>',
            '{empresa_proveedora}' => '<strong>' . $provider . '</strong>',
            '[NOMBRE DE LA EMPRESA CONTRATANTE]' => '<strong>' . $company . '</strong>',
            '[NOMBRE DE LA EMPRESA / uno por cada empresa]' => '<strong>' . $company . '</strong>',
            '[NOMBRE DE LA EMPRESA / UNO POR CADA EMPRESA]' => '<strong>' . $company . '</strong>',
            '[NOMBRE DE LA EMPRESA]' => '<strong>' . $company . '</strong>',
            '{empresa_contratante}' => '<strong>' . $company . '</strong>',
            '{razon_social}' => '<strong>' . $company . '</strong>',
            '[DIRECCIÓN COMPLETA]' => '<strong>' . $address . '</strong>',
            '[DIRECCION COMPLETA]' => '<strong>' . $address . '</strong>',
            '{direccion_completa}' => '<strong>' . $address . '</strong>',
            '{direccion_fiscal}' => '<strong>' . $address . '</strong>',
        ];

        return str_ireplace(array_keys($replacements), array_values($replacements), $content);
    }

    /**
     * Registra la aceptación del aviso de privacidad por parte del usuario.
     */
    public function recordAcceptance(
        PrivacyNotice $notice,
        User $user,
        ?string $ipAddress = null,
        ?string $userAgent = null
    ): PrivacyNoticeAcceptance {
        $resolved = $this->resolveDataForUser($notice, $user);

        $acceptance = PrivacyNoticeAcceptance::updateOrCreate(
            [
                'privacy_notice_id' => $notice->id,
                'user_id' => $user->id,
            ],
            [
                'sede_id' => $user->sede_id,
                'resolved_company_name' => $resolved['company_name'],
                'resolved_address' => $resolved['address'],
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'accepted_at' => now(),
            ]
        );

        session([$this->getSessionAcceptanceKey($user->id) => $notice->id]);

        return $acceptance;
    }

    /**
     * Formatea la dirección completa de una Sede si cuenta con campos capturados.
     */
    public function formatSedeAddress(?Sede $sede): ?string
    {
        if (!$sede) {
            return null;
        }

        if (empty(trim((string) $sede->address))) {
            return null;
        }

        $parts = array_filter([
            trim((string) $sede->address),
            $sede->cp ? 'C.P. ' . trim((string) $sede->cp) : null,
            trim((string) $sede->city),
            trim((string) $sede->state),
        ]);

        return !empty($parts) ? implode(', ', $parts) : null;
    }

    public function getSessionAcceptanceKey(int $userId): string
    {
        return "adc_privacy_accepted_user_{$userId}";
    }

    /**
     * Plantilla por defecto del Encabezado de Entrada (Paso Inicial):
     * Aviso Importante sobre Protección de Datos Personales.
     */
    public static function getDefaultInitialContent(): string
    {
        return <<<'HTML'
<p><strong>Aviso Importante sobre Protección de Datos Personales:</strong> La presente plataforma es proporcionada por [NOMBRE DE LA EMPRESA PROVEEDORA] exclusivamente como herramienta tecnológica. Los datos personales ingresados y tratados a través de la misma son responsabilidad de [NOMBRE DE LA EMPRESA CONTRATANTE], quien actúa como Responsable del tratamiento conforme a la Ley Federal de Protección de Datos Personales en Posesión de los Particulares y pone a disposición de los titulares el Aviso de Privacidad correspondiente.</p>
HTML;
    }

    /**
     * Plantilla oficial por defecto del Aviso de Privacidad Simplificado:
     * Acceso a Plataformas y Sistemas Institucionales de Recursos Humanos.
     */
    public static function getDefaultSimplifiedContent(): string
    {
        return <<<'HTML'
<h3>AVISO DE PRIVACIDAD SIMPLIFICADO</h3>
<h4>ACCESO A PLATAFORMAS Y SISTEMAS INSTITUCIONALES DE RECURSOS HUMANOS</h4>

<h4>1. Identidad y Carácter de las Partes</h4>
<p>[NOMBRE DE LA EMPRESA PROVEEDORA] actúa exclusivamente como proveedor de la plataforma tecnológica mediante la cual [NOMBRE DE LA EMPRESA CONTRATANTE] recaba y administra datos personales. De conformidad con los artículos 3, fracciones XIV y XVI, y demás aplicables de la Ley Federal de Protección de Datos Personales en Posesión de los Particulares, [NOMBRE DE LA EMPRESA CONTRATANTE] tiene el carácter de responsable del tratamiento de los datos personales, al determinar las finalidades y medios de dicho tratamiento, siendo la única responsable del cumplimiento de las obligaciones previstas en la legislación aplicable en materia de protección de datos personales, incluyendo la observancia de los principios de licitud, consentimiento, información, calidad, finalidad, lealtad, proporcionalidad y responsabilidad; la implementación de medidas de seguridad; así como la atención de los derechos de Acceso, Rectificación, Cancelación y Oposición (ARCO) de los titulares.</p>
<p>[NOMBRE DE LA EMPRESA PROVEEDORA] no determina las finalidades del tratamiento ni utiliza los datos personales para fines propios, limitando su intervención a la prestación de los servicios tecnológicos contratados.</p>

<h4>2. Finalidades del Tratamiento</h4>
<p>Los datos personales que recabamos a través de nuestras plataformas y sistemas serán utilizados para las siguientes finalidades primarias, necesarias para garantizar la seguridad de la información, evaluación y la continuidad operativa:</p>

<p><strong>Gestión de Identidad y Acceso:</strong></p>
<ul>
    <li>Verificar la identidad de los usuarios.</li>
    <li>Administrar credenciales de acceso.</li>
    <li>Gestionar perfiles, permisos y niveles de autorización dentro de los sistemas corporativos.</li>
    <li>Controlar el acceso a información, aplicaciones y recursos tecnológicos.</li>
</ul>

<p><strong>Evaluación Psicometría y Gestión de RR.HH.:</strong></p>
<ul>
    <li>Aplicación, procesamiento y análisis de evaluaciones psicométricas y de perfil laboral.</li>
    <li>Generación y administración de expedientes e informes de evaluación de colaboradores y candidatos.</li>
</ul>

<p><strong>Seguridad de la Información y Monitoreo:</strong></p>
<ul>
    <li>Registrar y auditar actividades realizadas dentro de las plataformas.</li>
</ul>

<h4>3. Uso de Herramientas Tecnológicas Externas y Remisión de Información</h4>
<p>[NOMBRE DE LA EMPRESA CONTRATANTE] no vende, alquila ni transfiere sus datos personales a terceros. No obstante, para el correcto funcionamiento del sistema de Recursos Humanos, la información podrá ser procesada técnicamente a través de:</p>
<ul>
    <li><strong>Servicios de Inteligencia Artificial:</strong> Integración de datos de identificación y resultados psicométricos con servicios de procesamiento de texto vía API, con la finalidad exclusiva de redactar el reporte de perfil psicométrico.</li>
    <li><strong>Servicios de Procesamiento de Documentos:</strong> Transmisión temporal de archivos a APIs especializadas únicamente para la conversión de formatos y generación de reportes descargables.</li>
</ul>
<p>Los proveedores de dichos servicios integrados procesan la información de manera encriptada y automatizada, actuando únicamente como procesadores tecnológicos (Encargados) bajo los términos de la legislación aplicable en materia de protección de datos.</p>

<h4>4. Medios y Procedimiento para el Ejercicio de Derechos ARCO</h4>
<p>Para ejercer sus derechos de Acceso, Rectificación, Cancelación u Oposición (ARCO), así como para revocar su consentimiento, el titular o su representante legal podrán enviar una solicitud formal al correo electrónico <a href="mailto:ventas@netinnfode.com">ventas@netinnfode.com</a> o presentarla por escrito directamente en las oficinas de Recursos Humanos de [NOMBRE DE LA EMPRESA CONTRATANTE]. Dicha solicitud deberá cumplir con los requisitos establecidos en la ley aplicable y será atendida dentro de los plazos legales correspondientes.</p>

<h4>5. Fundamento Jurídico</h4>
<p>El tratamiento de los datos personales asociados al acceso y uso de las plataformas digitales corporativas se encuentra sustentado en:</p>
<ul>
    <li><strong>Marco Constitucional:</strong> Artículos 6° y 16 de la Constitución Política de los Estados Unidos Mexicanos, relativos al derecho a la privacidad y protección de datos personales.</li>
    <li><strong>Marco Legal:</strong> Ley Federal de Protección de Datos Personales en Posesión de los Particulares, Ley Federal del Trabajo, Ley General de Responsabilidades Administrativas y demás disposiciones legales aplicables en materia laboral, tecnológica, seguridad de la información y cumplimiento corporativo.</li>
</ul>

<h4>6. Consulta del Aviso de Privacidad Integral</h4>
<p>El presente documento constituye un Aviso de Privacidad Simplificado. Para conocer los términos completos del tratamiento de sus datos personales, la política de seguridad y los detalles extendidos de la protección de su información, puede consultar el Aviso de Privacidad Integral o solicitarlo en el Departamento de Recursos Humanos.</p>
HTML;
    }

    /**
     * Plantilla por defecto del Aviso de Privacidad Integral (Extendido).
     */
    public static function getDefaultExtendedContent(): string
    {
        return <<<'HTML'
<h3>AVISO DE PRIVACIDAD INTEGRAL</h3>
<h4>ACCESO Y USO DE PLATAFORMAS Y SISTEMAS INSTITUCIONALES DE RECURSOS HUMANOS</h4>

<p>En [NOMBRE DE LA EMPRESA CONTRATANTE] nos comprometemos a proteger la privacidad y confidencialidad de nuestros colaboradores, candidatos y usuarios. El presente Aviso de Privacidad Integral tiene como finalidad informarle de manera detallada sobre la forma en que recabamos, utilizamos, almacenamos y protegemos sus datos personales, en estricto cumplimiento con la <strong>Ley Federal de Protección de Datos Personales en Posesión de los Particulares (LFPDPPP)</strong>, su Reglamento y demás normatividad aplicable en los Estados Unidos Mexicanos.</p>

<h4>1. Identidad y Domicilio del Responsable</h4>
<p>[NOMBRE DE LA EMPRESA CONTRATANTE], con domicilio en [DIRECCIÓN COMPLETA], haciendo uso de la plataforma tecnológica provista por [NOMBRE DE LA EMPRESA PROVEEDORA], es el Responsable del uso, tratamiento, almacenamiento y protección de sus datos personales.</p>

<h4>2. Datos Personales Recabados</h4>
<p>Para la correcta operación de la plataforma y el cumplimiento de las obligaciones derivadas de la relación laboral y organizacional, podemos tratar las siguientes categorías de datos personales:</p>
<ul>
    <li><strong>Datos de identificación:</strong> Nombre completo, número o código de empleado, CURP, RFC, Número de Seguridad Social (NSS), fecha y lugar de nacimiento, nacionalidad, estado civil y fotografía de perfil.</li>
    <li><strong>Datos de contacto:</strong> Correo electrónico institucional y/o personal, número telefónico, domicilio particular y contacto de emergencia.</li>
    <li><strong>Datos laborales y académicos:</strong> Puesto, departamento, centro de trabajo (sede), razón social, antigüedad, turno, escolaridad, historial de desempeño, indicadores (KPIs), planes de desarrollo, solicitudes de vacaciones y portafolio de expediente digital.</li>
    <li><strong>Datos de evaluación organizacional y psicométrica:</strong> Respuestas y resultados de evaluaciones de desempeño (360°, 9-Box, One-to-One), encuestas de clima organizacional, cuestionarios de identificación de factores de riesgo psicosocial (NOM-035-STPS-2018) y pruebas psicométricas laborales.</li>
    <li><strong>Datos de navegación y auditoría tecnológica:</strong> Registros de inicio de sesión, dirección IP, navegador o dispositivo utilizado, fecha y hora de acceso y bitácoras de aceptación electrónica.</li>
</ul>

<h4>3. Finalidades del Tratamiento</h4>
<p>Los datos personales recabados serán utilizados para las siguientes finalidades primarias y necesarias:</p>
<ul>
    <li>Gestión de identidad, control de acceso y administración de cuentas de usuario y permisos dentro de los sistemas institucionales.</li>
    <li>Administración de capital humano, expedientes digitales, control de vacaciones e historial laboral.</li>
    <li>Ejecución y seguimiento de evaluaciones de desempeño laboral, competencias, retroalimentación y planes de sucesión.</li>
    <li>Aplicación y análisis de cuestionarios vinculados a la Norma Oficial Mexicana <strong>NOM-035-STPS-2018</strong> y Clima Organizacional.</li>
    <li>Aplicación, procesamiento y evaluación de baterías psicométricas de colaboradores y candidatos.</li>
    <li>Seguridad de la información, auditoría operativa, monitoreo del uso de herramientas tecnológicas y prevención de accesos no autorizados o fugas de información.</li>
    <li>Cumplimiento de disposiciones legales, fiscales, de seguridad social (IMSS/SUA) y requerimientos de autoridades competentes.</li>
</ul>

<h4>4. Uso de Herramientas Tecnológicas Externas y Transferencia de Datos</h4>
<p>[NOMBRE DE LA EMPRESA CONTRATANTE] no vende, alquila ni transfiere sus datos personales a terceros ajenos sin su consentimiento, salvo en las excepciones previstas en el artículo 37 de la LFPDPPP. Para el funcionamiento técnico del sistema de Recursos Humanos, la información podrá ser procesada a través de servicios de Inteligencia Artificial vía API (exclusivamente para la redacción del reporte de perfil psicométrico) y servicios de procesamiento de documentos vía APIs especializadas (para conversión de formatos y generación de reportes descargables), operando de forma encriptada y bajo el carácter de Encargados conforme a la legislación aplicable.</p>

<h4>5. Medidas de Seguridad y Confidencialidad</h4>
<p>[NOMBRE DE LA EMPRESA CONTRATANTE], en conjunto con la infraestructura tecnológica de [NOMBRE DE LA EMPRESA PROVEEDORA], implementa medidas de seguridad técnicas, administrativas y físicas para proteger sus datos personales contra daño, pérdida, alteración, destrucción o el uso, acceso o tratamiento no autorizado.</p>

<h4>6. Medios y Procedimiento para el Ejercicio de Derechos ARCO</h4>
<p>Usted tiene derecho de Acceso, Rectificación, Cancelación u Oposición (ARCO) respecto de sus datos personales, así como de revocar su consentimiento. Para ejercer estos derechos, el titular o su representante legal podrán enviar una solicitud formal al correo electrónico <a href="mailto:ventas@netinnfode.com">ventas@netinnfode.com</a> o presentarla por escrito directamente en las oficinas de Recursos Humanos de [NOMBRE DE LA EMPRESA CONTRATANTE], indicando su nombre completo, descripción clara de los datos sobre los que busca ejercer sus derechos y copia de su identificación oficial.</p>

<h4>7. Conservación de los Datos Personales</h4>
<p>Sus datos personales serán conservados únicamente durante el tiempo que dure la relación laboral o proceso de evaluación y por los plazos legales de prescripción establecidos en la legislación laboral, fiscal y de seguridad social aplicable.</p>

<h4>8. Cambios al Aviso de Privacidad</h4>
<p>El presente Aviso de Privacidad puede sufrir modificaciones, cambios o actualizaciones derivadas de nuevos requerimientos legales o políticas internas. Cualquier actualización será puesta a su disposición directamente al ingresar a esta plataforma o a través del Departamento de Recursos Humanos de [NOMBRE DE LA EMPRESA CONTRATANTE].</p>
HTML;
    }

    /**
     * Leyenda oficial por defecto para la casilla de verificación de aceptación.
     */
    public static function getDefaultCheckboxLabel(): string
    {
        return 'Manifiesto haber leído, conocer y comprender el presente Aviso de Privacidad Simplificado y los Términos de Uso de la Plataforma, aceptando exclusivamente su acceso y uso conforme a las finalidades aquí señaladas. Reconozco que la empresa contratante, como responsable del tratamiento de datos personales, conserva, administra y utiliza la información vinculada con la plataforma, sin que ello implique responsabilidad para el usuario sobre su titularidad, resguardo, conservación, actualización, administración o tratamiento. La actualización aplicable y la comunicación de modificaciones normativas, regulatorias o institucionales al colaborador serán facultad y responsabilidad del empleador.';
    }
}
