<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IndicatorProgressTemplateExport implements FromCollection, WithHeadings
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }
    public function collection()
    {
        $data = [];

        foreach ($this->users as $user) {
            foreach ($user->indicators as $indicator) {
                $data[] = [
                    'user_id' => $user->id,
                    'user_name'=> $user->name.' '.$user->first_name.' '.$user->last_name,
                    'indicator_id' => $indicator->id,
                    'indicator_name' => $indicator->name,
                    'month' => '',
                    'year' => '2025',
                    'progress_value' => '',
                ];
            }
        }
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'User ID',
            'User Name',
            'Indicator ID',
            'Indicator Name',
            'Month',
            'Year',
            'Progress Value',
        ];
    }

}
