<?php

namespace App\Imports;
use App\Models\IndicatorProgress;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class IndicatorProgressImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $validUserIds;
    protected $rowCount = 0;

    public function __construct($validUserIds)
    {
        $this->validUserIds = $validUserIds;
    }

    public function model(array $row)
    {
        // Validar que el user_id e indicator_id sean válidos
        if (!in_array($row['user_id'], $this->validUserIds)) {
            throw new \Exception("El usuario con ID {$row['user_id']} no es válido.");
        }

        // Incrementar el contador de filas procesadas
        $this->rowCount++;

        return new IndicatorProgress([
            'user_id' => $row['user_id'],
            'user_name' => $row['user_name'],
            'indicator_id' => $row['indicator_id'],
            'indicator_name' => $row['indicator_name'],
            'month' => $row['month'],
            'year' => $row['year'],
            'progress_value' => $row['progress_value'],
        ]);
    }
    public function rules(): array
    {
        $year=now()->year;
        $currentMonth = (int) date('n'); // 'n' devuelve el mes sin ceros iniciales (1-12)
        $previousMonth = $currentMonth - 1;
        // Si el mes anterior es 0 (enero), lo ajustamos a diciembre (12)
        if ($previousMonth < 1) {
            $previousMonth = 12;
        }

        return [
            'user_id' => 'required|integer|exists:users,id',
            'indicator_id' => 'required|integer|exists:indicators,id',
            'month' => "required|integer|between:$previousMonth,$currentMonth",
            'year' =>"required|integer|min:$year",
            'progress_value' =>'required|numeric|between:0,100', // Ejemplo de validación adicional
        ];
    }
    public function messages(): array
    {
        return [
            '*.user_id.required' => 'El campo User ID es obligatorio.',
            '*.user_id.integer' => 'El campo User ID debe ser un número entero.',
            '*.user_id.exists' => 'El User ID proporcionado no existe en la base de datos.',

            '*.indicator_id.required' => 'El campo Indicator ID es obligatorio.',
            '*.indicator_id.integer' => 'El campo Indicator ID debe ser un número entero.',
            '*.indicator_id.exists' => 'El Indicator ID proporcionado no existe en la base de datos.',

            '*.month.required' => 'El campo Mes es obligatorio.',
            '*.month.integer' => 'El campo Mes debe ser un número entero.',
            '*.month.between' => 'El campo Mes debe estar entre :min y :max.',

            '*.year.required' => 'El campo Año es obligatorio.',
            '*.year.integer' => 'El campo Año debe ser un número entero.',
            '*.year.min' => 'El campo Año debe ser mayor o igual a :min.',

            '*.progress_value.required' => 'El campo Valor de Progreso es obligatorio.',
            '*.progress_value.numeric' => 'El campo Valor de Progreso debe ser un número.',
            '*.progress_value.between' => 'El campo Valor de Progreso debe estar entre :min y :max.',
        ];
    }
    public function attributes(): array
    {
        return [
            'user_id' => 'User ID',
            'indicator_id' => 'Indicator ID',
            'month' => 'Mes',
            'year' => 'Año',
            'progress_value' => 'Progreso',
        ];
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

}
