<?php

namespace Filament\Widgets;


use Filament\Widgets\Widget;
use App\Models\User;
use Carbon\Carbon;

class AccountWidget extends Widget
{
    protected static ?int $sort = -3;

    protected static bool $isLazy = false;
    public $cumple;

    /**
     * @var view-string
     */
    protected static string $view = 'filament.resources.dashboard-resource.widgets.account-widget';

    public function mount()
    {
        $hoy = Carbon::now()->format('m-d');
        $this->cumple = User::whereRaw("DATE_FORMAT(birthdate, '%m-%d') = '$hoy'")
            ->where('id',auth()->user()->id)
            ->get();

    }


}

