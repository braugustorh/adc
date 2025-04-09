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
                    'type_user_1'=> '',
                    'user_to_evaluated_1_id' => '',
                    'user_to_evaluated_1_name' => '',
                    'type_user_2'=> '',
                    'user_to_evaluated_2_id' => '',
                    'user_to_evaluated_2_name' => '',
                    'type_user_3'=> '',
                    'user_to_evaluated_3_id' => '',
                    'user_to_evaluated_3_name' => '',
                    'type_user_4'=> '',
                    'user_to_evaluated_4_id' => '',
                    'user_to_evaluated_4_name' => '',
                    'type_user_5'=> '',
                    'user_to_evaluated_5_id' => '',
                    'user_to_evaluated_5_name' => '',
                    'type_user_6'=> '',
                    'user_to_evaluated_6_id' => '',
                    'user_to_evaluated_6_name' => '',
                    'type_user_7'=> '',
                    'user_to_evaluated_7_id' => '',
                    'user_to_evaluated_7_name' => '',
                    'type_user_8'=> '',
                    'user_to_evaluated_8_id' => '',
                    'user_to_evaluated_8_name' => '',
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
            'Tipo Ev U1',
            'Evaluado ID 1',
            'Evaluado 1',
            'Tipo Ev U2',
            'Evaluado ID 2',
            'Evaluado 2',
            'Tipo Ev U3',
            'Evaluado ID 3',
            'Evaluado 3',
            'Tipo Ev U4',
            'Evaluado ID 4',
            'Evaluado 4',
            'Tipo Ev U5',
            'Evaluado ID 5',
            'Evaluado 5',
            'Tipo Ev U6',
            'Evaluado ID 6',
            'Evaluado 6',
            'Tipo Ev U7',
            'Evaluado ID 7',
            'Evaluado 7',
            'Tipo Ev U8',
            'Evaluado ID 8',
            'Evaluado 8',
        ];
    }

}
