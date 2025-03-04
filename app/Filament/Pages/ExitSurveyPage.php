<?php

namespace App\Filament\Pages;

use App\Models\ExitSurvey;
use App\Models\Sede;
use App\Models\User;
use App\Models\UserTermination;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class ExitSurveyPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $title = 'Encuesta de Salida';
    //protected static ?string $slug = 'exit-survey'; // Esto debe coincidir con la ruta en web.php

    protected static string $view = 'filament.pages.exit-survey-page';
    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];
    public ExitSurvey $survey;
    public int $show=0;

    public function mount(): void
    {
        $this->data['reasons_for_leaving'] = [];
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Fieldset::make('Motivos de baja')
                ->schema([
                    CheckboxList::make('reasons_for_leaving')
                        ->label('¿Por cuál razón decide retirarse de la empresa?')
                        ->helperText('Seleccione todas las que apliquen')
                        ->options([
                            'baja_remuneracion' => 'Baja remuneración',
                            'falta_reconocimiento' => 'Falta de reconocimiento a su labor',
                            'ambiente_fisico' => 'Ambiente físico de trabajo',
                            'problemas_jefe' => 'Problemas con el jefe directo',
                            'falta_motivacion' => 'Falta de motivación del grupo',
                            'relaciones_laborales' => 'Relaciones laborales',
                            'problemas_personales' => 'Problemas personales y/o enfermedad',
                            'demasiada_presion'=> 'Demasiada presión (stress)',
                            'incumplimiento_ofrecido'=> 'Incumplimiento de lo ofrecido al ingresar',
                            'oportunidad_desarrollo'=> 'Falta de oportunidad de desarrollo',
                            'horarios'=> 'Horarios de trabajo',
                            'mejoras_laborales'=>'Mejoras laborales',
                        ])->columns(2)
                        ->gridDirection('row')
                        //->reactive()
                        ->required(),

                    Textarea::make('reasons_details')
                        ->label('De las alternativas marcadas, especifique sus razones')
                        ->columnSpanFull()
                        ->required(),
            ])->columns(1),
            Fieldset::make('Califique usted los siguientes aspectos en la empresa')
                ->schema([
                Select::make('physical_environment_rating')
                    ->label('Ambiente físico')
                    ->options([
                        'muy_bueno' => 'Muy Bueno',
                        'bueno' => 'Bueno',
                        'regular' => 'Regular',
                        'malo' => 'Malo',
                        'muy_malo' => 'Muy Malo'
                    ])
                    ->required(),

                Select::make('induction_rating')
                    ->label('Inducción')
                    ->options([
                        'muy_bueno' => 'Muy Bueno',
                        'bueno' => 'Bueno',
                        'regular' => 'Regular',
                        'malo' => 'Malo',
                        'muy_malo' => 'Muy Malo'
                    ])

                    ->required(),

                Select::make('training_rating')
                    ->label('Capacitación')
                    ->options([
                        'muy_bueno' => 'Muy Bueno',
                        'bueno' => 'Bueno',
                        'regular' => 'Regular',
                        'malo' => 'Malo',
                        'muy_malo' => 'Muy Malo'
                    ])
                    ->required(),

                Select::make('motivation_rating')
                    ->label('Motivación al grupo de trabajo')
                    ->options([
                        'muy_bueno' => 'Muy Bueno',
                        'bueno' => 'Bueno',
                        'regular' => 'Regular',
                        'malo' => 'Malo',
                        'muy_malo' => 'Muy Malo'
                    ])
                    ->required(),
                Select::make('recognition_rating')
                    ->label('Reconocimiento a su labor')
                    ->options([
                        'muy_bueno' => 'Muy Bueno',
                        'bueno' => 'Bueno',
                        'regular' => 'Regular',
                        'malo' => 'Malo',
                        'muy_malo' => 'Muy Malo'
                    ])
                    ->required(),
                Select::make('salary_rating')
                    ->label('Sueldo y comisiones')
                    ->options([
                        'muy_bueno' => 'Muy Bueno',
                        'bueno' => 'Bueno',
                        'regular' => 'Regular',
                        'malo' => 'Malo',
                        'muy_malo' => 'Muy Malo'
                    ])
                    ->required(),
                Select::make('supervisor_treatment_rating')
                    ->label('Trato por parte del supervisor y/o jefe')
                    ->options([
                        'muy_bueno' => 'Muy Bueno',
                        'bueno' => 'Bueno',
                        'regular' => 'Regular',
                        'malo' => 'Malo',
                        'muy_malo' => 'Muy Malo'
                    ])
                    ->required(),
                Select::make('rh_treatment_rating')
                    ->label('Trato que recibió por el área de Recursos Humanos')
                    ->options([
                        'muy_bueno' => 'Muy Bueno',
                        'bueno' => 'Bueno',
                        'regular' => 'Regular',
                        'malo' => 'Malo',
                        'muy_malo' => 'Muy Malo'
                    ])
                    ->required(),
            ])->columns(3),
            Fieldset::make('Responsabilidades laborales')
                ->schema([
                Radio::make('met_expectations')
                    ->label('¿Las responsabilidades y labores de su puesto correspondían a lo que esperaba?')
                    ->boolean()
                    ->inline()
                    ->columnSpanFull()
                    ->required(),

                Textarea::make('expectations_explanation')
                    ->label('¿Por qué?')
                    ->columnSpanFull()
                    ->required(),
            ]),
            Fieldset::make('Escribe tus comentarios de cada uno de los siguientes aspectos')
            ->schema([
                Textarea::make('favorite_aspects')
                    ->label('¿Qué era lo que más te gustaba de sus labores?')
                    ->required(),
                Textarea::make('least_favorite_aspects')
                    ->label('¿Y lo que menos te gustaba?')
                    ->required(),
                Textarea::make('improvements')
                    ->label('Si estuviera en tus manos ¿Qué hubieras hecho para impedir su salida de la empresa?')
                    ->required(),
                Textarea::make('suggestions')
                    ->label('Al fin de mejorar nuestra gestión ¿Qué comentarios o sugerencias haría finalmente?')
                    ->required(),
            ])

        ])->statePath('data');
    }
    public function saveSurvey(Request $request)
    {
        $data = $this->form->getState();

        $this->survey = ExitSurvey::create([
            'user_id' => Auth::id(),
            'status'=>'finalizada',
            ...$data
            ]);
        //$this->showSurvey();
        //Pon aqui una notificación de que ya fue guardada la encuesta
        Notification::make()
            ->success()
            ->title('Encuesta guardada')
            ->body('Gracias por completar la encuesta de salida.')
            ->send();


        //Cierra la sesión y redirige al login
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerateToken();
        return redirect(filament()->getLoginUrl());


    }
    public function showSurvey()
    {
        if ($this->show===0) {
            $this->show = 1;
        }else{
            $this->show = 0;
        }

    }
    protected function getHeaderActions(): array
    {
        return [];
    }
}
