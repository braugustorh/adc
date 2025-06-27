<?php

namespace App\Enums;

enum TraumaticEventType: string
{
    case ACCIDENT = 'accident';
    case ROBBERY = 'robbery';
    case KIDNAPPING = 'kidnapping';
    case WORKPLACE_HARASSMENT = 'workplace_harassment';
    case PHYSICAL_AGGRESSION = 'physical_aggression';
    case NATURAL_DISASTER = 'natural_disaster';
    case CHEMICAL_INCIDENT = 'chemical_incident';
    case COWORKER_DEATH = 'coworker_death';
    case EQUIPMENT_LOSS = 'equipment_loss';
    case EXTREME_VIOLENCE = 'extreme_violence';
    case MEDICAL_EMERGENCY = 'medical_emergency';
    case OTHER = 'other';

    /**
     * Obtener el nombre para mostrar del tipo de evento
     */
    public function label(): string
    {
        return match($this) {
            self::ACCIDENT => 'Accidente grave en el lugar de trabajo',
            self::ROBBERY => 'Robo o asalto durante labores',
            self::KIDNAPPING => 'Secuestro o amenazas directas',
            self::WORKPLACE_HARASSMENT => 'Acoso laboral severo',
            self::PHYSICAL_AGGRESSION => 'Agresiones físicas o verbales graves',
            self::NATURAL_DISASTER => 'Exposición a desastres naturales',
            self::CHEMICAL_INCIDENT => 'Incidentes químicos o estructurales',
            self::COWORKER_DEATH => 'Fallecimiento de compañero en el trabajo',
            self::EQUIPMENT_LOSS => 'Pérdida de bienes importantes',
            self::EXTREME_VIOLENCE => 'Presenciar o ser víctima de violencia extrema',
            self::MEDICAL_EMERGENCY => 'Emergencia médica grave de colega',
            self::OTHER => 'Otro',
        };
    }

    /**
     * Obtener la categoría del tipo de evento
     */
    public function category(): string
    {
        return match($this) {
            self::ACCIDENT, self::ROBBERY, self::KIDNAPPING => 'Riesgos a la vida o integridad física',
            self::WORKPLACE_HARASSMENT, self::PHYSICAL_AGGRESSION => 'Violencia laboral',
            self::NATURAL_DISASTER, self::CHEMICAL_INCIDENT => 'Desastres naturales o provocados',
            self::COWORKER_DEATH, self::EQUIPMENT_LOSS => 'Pérdida o daño significativo',
            self::EXTREME_VIOLENCE, self::MEDICAL_EMERGENCY, self::OTHER => 'Otros eventos de alto impacto psicológico',
        };
    }

    /**
     * Obtener la descripción detallada del tipo de evento
     */
    public function description(): string
    {
        return match($this) {
            self::ACCIDENT => 'Caídas, explosiones o incidentes con maquinaria que ponen en riesgo la vida o integridad física.',
            self::ROBBERY => 'Ser víctima de robo o asalto durante el desempeño de las funciones laborales.',
            self::KIDNAPPING => 'Secuestro o amenazas que ponen en riesgo la vida del trabajador.',
            self::WORKPLACE_HARASSMENT => 'Hostigamiento psicológico o físico repetitivo en el entorno laboral.',
            self::PHYSICAL_AGGRESSION => 'Violencia por parte de compañeros, supervisores o clientes en el entorno laboral.',
            self::NATURAL_DISASTER => 'Terremotos, inundaciones o incendios que afecten directamente al trabajador.',
            self::CHEMICAL_INCIDENT => 'Explosiones, derrames químicos u otros incidentes estructurales en el lugar de trabajo.',
            self::COWORKER_DEATH => 'Muerte de un compañero de trabajo durante actividades laborales.',
            self::EQUIPMENT_LOSS => 'Destrucción de equipo crítico que afecta la seguridad laboral.',
            self::EXTREME_VIOLENCE => 'Tiroteo, acto de terrorismo u otro evento de violencia extrema en el lugar de trabajo.',
            self::MEDICAL_EMERGENCY => 'Presenciar una emergencia médica grave de un compañero en el trabajo.',
            self::OTHER => 'Otro tipo de evento traumático severo no especificado en las categorías anteriores.',
        };
    }

    /**
     * Obtener todos los casos agrupados por categoría
     */
    public static function getByCategory(): array
    {
        $categorized = [];
        foreach (self::cases() as $case) {
            $category = $case->category();
            if (!isset($categorized[$category])) {
                $categorized[$category] = [];
            }
            $categorized[$category][] = $case;
        }
        return $categorized;
    }

    /**
     * Obtener todos los tipos como array para select
     */
    public static function toSelectArray(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }
}
