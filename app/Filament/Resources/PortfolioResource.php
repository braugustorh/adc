<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioResource\Pages;
use App\Filament\Resources\PortfolioResource\RelationManagers;
use App\Helpers\VisorRoleHelper;
use App\Models\User;
use App\Models\Portfolio;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\Page;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';
    protected static ?string $navigationGroup = 'Colaboradores';
    protected static ?string $navigationLabel = 'Portafolio Digital';
    protected static ?string $name = 'Portfolio';
    protected static ?string $label = 'Portafolio Digital';
    protected static ?string $title= 'Portafolio Digital';
    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {

        return (\auth()->user()->hasAnyRole('RH','RH Corp','Administrador','Supervisor','Colaborador','Visor'));

    }
    public static function canCreate(): bool
    {
        return (\auth()->user()->hasAnyRole('RH','RH Corp','Administrador'));
    }
    public static function canEdit(Model $record): bool
    {
        return (\auth()->user()->hasAnyRole('RH','RH Corp','Administrador'));
    }

    public static function form(Form $form): Form
    {
        $forms=Section::make('Portafolio')
            ->description('Sube los documentos requeridos. Puedes subir imágenes o PDF de un tamaño máximo de 2MB')
            ->icon('heroicon-m-square-3-stack-3d')
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Colaborador')
                    ->searchable()
                    ->preload()
                    ->options(function (Get $get):Collection {
                        if ($get('user_id')!==null){
                            $user= User::query()
                                ->where('id', $get('user_id'))
                                ->where('status',1)
                                ->where('id','!=',1)
                                ->get()
                                ->mapWithKeys(fn (User $user): array => [$user->id => $user->name.' '.$user->first_name .' '.$user->last_name]);
                        }else{
                            if (auth()->user()->hasAnyRole('Administrador','RH Corp','Visor')){
                                $user=User::query()
                                    ->doesntHave('portfolio')
                                    ->where('status',1)
                                    ->where('id','!=',1)
                                    ->with('portfolio') // Incluye la relación 'portfolio' en la consulta
                                    ->get()
                                    ->mapWithKeys(fn (User $user): array => [
                                        $user->id => $user->name.' '.$user->first_name.' '.$user->last_name
                                    ]);
                            }elseif (auth()->user()->hasRole('RH')){
                                $user= User::query()
                                    ->doesntHave('portfolio')
                                    ->where('status',1)
                                    ->where('id','!=',1)
                                    ->where('sede_id',\auth()->user()->sede_id)
                                    ->with('portfolio') // Incluye la relación 'portfolio' en la consulta
                                    ->get()
                                    ->mapWithKeys(fn (User $user): array => [
                                        $user->id => $user->name.' '.$user->first_name.' '.$user->last_name
                                    ]);
                            }elseif(auth()->user()->hasRole('Supervisor')) {
                                $supervisorId = auth()->user()->id;
                                $user= User::query()
                                    ->doesntHave('portfolio')
                                    ->where('status',1)
                                    ->where('sede_id',\auth()->user()->sede_id)
                                    ->where('department_id',\auth()->user()->department_id)
                                    ->with('portfolio') // Incluye la relación 'portfolio' en la consulta
                                    ->whereHas('position', function ($query) use ($supervisorId) {
                                        $query->where('supervisor_id', $supervisorId);
                                    })
                                    ->get()
                                    ->mapWithKeys(fn (User $user): array => [
                                        $user->id => $user->name.' '.$user->first_name.' '.$user->last_name
                                    ]);

                            }else{
                                $user= User::query()
                                    ->where('id',\auth()->user()->id)
                                    ->get()
                                    ->mapWithKeys(fn (User $user): array => [$user->id => $user->name.' '.$user->first_name .' '.$user->last_name]);
                            }

                        }
                            return $user;
                        })
                    ->disabled(fn (string $operation): bool => $operation === 'edit')
                    ->required(),
                    Forms\Components\Fieldset::make('Identificación Oficial')
                        ->schema([
                            Forms\Components\FileUpload::make('acta_url')
                                ->label('Acta de nacimiento')
                                ->downloadable(true)
                                ->openable(true)
                                ->previewable(true)
                                ->acceptedFileTypes(['image/*', 'application/pdf'])
                                ->maxSize('2048')
                                ->disk('sedyco_disk') // Usar el nombre específico del disco
                                ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                                ->visibility('public') // Asegurarse que sea público
                                ->default(null),
                            Forms\Components\FileUpload::make('ine_url')
                                ->label('Identificación Oficial Vigente')
                                ->disk('sedyco_disk')
                                ->visibility('public') // Asegurarse que sea público
                                ->downloadable('true')
                                ->openable()
                                ->previewable('true')
                                ->helperText('Los documentos válidos son: Credencial para votar (INE), Pasaporte o Cédula Profesional.')
                                ->acceptedFileTypes(['image/*', 'application/pdf'])
                                ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                                ->maxSize('2048')
                                ->default(null),
                            Forms\Components\FileUpload::make('curp_url')
                                ->label('CURP')
                                ->disk('sedyco_disk')
                                ->visibility('public')
                                ->downloadable('true')
                                ->openable()
                                ->previewable('true')
                                ->acceptedFileTypes(['image/*', 'application/pdf'])
                                ->maxSize('2048')
                                ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                                ->default(null),
                    ]),
                Forms\Components\Fieldset::make('Comprobantes de Domicilio y Situación Fiscal')

                    ->schema([
                        Forms\Components\FileUpload::make('comprobante_domicilio_url')
                            ->label('Comprobante de domicilio')
                            ->helperText('Los documentos válidos son: Recibo de luz, agua, teléfono o predial. No mayor a 3 meses de antigüedad.')
                            ->disk('sedyco_disk')
                            ->visibility('public')
                            ->downloadable('true')
                            ->openable()
                            ->previewable('true')
                            ->acceptedFileTypes(['image/*', 'application/pdf'])
                            ->maxSize('2048')
                            ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                            ->default(null),
                        Forms\Components\FileUpload::make('rfc_url')
                            ->label('Constancia Situación Fiscal')
                            ->disk('sedyco_disk')
                            ->visibility('public')
                            ->downloadable('true')
                            ->previewable('true')
                            ->openable()
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize('2048')
                            ->helperText('Constancia de Situación Fiscal actualizada')
                            ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                            ->default(null),
                        ]),
                Forms\Components\Fieldset::make('Información Laboral')
                    ->schema([
                        Forms\Components\FileUpload::make('sol_empleo_url')
                            ->label('Solicitud de Empleo')
                            ->disk('sedyco_disk')
                            ->visibility('public')
                            ->downloadable('true')
                            ->previewable('true')
                            ->openable()
                            ->acceptedFileTypes(['image/*','application/pdf'])
                            ->maxSize('2048')
                            ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                            ->default(null),
                        Forms\Components\FileUpload::make('recomendacion_url')
                            ->label('Carta de recomendación 1')
                            ->disk('sedyco_disk')
                            ->visibility('public')
                            ->downloadable('true')
                            ->openable()
                            ->previewable('true')
                            ->acceptedFileTypes(['image/*', 'application/pdf'])
                            ->maxSize('2048')
                            ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                            ->default(null),
                        Forms\Components\FileUpload::make('comprobante_estudios_url')
                            ->label('Comprobante del último grado de estudios')
                            ->downloadable('true')
                            ->disk('sedyco_disk')
                            ->visibility('public')
                            ->openable()
                            ->previewable('true')
                            ->acceptedFileTypes(['image/*', 'application/pdf'])
                            ->maxSize('2048')
                            ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                            ->default(null),
                        ]),
                Forms\Components\Fieldset::make('Documentos médicos y de seguridad social')
                    ->schema([
                        Forms\Components\FileUpload::make('cert_medico_url')
                            ->label('Certificado médico')
                            ->disk('sedyco_disk')
                            ->visibility('public')
                            ->downloadable('true')
                            ->openable()
                            ->previewable('true')
                            ->acceptedFileTypes(['image/*','application/pdf'])
                            ->maxSize('2048')
                            ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                            ->default(null),
                        Forms\Components\FileUpload::make('nss_url')
                            ->label('Número de Seguro Social')
                            ->disk('sedyco_disk')
                            ->visibility('public')
                            ->downloadable('true')
                            ->previewable('true')
                            ->openable()
                            ->acceptedFileTypes(['image/*','application/pdf'])
                            ->maxSize('2048')
                            ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                            ->default(null),
                        Forms\Components\FileUpload::make('alta_imss_url')
                            ->downloadable('true')
                            ->disk('sedyco_disk')
                            ->visibility('public')
                            ->previewable('true')
                            ->openable()
                            ->hidden(fn (): bool => !auth()->user()->hasAnyRole(['Administrador', 'RH Corp', 'RH','Supervior']))
                            ->label('Alta en el IMSS')
                            ->acceptedFileTypes(['image/*', 'application/pdf'])
                            ->maxSize('2048')
                            ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                            ->default(null),
                        Forms\Components\FileUpload::make('modificacion_imss_url')
                            ->downloadable('true')
                            ->disk('sedyco_disk')
                            ->visibility('public')
                            ->previewable('true')
                            ->openable()
                            ->hidden(fn (): bool => !auth()->user()->hasAnyRole(['Administrador', 'RH','RH Corp']))
                            ->label('Modificación en el IMSS')
                            ->acceptedFileTypes(['image/*', 'application/pdf'])
                            ->maxSize('2048')
                            ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                            ->default(null),
                        Forms\Components\FileUpload::make('baja_imss_url')
                            ->disk('sedyco_disk')
                            ->visibility('public')
                            ->downloadable('true')
                            ->previewable('true')
                            ->openable()
                            ->hidden(fn (): bool => !auth()->user()->hasAnyRole(['Administrador', 'RH','RH Corp']))
                            ->label('Baja en el IMSS')
                            ->acceptedFileTypes(['image/*', 'application/pdf'])
                            ->maxSize('2048')
                            ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                            ->default(null),
                        ]),
                Forms\Components\Fieldset::make(' Documentos legales y financieros')
                    ->schema([
                        Forms\Components\FileUpload::make('carta_no_antecedentes_url')
                            ->disk('sedyco_disk')
                            ->visibility('public')
                            ->downloadable('true')
                            ->previewable('true')
                            ->openable()
                            ->label('Carta de no antecedentes penales')
                            ->acceptedFileTypes(['image/*', 'application/pdf'])
                            ->maxSize('2048')
                            ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                            ->default(null),
                        Forms\Components\FileUpload::make('retencion_url')
                            ->label('Retención de Crédito Infonavit')
                            ->disk('sedyco_disk')
                            ->visibility('public')
                            ->downloadable('true')
                            ->previewable('true')
                            ->openable()
                            ->acceptedFileTypes(['image/*','application/pdf'])
                            ->maxSize('2048')
                            ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                            ->default(null),
                        Forms\Components\FileUpload::make('renuncia_url')
                            ->downloadable('true')
                            ->previewable('true')
                            ->disk('sedyco_disk')
                            ->visibility('public')
                            ->openable()
                            ->hidden(fn (): bool => !auth()->user()->hasAnyRole(['Administrador', 'RH','RH Corp']))
                            ->label('Renuncia')
                            ->acceptedFileTypes(['image/*', 'application/pdf'])
                            ->maxSize('2048')
                            ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                            ->default(null),
                        Forms\Components\FileUpload::make('finiquito_url')
                            ->disk('sedyco_disk')
                            ->visibility('public')
                            ->downloadable('true')
                            ->previewable('true')
                            ->openable()
                            ->hidden(fn (): bool => !auth()->user()->hasAnyRole(['Administrador', 'RH','RH Corp']))
                            ->label('Finiquito')
                            ->acceptedFileTypes(['image/*', 'application/pdf'])
                            ->maxSize('2048')
                            ->directory(fn (Get $get): string => "portafolio/{$get('user_id')}")
                            ->default(null),
                    ]),
            ])->columns(3);
        return $form->schema([
            $forms,
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nombre')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('acta_url')
                    ->label('Acta de nacimiento')
                    ->icon(function ($record): string {
                        $url =$record->acta_url;
                        return $url ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle';

                    })->color(function ($record): string {
                        $url =$record->acta_url;
                        return $url ? 'success' : 'danger';
                    })->alignCenter(),
                Tables\Columns\IconColumn::make('curp_url')
                    ->label('CURP')
                    ->icon(function ($record): string {
                        $url =$record->curp_url;
                        return $url!==null ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle';

                    })->color(function ($record): string {
                        $url =$record->curp_url;
                        return $url!==null  ? 'success' : 'danger';
                    })->alignCenter(),
                Tables\Columns\IconColumn::make('rfc_url')
                    ->label('RFC')
                    ->icon(function ($record): string {
                        $url =$record->rfc_url;
                        return $url!==null  ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle';

                    })->color(function ($record): string {
                        $url =$record->rfc_url;
                        return $url ? 'success' : 'danger';
                    })->alignCenter(),

                Tables\Columns\IconColumn::make('ine_url')
                    ->label('Identificación Oficial')
                    ->icon(function ($record): string {
                        $url =$record->ine_url;
                        return $url ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle';
                    })->color(function ($record): string {
                        $url =$record->ine_url;
                        return $url ? 'success' : 'danger';
                    })->alignCenter(),

                Tables\Columns\IconColumn::make('comprobante_domicilio_url')
                    ->label('Comprobante de domicilio')
                    ->icon(function ($record): string {
                        $url =$record->comprobante_domicilio_url;
                        return $url ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle';

                    })->color(function ($record): string {
                        $url =$record->comprobante_domicilio_url;
                        return $url ? 'success' : 'danger';
                    })->alignCenter(),
                Tables\Columns\IconColumn::make('comprobante_estudios_url')
                    ->label('Comprobante de estudios')
                    ->icon(function ($record): string {
                        $url =$record->comprobante_estudios_url;
                        return $url ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle';
                    })->color(function ($record): string {
                        $url =$record->comprobante_estudios_url;
                        return $url ? 'success' : 'danger';
                    })->alignCenter(),
                Tables\Columns\IconColumn::make('carta_no_antecedentes_url')
                    ->label('Antecedentes Penales')
                    ->icon(function ($record): string {
                        $url =$record->carta_no_antecedentes_url;
                        //dd($url);
                        return $url ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle';
                    })->color(function ($record): string {
                        $url =$record->carta_no_antecedentes_url;
                        return $url ? 'success' : 'danger';
                    })->alignCenter(),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn()=>VisorRoleHelper::canEdit()),
                ]),
            ])->modifyQueryUsing(function (Builder $query) {
                // Si el usuario tiene el rol "Jefe RH", filtrar por su sede_id
                if (auth()->user()->hasRole('RH')) {
                    $users=User::where('sede_id',\auth()->user()->sede_id)->pluck('id');
                    $query->whereIn('user_id', $users);
                }
//                elseif(auth()->user()->hasRole('Jefe de Área')){
//                    $supervisorId = \auth()->user()->position_id;
//                    $users = User::where('status', true)
//                        ->whereNotNull('department_id')
//                        ->whereNotNull('position_id')
//                        ->whereNotNull('sede_id')
//                        ->whereHas('position', function ($query) use ($supervisorId) {
//                            $query->where('supervisor_id', $supervisorId);
//                        })
//                        ->pluck('users.id');
//
//                    $query->whereIn('user_id', $users);
//
//                }
                elseif(auth()->user()->hasAnyRole('Colaborador','Supervisor','Operativo')){
                    $query->where('user_id',\auth()->user()->id);
                }
            });
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPortfolios::route('/'),
            'create' => Pages\CreatePortfolio::route('/create'),
            'edit' => Pages\EditPortfolio::route('/{record}/edit'),
        ];
    }
}
