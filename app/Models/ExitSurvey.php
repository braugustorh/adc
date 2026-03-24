<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExitSurvey extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'reasons_for_leaving',
        'reasons_details',
        'physical_environment_rating',
        'induction_rating',
        'training_rating',
        'motivation_rating',
        'recognition_rating',
        'salary_rating',
        'supervisor_treatment_rating',
        'rh_treatment_rating',
        'met_expectations',
        'expectations_explanation',
        'favorite_aspects',
        'least_favorite_aspects',
        'improvements',
        'suggestions',
        'status'
    ];

    protected $casts = [
        'reasons_for_leaving' => 'array',
        'met_expectations' => 'boolean',
    ];

    /**
     * Obtiene un mapa de campo => comentario (pregunta) desde la base de datos.
     */
    public static function getQuestionsMap()
    {
        $driver = DB::connection()->getDriverName();
        $columns = [];

        if ($driver === 'pgsql') {
            // Consulta para PostgreSQL
            // Obtenemos el nombre de la columna como "Field" y la descripción como "Comment"
            // para mantener la compatibilidad con el código existente.
            $query = "
                SELECT
                    a.attname AS \"Field\",
                    d.description AS \"Comment\"
                FROM pg_class c
                JOIN pg_attribute a ON a.attrelid = c.oid
                LEFT JOIN pg_description d ON d.objoid = c.oid AND d.objsubid = a.attnum
                WHERE c.relname = 'exit_surveys'
                AND a.attnum > 0
                AND NOT a.attisdropped
            ";
            $columns = DB::select($query);
        } else {
            // Consulta para MySQL / MariaDB
            $columns = DB::select("SHOW FULL COLUMNS FROM exit_surveys");
        }

        $questions = [];

        // Campos irrelevantes para el reporte
        $exclude = ['id', 'user_id', 'created_at', 'updated_at', 'status'];

        foreach ($columns as $column) {
            // Field y Comment vendrán con esos nombres en ambos casos gracias a los alias en la query de pgsql
            if (!in_array($column->Field, $exclude) && !empty($column->Comment)) {
                $questions[$column->Field] = $column->Comment;
            }
        }

        return $questions;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
