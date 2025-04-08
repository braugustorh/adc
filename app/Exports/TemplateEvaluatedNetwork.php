<?php

namespace App\Exports;
use App\Models\Campaign;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TemplateEvaluatedNetwork implements FromCollection, WithHeadings
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }
    public function collection()
    {
        $data = [];
        $campaignId=Campaign::where('status','!=','Concluida')->first();
        if (!$campaignId) {
            return collect($data);
        }

        foreach ($this->users as $user) {
                $data[] = [
                    'sede_name'=> $user->sede->name,
                    'department_name'=> $user->department->name,
                    'campaign_id' => $campaignId->id,
                    'campaign_name' => $campaignId->name,
                    'user_id' => $user->id,
                    'user_name'=> $user->name.' '.$user->first_name.' '.$user->last_name,
                    'user_to_evaluated_1_id' => '',
                    'user_to_evaluated_1_name' => '',
                    'user_to_evaluated_2_id' => '',
                    'user_to_evaluated_2_name' => '',
                    'user_to_evaluated_3_id' => '',
                    'user_to_evaluated_3_name' => '',
                    'user_to_evaluated_4_id' => '',
                    'user_to_evaluated_4_name' => '',
                    'user_to_evaluated_5_id' => '',
                    'user_to_evaluated_5_name' => '',
                    'user_to_evaluated_6_id' => '',
                    'user_to_evaluated_6_name' => '',
                    ];

        }
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Sede',
            'Departamento',
            'Campaña ID',
            'Nombre de la Campaña',
            'Evaluador ID',
            'Evaluador',
            'Evaluado ID 1',
            'Evaluado 1',
            'Evaluado ID 2',
            'Evaluado 2',
            'Evaluado ID 3',
            'Evaluado 3',
            'Evaluado ID 4',
            'Evaluado 4',
            'Evaluado ID 5',
            'Evaluado 5',
            'Evaluado ID 6',
            'Evaluado 6',
        ];
    }

}
