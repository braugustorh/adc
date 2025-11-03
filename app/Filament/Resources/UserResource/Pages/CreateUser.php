<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Helpers\VisorRoleHelper;
use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Position;
use App\Models\Sede;
use App\Models\State;
use Faker\Provider\Text;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Livewire\Component;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Get;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components;
use Illuminate\Support\Facades\Http;
use mysql_xdevapi\TableSelect;
use function Laravel\Prompts\search;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;
    protected static string $resource = UserResource::class;
    //public static string $title = 'Crear Usuario';
    public $countries=[];
    public $bStates;
    public $token;
    public $estadosMexico=[];
    protected static ?string $title='Crear Usuarios';
    public array $estadosIds;

    protected function authorizeAccess(): void
    {
        abort_unless(VisorRoleHelper::canEdit(), 403, __('Ups!, no estas autorizado para realizar esta acción.'));
    }

    protected function getSteps():array
    {
        return [
            Step::make('Información Personal')
                //->description('This is the first step of the wizard.')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(100)
                        ->label('Nombre(s)'),
                    TextInput::make('first_name')
                        ->maxLength(100)
                        ->default(null)
                        ->label('Primer Apellido'),
                    TextInput::make('last_name')
                        ->maxLength(100)
                        ->default(null)
                        ->label('Segundo Apellido'),
                    TextInput::make('curp')
                        ->label('CURP')
                        ->required()
                        ->unique('users', 'curp', fn ($record) => $record ? $record->id : null)
                        ->maxLength(18)
                        ->afterStateHydrated(function (Get $get,Set $set):string{
                            return $set ('curp', strtoupper($get('curp')));
                        }),
                    Select::make('sex')
                        ->label('Sexo')
                        ->options([
                            'Masculino' => 'Masculino',
                            'Femenino' => 'Femenino',
                            'Otro' => 'Otro',
                        ]),
                    DatePicker::make('birthdate')
                        ->label('Fecha de Nacimiento')
                        ->required(),
                    Select::make('nationality')
                        ->label('Nacionalidad')
                        ->live()
                        ->options([
                            'Mexicana' => 'Mexicana',
                            'Extranjera' => 'Extranjera',
                        ])
                        ->reactive()
                        ->searchable()
                        ->default(null),

                    Select::make('birth_country')
                        ->live()
                        ->reactive()
                        ->label('País de Nacimiento')
                        ->options(function(Get $get,Set $set): array{

                            if($get('nationality')==="Mexicana"){
                                $this->countries = [142 => 'Mexico'];
                                $set('birth_country', 142);
                            }
                            return $this->countries;
                        })
                        ->loadingMessage('Cargando Paises...')
                        ->searchable()
                        ->default(null),
                    Select::make('birth_state')
                        ->live()
                        ->searchable()
                        ->label('Estado de Nacimiento')
                        ->options(function(Get $get): array{
                            $country= $get('birth_country');
                            $states = [];
                            if($country){
                                $states= State::where('country_id',$country)
                                    ->pluck('name','id')
                                    ->mapWithKeys(fn($name, $id) => [$id => ucfirst($name)])
                                    ->toArray();
                            }
                            return $states;
                        })
                        ->loadingMessage('Cargando Estados...')
                        ->default(null),
                    Select::make('birth_city')
                        ->label('Ciudad de Nacimiento')
                        ->live()
                        ->searchable()
                        ->options(
                            function(Get $get): array{
                                $state= $get('birth_state');
                                $cities=[];
                                if($state){
                                    $cities=City::where('state_id',$state)
                                        ->pluck('name','id')
                                        ->mapWithKeys(fn($name, $id) => [$id => ucfirst($name)])
                                        ->toArray();
                                }
                                return $cities;
                            }
                        )
                        ->loadingMessage('Cargando Municipios...')
                        ->searchingMessage('Buscando Municipios...')
                        ->default(null),
                    Select::make('disability')
                        ->label('Discapacidad')
                        ->options([
                            'Ninguna' => 'Ninguna',
                            'Auditiva' => 'Auditiva',
                            'Visual' => 'Visual',
                            'Motriz' => 'Motriz',
                            'Intelectual' => 'Intelectual',
                            'Múltiple' => 'Múltiple',
                            'Otra' => 'Otra',
                        ]),
                ])->columns(2),
            Step::make('Información de Contacto')
                // ->description('This is the second step of the wizard.')
                ->schema([
                    Select::make('state')
                        ->label('Estado')
                        ->live()
                        ->options($this->estadosMexico)
                        ->searchable()
                        ->loadingMessage('Cargando Estados...')
                        ->searchingMessage('Buscando Estados...')
                        //->mess
                        ->default(null),
                    Select::make('city')
                        ->label('Ciudad')
                        ->live()
                        ->options(
                            function(Get $get): array{
                                $state= $get('state');
                                if($state){
                                    if (!empty($this->estadosIds) && is_array($this->estadosIds)) {
                                        $flipped = array_flip($this->estadosIds); // ahora keys = nombre_estado, values = estado_id
                                        $stateId = $flipped[$state] ?? null;
                                        $stateId = $stateId+1;
                                    }
                                    $citiesResponse = Http::withHeaders([
                                        "Accept"=> "application/json",
                                        "APIKEY"=> "5e41fcafd8ee7e437980977e8b8ad009e357c2cd",
                                    ])->get('https://api.tau.com.mx/dipomex/v1/municipios?id_estado='.$stateId);
                                    $citiesArray = json_decode($citiesResponse->body(), true);

                                    if (is_array($citiesArray)) {

                                        $cities = array_column($citiesArray['municipios'], 'MUNICIPIO', 'MUNICIPIO');
                                    } else {
                                        Notification::make()
                                            ->title('Error')
                                            ->danger()
                                            ->icon('heroicon-o-x-circle')
                                            ->iconColor('danger')
                                            ->body('No se pudo obtener la lista de ciudades'.' '.$citiesResponse)
                                            ->send();
                                        $cities = [];
                                    }
                                }else{
                                    $cities = [];
                                }
                                return $cities;
                            }
                        )
                        ->searchable()
                        ->loadingMessage('Cargando Municipios...')
                        ->searchingMessage('Buscando Municipios...')
                        ->default(null),
                    TextInput::make('colony')
                        ->label('Colonia')
                        ->live()
                        ->default(null),
                    TextInput::make('cp')
                        ->label('Código Postal')
                        ->maxLength(5)
                        ->reactive(),
                    TextInput::make('address')
                        ->label('Dirección')
                        ->helperText('Calle y Número')
                        ->maxLength(255)
                        ->default(null)
                        ->columnSpan(2),
                    TextInput::make('phone')
                        ->label('Teléfono')
                        ->helperText('Número de 10 dígitos')
                        ->tel()
                        ->maxLength(10)
                        ->minLength(10)
                        ->default(null),
                    TextInput::make('emergency_name')
                        ->label('Nombre del Contacto de Emergencias')
                        ->maxLength(90)
                        ->default(null),
                    TextInput::make('relationship_contact')
                        ->label('Parentesco')
                        ->maxLength(45)
                        ->default(null),
                    TextInput::make('emergency_phone')
                        ->label('Teléfono de Emergencias')
                        ->helperText('Número de 10 dígitos')
                        ->tel()
                        ->maxLength(10)
                        ->minLength(10)
                        ->default(null),
                ])->columns(2),
            Step::make('Escolaridad')
                //->description('This is the third step of the wizard.')
                ->schema([
                    Select::make('scholarship')
                        ->label('Escolaridad')
                        ->live()
                        ->options([
                            'Primaria' => 'Primaria',
                            'Secundaria' => 'Secundaria',
                            'Técnico'=> 'Técnico',
                            'Preparatoria' => 'Preparatoria',
                            'TSU' => 'TSU',
                            'Licenciatura' => 'Licenciatura',
                            'Maestría' => 'Maestría',
                            'Doctorado' => 'Doctorado',
                            'otro' => 'otro',
                        ])
                        ->default(null),
                    Select::make('career')
                        ->label('Área de Estudio')
                        ->disabled(fn (Get $get): bool =>
                            $get('scholarship') === 'Primaria' ||
                            $get('scholarship') === 'Secundaria' ||
                            $get('scholarship') === 'Técnico' ||
                            $get('scholarship') === 'Preparatoria' ||
                            $get('scholarship') === 'otro',
                        )
                        ->options([
                            'Humanidades' => 'Humanidades',
                            'Ciencias Sociales' => 'Ciencias Sociales',
                            'Ciencias Exactas' => 'Ciencias Exactas',
                            'Ingeniería' => 'Ingeniería',
                            'Ciencias de la Salud' => 'Ciencias de la Salud',
                            'Artes' => 'Artes',
                            'Administración' => 'Administración',
                            'Teconología' => 'Teconología',
                            'Otra' => 'Otra',
                        ])
                        ->default(null),
                ])->columns(2),
            Step::make('Información Laboral')
                // ->description('This is the fourth step of the wizard.')
                ->schema([
                    TextInput::make('employee_code')
                    ->label('Número de empleado')
                    ->required(),
                    Select::make('sede_id')
                        ->label('Sede')
                        ->preload()
                        ->live()
                        ->searchable()
                        ->relationship('sede', 'name')
                        ->default(null),
                    Select::make('department_id')
                        ->label('Departamento')
                        ->live()
                        ->searchable()
                        ->options(fn (Get $get): Collection => Department::query()
                            ->where('sede_id', $get('sede_id'))
                            ->pluck('name', 'id'))
                        ->default(null),
                    Select::make('position_id')
                        ->label('Puesto')
                        ->options(fn (Get $get): Collection => Position::query()
                            ->where('department_id', $get('department_id'))
                            ->pluck('name', 'id'))
                        ->default(null),
                    Toggle::make('mi')
                ->label('Pertenece a Marcas Internas?')
                ->default(false),
                    Select::make('contract_type')
                        ->label('Tipo de Contrato')
                        ->options([
                            'Confianza' => 'De Confianza',
                            'Sindicalizado' => 'Sindicalizado',
                            'Eventual' => 'Eventual',
                            'Honorarios' => 'Honorarios',
                            'Prácticas' => 'Prácticas',
                            'Otro' => 'Otro',
                        ])
                        ->default(null),
                    TextInput::make('rfc')
                        ->label('RFC')
                        ->minLength(12)
                        ->maxLength(13)
                        ->required()
                        ->unique('users', 'rfc', fn ($record) => $record ? $record->id : null)
                        ->default(null),
                    TextInput::make('imss')
                        ->label('Número de Seguridad Social')
                        ->maxLength(11)
                        ->required()
                        ->unique('users', 'imss', fn ($record) => $record ? $record->id : null)
                        ->default(null),
                    DatePicker::make('entry_date')
                    ->label('Fecha de ingreso'),
                ])->columns(2),
            Step::make('Configurar Usuario')
                ->schema([
                    FileUpload::make('profile_photo')
                        ->label('Foto de Perfil')
                        ->disk('sedyco_disk')
                        ->visibility('public')
                        ->image()
                        ->avatar()
                        ->imageEditor()
                        ->circleCropper()
                        ->maxSize('2048')
                        ->maxFiles(1)
                        ->rules('image')
                        ->columnSpan('full'),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique('users', 'email', fn ($record) => $record ? $record->id : null)
                        ->maxLength(80),
                    DateTimePicker::make('email_verified_at')
                    ->hidden()
                    ->default(now()),
                    TextInput::make('password')
                        ->label('Contraseña')
                        ->password()
                        ->revealable()
                        ->confirmed()
                        ->maxLength(255),
                    TextInput::make('password_confirmation')
                        ->label('Confirmar Contraseña')
                        ->password()
                        ->revealable()
                        ->maxLength(255),
                    Select::make('roles')
                        //->multiple()
                        ->preload()
                        ->searchable()
                        ->relationship('roles', 'name', function ($query) {
                            $user = auth()->user();
                            // Filtra los roles según el rol del usuario actual
                            if ($user->hasRole('Administrador')) {
                                return $query; // Admin ve todos los roles
                            }elseif($user->hasRole('RH Corp')) {
                                return $query->whereIn('name', ['RH Corp','RH', 'Colaborador', 'Supervisor','Operativo']);
                            }
                            // Ejemplo: solo roles específicos para otros usuarios
                            return $query->whereIn('name', ['Colaborador', 'Supervisor','Operativo']);
                        }),
                ])->columns(2),
        ];
    }
    public function mount(): void
    {

        $response = Http::withHeaders([
            "Accept"=> "application/json",
            "api-token"=> "qJgEjApgNVP3YZKIwiOoZdiZJh4SXjMy2AD0MPr4erJziEaPKK98avKzs850wQdYYBs",
            "user-email"=> "braugustorh@gmail.com"
        ])->get("https://www.universal-tutorial.com/api/getaccesstoken");

        $this->token = $response->json(['auth_token']);
        $countriesResponse = Http::withHeaders([
            "Authorization"=>"Bearer ". $this->token,
            "Accept"=> "application/json",
        ])->get("https://www.universal-tutorial.com/api/countries/");
        $res=Http::withHeaders([
            "Accept"=> "application/json",
            "APIKEY"=> "5e41fcafd8ee7e437980977e8b8ad009e357c2cd",
        ])->get('https://api.tau.com.mx/dipomex/v1/estados');


        $colonyArray=json_decode($res->body(),true);
        if (is_array($colonyArray)) {

            $this->estadosMexico = array_column($colonyArray['estados'], 'ESTADO', 'ESTADO');
            $this->estadosIds= array_column($colonyArray['estados'], 'ESTADO', 'ESTADO_id');
        }else{
            Notification::make()
                ->title('Error')
                ->danger()
                ->icon('heroicon-o-x-circle')
                ->iconColor('danger')
                ->body('No se pudo obtener la lista de estados')
                ->send();

        }
       // dd($this->estadosMexico);

        $this->countries= Country::all()
            ->pluck('name','id')
            ->mapWithKeys(fn($name, $id) => [$id => ucfirst($name)])
            ->toArray();

        parent::mount(); // TODO: Change the autogenerated stub
    }

}
