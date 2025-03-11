<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\Widgets\UsersStatsOverview;
use App\Models\User;
use App\Models\Sede;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Wizard;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Pages\Actions\CreateAction;
use App\Models\UserTermination;
use Filament\Notifications\Notification;



class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Colaboradores';
    protected static ?string $navigationLabel = 'Usuarios';
    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        if (\auth()->user()->hasAnyRole('RH','RH Corp','Administrador')) {
            return true;
        }else{
            return false;
        }
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);


    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('status')
                    ->label('Estatus')
                    ->boolean(),
                Tables\Columns\ImageColumn::make('profile_photo')
                    ->circular()
                    ->label('Avatar'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->label('Primer Apellido')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Segundo Apellido')
                    ->searchable(),
                Tables\Columns\TextColumn::make('curp')
                    ->label('CURP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nationality')
                    ->label('Nacionalidad')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('birthdate')
                    ->label('Fecha de Nacimiento')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('birth_country')
                    ->label('País de Nacimiento')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('birth_state')
                    ->label('Estado de Nacimiento')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('birth_city')
                    ->label('Ciudad de Nacimiento')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('disability')
                    ->label('Discapacidad')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo Electrónico')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Dirección')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('colony')
                    ->label('Colonia')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('cp')
                    ->label('Código Postal')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('state')
                    ->label('Estado')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Ciudad')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('scholarship')
                    ->label('Escolaridad')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('career')
                    ->label('Carrera')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('sede.name')
                    ->label('Sede')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->label('Departamento')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position.name')
                    ->label('Puesto')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rfc')
                    ->label('RFC')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('imss')
                    ->label('IMSS')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('contract_type')
                    ->label('Tipo de Contrato')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('entry_date')
                    ->label('Fecha de Ingreso')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn () => \Auth::user()->hasAnyRole('RH','RH Corp','Administrador')),
                Tables\Actions\ViewAction::make()
                    ->form([
                        Forms\Components\Fieldset::make('Información Personal')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre')
                                    ->disabled(),
                                Forms\Components\TextInput::make('first_name')
                                    ->label('Primer Apellido')
                                    ->disabled(),
                                Forms\Components\TextInput::make('last_name')
                                    ->label('Segundo Apellido')
                                    ->disabled(),
                                Forms\Components\TextInput::make('curp')
                                    ->label('CURP')
                                    ->disabled(),
                                Forms\Components\TextInput::make('rfc')
                                    ->label('RFC')
                                    ->disabled(),
                                Forms\Components\TextInput::make('ims')
                                    ->label('ims')
                                    ->disabled(),
                                Forms\Components\TextInput::make('sex')
                                    ->label('Sexo')
                                    ->disabled(),
                                Forms\Components\TextInput::make('birthdate')
                                    ->label('Fecha de Nacimiento')
                                    ->disabled(),

                                Forms\Components\Textarea::make('address')
                                    ->label('Dirección')
                                    ->disabled(),
                                Forms\Components\TextInput::make('colony')
                                    ->label('Colonia')
                                    ->disabled(),
                                Forms\Components\TextInput::make('cp')
                                    ->label('Código Postal')
                                    ->disabled(),
                                Forms\Components\TextInput::make('state')
                                    ->label('Estado')
                                    ->disabled(),
                            ])->columns(3),

                        Forms\Components\Fieldset::make('Información de Contacto')
                            ->schema([
                                Forms\Components\TextInput::make('email')
                                    ->label('Correo Electrónico')
                                    ->disabled(),
                                Forms\Components\TextInput::make('phone')
                                    ->label('Teléfono')
                                    ->disabled(),
                            ]),
                        Forms\Components\Fieldset::make('Información Laboral')
                            ->schema([
                                Forms\Components\BelongsToSelect::make('sede_id')
                                    ->label('Sede')
                                    ->relationship('sede', 'name')
                                    ->disabled(),
                                Forms\Components\BelongsToSelect::make('department_id')
                                    ->label('Departamento')
                                    ->relationship('department', 'name')
                                    ->disabled(),
                                Forms\Components\BelongsToSelect::make('position_id')
                                    ->label('Puesto')
                                    ->relationship('position', 'name')
                                    ->disabled(),
                                Forms\Components\TextInput::make('contract_type')
                                    ->label('Tipo de Contrato')
                                    ->disabled(),
                                Forms\Components\DatePicker::make('entry_date')
                                    ->label('Fecha de Ingreso')
                                    ->disabled(),
                            ])
                        ]),
                Tables\Actions\Action::make('bajaUsuario')
                    ->visible(fn () => \Auth::user()->hasAnyRole('RH','RH Corp','Administrador'))
                    ->label('Baja')
                    ->color('danger')
                    ->icon('heroicon-s-user-minus')
                    ->requiresConfirmation(false)
                    ->modalHeading('Formato de Baja de Usuario')
                    ->modalDescription('Por favor, complete la información para dar de baja del usuario.')
                    ->modalCloseButton()
                    ->modalCancelAction()
                    ->modalSubmitAction()
                    ->modalSubmitActionLabel('Dar de Baja')
                    ->form([
                        Forms\Components\Fieldset::make('Información de baja')
                            ->schema([
                                Forms\Components\DatePicker::make('termination_date')
                                    ->label('Fecha Efectiva de Baja')
                                    ->required()
                                    ->default(now()),
                                Forms\Components\Select::make('termination_type')
                                    ->label('Motivo de Baja')
                                    ->options([
                                        'renuncia_voluntaria' => 'Renuncia Voluntaria',
                                        'despido' => 'Despido',
                                        'terminacion_contrato' => 'Terminación de Contrato',
                                        'jubilacion' => 'Jubilación',
                                        'incapacidad' => 'Baja por Salud/Incapacidad',
                                        'otro' => 'Otro'
                                    ])
                                    ->reactive()
                                    ->required(),
                                Forms\Components\TextInput::make('other_reason')
                                    ->label('Especificar Otro Motivo')
                                    ->visible(fn ($get) => $get('termination_type') === 'otro'),

                                Forms\Components\Toggle::make('prior_notice')
                                    ->label('¿Dio previo aviso?')
                                    ->default(false)
                                    ->reactive(),
                                Forms\Components\TextInput::make('notice_days')
                                    ->label('Días de anticipación')
                                    ->type('number')
                                    ->visible(fn ($get) => $get('prior_notice')),
                                Forms\Components\Textarea::make('detailed_reason')
                                    ->label('Motivo Detallado de la Baja')
                                    ->required()
                                ->columnSpanFull(),
                            ])->columns(2),
                        Forms\Components\Fieldset::make('Desempeño')
                            ->schema([
                                Forms\Components\Select::make('performance')
                                    ->label('Desempeño General')
                                    ->options([
                                        'bueno' => 'Bueno',
                                        'regular' => 'Regular',
                                        'deficiente' => 'Deficiente'
                                    ])
                                    ->required(),
                                Forms\Components\Textarea::make('performance_comments')
                                    ->label('Comentarios sobre Desempeño')
                                    ->required(),
                                Forms\Components\Textarea::make('supervisor_feedback')
                                    ->label('Retroalimentación del Jefe Inmediato')
                                    ->required(),
                            ]),

                        Forms\Components\Fieldset::make('Proceso de entrega')
                            ->schema([
                                Forms\Components\CheckboxList::make('documents_delivered')
                                    ->label('Documentos Entregados')
                                    ->options([
                                        'carta_renuncia' => 'Carta de Renuncia',
                                        'finiquito' => 'Finiquito',
                                        'otros' => 'Otros Documentos'
                                    ]),
                                Forms\Components\Toggle::make('settlement_completed')
                                    ->label('¿Liquidación Completada?')
                                ->reactive(),
                                Forms\Components\Textarea::make('settlement_details')
                                    ->label('Detalles de la Liquidación')
                                    ->visible(fn ($get) => $get('settlement_completed')),
                        ]),
                        Forms\Components\Fieldset::make('Puesto de Trabajo')
                            ->schema([
                                Forms\Components\Toggle::make('impacts_team')
                                    ->label('¿Es una posición crítica para el equipo?')
                                ->reactive(),
                                Forms\Components\Toggle::make('position_replaced')
                                    ->label('¿Requiere Reemplazo?')
                                    ->reactive(),
                                Forms\Components\Select::make('replacement_urgency')
                                    ->label('Urgencia del Reemplazo')
                                    ->options([
                                        'inmediato' => 'Inmediato',
                                        'proximos_dias' => 'Próximos Días',
                                        'próximas_semanas' => 'Próximas Semanas',
                                        '1_mes' => '1 Mes',
                                        '3_meses' => '3 Meses',
                                        '6_meses' => '6 Meses',
                                        '1_año' => '1 Año'
                                    ])
                                    ->visible(fn ($get) => $get('position_replaced')),


                            ]),
                        Forms\Components\Fieldset::make('Información Adicional')
                            ->schema([
                                Forms\Components\Textarea::make('additional_comments')
                                    ->label('Comentarios Adicionales')
                                    ->rows(4)
                                    ->columnSpanFull(),
                                Forms\Components\Toggle::make('access_deactivated')
                                    ->label('¿Desactivar Acceso a Sistemas?'),

                                Forms\Components\Toggle::make('exit_interview')
                                    ->label('Enviar entrevista de salida'),
                                Forms\Components\Toggle::make('re_hire')
                                    ->label('¿El colaborador es Recontratable?'),
                            ]),
                    ])
                    ->action(function (array $data, User $record): void {
                        // Crear registro de baja
                        UserTermination::create([
                            'user_id' => $record->id,
                            'processed_by' => auth()->id(),
                            ...$data
                        ]);

                        // Actualizar estado del usuario
                        $record->update([
                            'status' => false
                        ]);

                        Notification::make()
                            ->success()
                            ->title('Usuario dado de baja correctamente')
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make(),
            ])->modifyQueryUsing(function (Builder $query) {
                // Si el usuario tiene el rol "Jefe RH", filtrar por su sede_id
                if (auth()->user()->hasRole('RH')) {
                    $query->where('sede_id', \auth()->user()->sede_id);
                }elseif ( auth()->user()->hasRole('Supervisor') ) {
                    $supervisorId = auth()->user()->position_id;
                    $users = User::where('status', true)
                        ->whereNotNull('department_id')
                        ->whereNotNull('position_id')
                        ->whereNotNull('sede_id')
                        ->whereHas('position', function ($query) use ($supervisorId) {
                            $query->where('supervisor_id', $supervisorId);
                        })
                        ->pluck('users.id');


                    $query->whereIn('id', $users);
                }
            });
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PortfolioRelationManager::class,
        ];
    }
    public static function getWidgets(): array
    {
        return [
          UsersStatsOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
