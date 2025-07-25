<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Helpers\VisorRoleHelper;
use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Position;
use App\Models\State;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Scalar\String_;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Hash;

class EditUser extends EditRecord
{
    use EditRecord\Concerns\HasWizard;

    protected static string $resource = UserResource::class;
    protected static ?string $title='Editar Usuarios';

    public $token;
    public String $cp;
    public $countries=[];
    public $estadosMexico=[];
    protected function authorizeAccess(): void
    {
        abort_unless(VisorRoleHelper::canEdit(), 403, __('Ups!, no estas autorizado para realizar esta acción.'));
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
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
                        ->unique('users', 'curp', fn ($record) => $record )
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
                    Select::make('nationality')
                        ->label('Nacionalidad')
                        ->live()
                        ->options([
                            'Mexicana' => 'Mexicana',
                            'Extranjera' => 'Extranjera',
                        ])
                        ->searchable()
                        ->default(null),
                    DatePicker::make('birthdate')
                        ->label('Fecha de Nacimiento')
                        ->required(),
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
                        ->reactive()
                        ->searchable()
                        ->label('Estado de Nacimiento')
                        ->options(function(Get $get): array{
                                $country= $get('birth_country');
                                $states = [];
                                if($country){
                                    $states=State::where('country_id',$country)
                                       ->pluck('name','id')
                                       ->mapWithKeys(fn($name, $id) => [$id => ucfirst($name)])
                                      ->toArray();
                                }
                            return $states;
                        })
                        ->loadingMessage('Cargando Estado...')
                        ->searchingMessage('Buscando Estados...')
                        ->default(null),
                    Select::make('birth_city')
                        ->label('Ciudad de Nacimiento')
                        ->searchable()
                        ->options(
                            function(Get $get): array{
                                $state= $get('birth_state');
                                $cities = [];
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
                                    $res=Http::withHeaders([
                                        "Accept"=> "application/json",
                                        "APIKEY"=> "5e41fcafd8ee7e437980977e8b8ad009e357c2cd",
                                    ])->get('https://api.tau.com.mx/dipomex/v1/estados');

                                    $estadosArray = collect(json_decode($res->body(), true)['estados'] ?? [])->firstWhere('ESTADO', $state);
                                    $estadoId = $estadosArray['ESTADO_ID'] ?? null;
                                    $citiesResponse = Http::withHeaders([
                                        "Accept"=> "application/json",
                                        "APIKEY"=> "5e41fcafd8ee7e437980977e8b8ad009e357c2cd",
                                    ])->get('https://api.tau.com.mx/dipomex/v1/municipios?id_estado='.$estadoId);

                                    $citiesArray = json_decode($citiesResponse->body(), true);

                                    if (is_array($citiesArray)) {

                                        $cities = array_column($citiesArray['municipios'], 'MUNICIPIO', 'MUNICIPIO');
                                    } else {
                                        Notification::make()
                                            ->title('Error')
                                            ->danger()
                                            ->icon('heroicon-o-x-circle')
                                            ->iconColor('danger')
                                            ->body('No se pudo obtener la lista de ciudades')
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
                            'Tecnología' => 'Tecnología',
                            'Otra' => 'Otra',
                        ])
                        ->default(null),
                ])->columns(2),
            Step::make('Información Laboral')
                // ->description('This is the fourth step of the wizard.')
                ->schema([

                    Select::make('sede_id')
                        ->label('Sede')
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
                    Select::make('contract_type')
                        ->label('Tipo de Contrato')
                        ->options([
                            'Temporal' => 'Temporal',
                            'De Confianza' => 'De Confianza',
                            'Sindicalizado' => 'Sindicalizado',
                        ])
                        ->default(null),
                    TextInput::make('employee_code')
                        ->label('Número de Empleado')
                        ->maxLength(10)
                        ->default(null),
                    TextInput::make('rfc')
                        ->label('RFC')
                        ->autocapitalize('characters')
                        ->helperText('Debe de contener 13 caractéres')
                        ->length(13)
                        ->required()
                        ->unique('users', 'rfc', fn ($record) => $record)
                        ->disableAutocomplete()
                        //->mask('/^[A-Z]{4}[0-9]{6}[A-Z0-9]{3}*$/')
                        ->default(null),
                    TextInput::make('imss')
                        ->label('Número de Seguridad Social')
                        ->maxLength(11)
                        ->required()
                        ->unique('users', 'imss', fn ($record) => $record )
                        ->default(null),
                    DatePicker::make('entry_date')
                    ->label('Fecha de Ingreso'),
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
                        ->unique('users', 'email', fn ($record) => $record)
                        ->maxLength(80),
                    TextInput::make('password')
                        ->label('Contraseña')
                        ->password()
                        ->revealable()
                        ->disableAutocomplete()
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->dehydrated(fn ($state) => filled($state))
                        ->maxLength(255),
                    Select::make('roles')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->relationship('roles', 'name'),
                ])->columns(2),

        ];
    }
    public function hasSkippableSteps(): bool
    {
        return true;
    }
    public function mount($record):void
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


        }else{
            Notification::make()
                ->title('Error')
                ->danger()
                ->icon('heroicon-o-x-circle')
                ->iconColor('danger')
                ->body('No se pudo obtener la lista de estados')
                ->send();

        }
        $user = User::find($record);
        $this->countries=Country::all()->pluck('name','id')->toArray();



        parent::mount($record); // TODO: Change the autogenerated stub

    }
}
