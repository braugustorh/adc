<?php

namespace App\Filament\Pages;

use App\Models\Sede;
use App\Models\User;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Notifications\Notification;

class ComunicadosManager extends Page
{
    protected static ?string $navigationIcon = 'bi-send-fill';

    protected static string $view = 'filament.pages.comunicados-manager';
    protected static ?string $navigationLabel = ' Comunicados Manager';
    protected static ?string $navigationGroup = 'Comunicación';
    protected ?string $heading = 'Comunicados Manager';
    protected ?string $subheading = 'Envía los comunicados de la plataforma';

    public $titleMessage;
    public $recip;
    public $sedes;
    public $body;

    public function form(Form $form): Form
    {

        // Obtener las opciones de las sedes
        $sedesOptions = $this->sedes->pluck('name', 'id')->toArray();

        // Agregar la opción "Seleccionar todas" al inicio del array
        $sedesOptions = ['all' => 'Seleccionar todas'] + $sedesOptions;

        return $form
            ->schema([
                TextInput::make('titleMessage')->label('Título del mensaje'),
                Textarea::make('body')->label('Mensaje'),
                Select::make('recip')
                    ->label('Destinatarios')
                    ->options($sedesOptions) // Usar el array modificado
                    ->multiple()
                    ->searchable()
                    ->placeholder('Selecciona las sedes')
                    ->live() // Para que reaccione a cambios en tiempo real
                    ->afterStateUpdated(function ($state, $set) {
                        // Si se selecciona "Seleccionar todas", marcar todas las opciones
                        if (in_array('all', $state)) {
                            $set('recip', array_keys($this->sedes->pluck('name', 'id')->toArray()));
                        }
                    }),
                Actions::make([
                    Action::make('sendNotification')
                        ->label('Enviar comunicado')
                        ->action('sendNotification')    // Metodo que se ejecutará al hacer clic
                        ->color('primary')
                        ->icon('heroicon-o-paper-airplane'),
                    Action::make('clear')
                        ->label('Limpiar campos')
                        ->action('clear')    // Metodo que se ejecutará al hacer clic
                        ->color('danger')
                        ->icon('heroicon-c-arrow-path'),
                ])->alignEnd(),
            ])
            ->columns(1);

    }

    protected function canView(): bool
    {
        if (auth()->user()->hasRole('Administrador')) {
            return true;
        }else{
            return false;
        }
    }
    public function mount()
    {
        $this->recip = [];
        $this->sedes= Sede::all();
    }

    public function sendNotification(): void
    {

        $this->validate([
            'titleMessage' => 'required',
            'recip' => 'required',
            'body' => 'required',
        ]);
        $sender = \Auth::user();
        $users=User::whereIn('sede_id', $this->recip)->where('status',1)->get();

        foreach ($users as $recipient) {
            $this->sendNotificationToUser($recipient);
        }

        Notification::make()
            ->title('Comunicado enviado')
            ->success()
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->body('El comunicado ha sido enviado correctamente')
            ->send();
    }
    public function clear(){
        $this->reset('titleMessage', 'recip', 'body');
    }

    public function sendNotificationToUser($recipient):void{
        Notification::make()
            ->title($this->titleMessage)
            ->info()
            ->body($this->body)
            ->sendToDatabase($recipient);
    }


}
