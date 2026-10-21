<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrivacyNoticeResource\Pages;
use App\Filament\Resources\PrivacyNoticeResource\RelationManagers;
use App\Models\PrivacyNotice;
use App\Services\PrivacyNoticeService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PrivacyNoticeResource extends Resource
{
    protected static ?string $model = PrivacyNotice::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'ADC Estructura';
    protected static ?string $modelLabel = 'Aviso de Privacidad';
    protected static ?string $pluralModelLabel = 'Avisos de Privacidad';
    protected static ?int $navigationSort = 5;

    public static function canViewAny(): bool
    {
        return Auth::user()?->hasAnyRole('Administrador', 'Super Administrador', 'RH Corp') ?? false;
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->hasAnyRole('Administrador', 'Super Administrador', 'RH Corp') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()?->hasAnyRole('Administrador', 'Super Administrador', 'RH Corp') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()?->hasAnyRole('Administrador', 'Super Administrador') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('Configuración General del Aviso')
                    ->description('Establece cómo se mostrará el aviso al ingresar a la plataforma y cómo se resolverán los datos del Responsable.')
                    ->icon('heroicon-m-cog-6-tooth')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Nombre del Aviso (Aparece en la Cabecera/Header del Modal)')
                            ->required()
                            ->maxLength(255)
                            ->default('Aviso de Privacidad y Protección de Datos Personales')
                            ->placeholder('Ej. Aviso de Privacidad Institucional')
                            ->columnSpan(['sm' => 2]),

                        Forms\Components\TextInput::make('version')
                            ->label('Versión')
                            ->maxLength(50)
                            ->default('v1.0')
                            ->placeholder('Ej. v1.0 - 2026')
                            ->columnSpan(['sm' => 1]),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aviso Vigente (Activo)')
                            ->helperText('Al marcar como activo, los usuarios deberán aceptar esta versión en su próximo inicio de sesión.')
                            ->default(true)
                            ->inline(false)
                            ->columnSpan(['sm' => 1]),

                        Forms\Components\Select::make('scope_type')
                            ->label('Tipo de Configuración de Datos del Responsable')
                            ->options(PrivacyNotice::getScopeOptions())
                            ->default(PrivacyNotice::SCOPE_RAZON_SOCIAL)
                            ->required()
                            ->live()
                            ->helperText('Define de dónde toma el aviso el Nombre de la Empresa Contratante y la Dirección.')
                            ->columnSpan(['sm' => 2]),

                        Forms\Components\TextInput::make('provider_name')
                            ->label('Nombre de la Empresa Proveedora')
                            ->default('NetInnfode')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('NetInnfode')
                            ->helperText('Sustituye la etiqueta [NOMBRE DE LA EMPRESA PROVEEDORA] en los textos.')
                            ->columnSpan(['sm' => 2]),

                        Forms\Components\TextInput::make('general_company_name')
                            ->label('Nombre de Empresa Contratante (General / Respaldo)')
                            ->maxLength(255)
                            ->placeholder('Ej. RAZÓN SOCIAL CORPORATIVA S.A. DE C.V.')
                            ->helperText('Utilizado cuando el tipo es General, o si la sede de un colaborador no tiene Razón Social capturada.')
                            ->columnSpan(['sm' => 2]),

                        Forms\Components\Textarea::make('general_address')
                            ->label('Dirección Completa (General / Respaldo)')
                            ->rows(2)
                            ->placeholder('Calle, No. Exterior, Colonia, C.P., Ciudad, Estado')
                            ->helperText('Utilizada cuando el tipo es General o si la Sede no tiene domicilio capturado.')
                            ->columnSpan(['sm' => 2]),
                    ])->columns(2),

                Forms\Components\Section::make('Configuración de Etapas del Aviso')
                    ->description('Define si el flujo incluye un Aviso Inicial de entrada y/o un Aviso de Privacidad Integral adicional al Aviso Simplificado.')
                    ->icon('heroicon-m-adjustments-horizontal')
                    ->schema([
                        Forms\Components\Toggle::make('has_initial_notice')
                            ->label('1. ¿Mostrar Aviso Importante al inicio (antes del Simplificado)?')
                            ->helperText('Si está activo, se muestra primero el Encabezado de Entrada y luego el Aviso Simplificado. Si se desactiva, se muestra directamente el Aviso de Privacidad Simplificado.')
                            ->default(true)
                            ->live()
                            ->afterStateUpdated(function (bool $state, Forms\Get $get, Forms\Set $set) {
                                if ($state && empty(trim(strip_tags((string) $get('initial_notice_content'))))) {
                                    $set('initial_notice_content', PrivacyNoticeService::getDefaultInitialContent());
                                }
                            })
                            ->columnSpan(['sm' => 1]),

                        Forms\Components\Toggle::make('has_extended_notice')
                            ->label('2. ¿Incluir Aviso de Privacidad Integral (Extendido)?')
                            ->helperText('Si cuentas con el Aviso de Privacidad Integral, actívalo para subirlo en la pestaña correspondiente. Si se desactiva, solo estará el Aviso Simplificado (con o sin Aviso Inicial).')
                            ->default(false)
                            ->live()
                            ->afterStateUpdated(function (bool $state, Forms\Get $get, Forms\Set $set) {
                                if ($state && empty(trim(strip_tags((string) $get('extended_content'))))) {
                                    $set('extended_content', PrivacyNoticeService::getDefaultExtendedContent());
                                }
                            })
                            ->columnSpan(['sm' => 1]),
                    ])->columns(2),

                Forms\Components\Section::make('Variables Dinámicas Disponibles')
                    ->description('Puedes insertar cualquiera de las siguientes etiquetas en los editores de texto para que se reemplacen dinámicamente según el usuario que ingrese:')
                    ->collapsed()
                    ->schema([
                        Forms\Components\Placeholder::make('variables_guide')
                            ->hiddenLabel()
                            ->content(new \Illuminate\Support\HtmlString('
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                                    <div class="p-2.5 rounded bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                        <code class="font-bold text-amber-600 dark:text-amber-400">[NOMBRE DE LA EMPRESA PROVEEDORA]</code>
                                        <p class="mt-1 text-gray-600 dark:text-gray-400">Inserta la empresa proveedora (por defecto NetInnfode).</p>
                                    </div>
                                    <div class="p-2.5 rounded bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                        <code class="font-bold text-amber-600 dark:text-amber-400">[NOMBRE DE LA EMPRESA CONTRATANTE]</code>
                                        <p class="mt-1 text-gray-600 dark:text-gray-400">Inserta la Razón Social o Sede según el tipo configurado.</p>
                                    </div>
                                    <div class="p-2.5 rounded bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                        <code class="font-bold text-amber-600 dark:text-amber-400">[DIRECCIÓN COMPLETA]</code>
                                        <p class="mt-1 text-gray-600 dark:text-gray-400">Inserta el domicilio registrado de la Sede o el respaldo general.</p>
                                    </div>
                                </div>
                            ')),
                    ]),

                Forms\Components\Tabs::make('Contenido y Estilo del Aviso')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Aviso Inicial (Entrada)')
                            ->icon('heroicon-m-information-circle')
                            ->visible(fn (Forms\Get $get): bool => (bool) $get('has_initial_notice'))
                            ->schema([
                                Forms\Components\RichEditor::make('initial_notice_content')
                                    ->label('Encabezado de Entrada a la Plataforma (Aviso Importante)')
                                    ->default(fn () => PrivacyNoticeService::getDefaultInitialContent())
                                    ->required(fn (Forms\Get $get): bool => (bool) $get('has_initial_notice'))
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'link',
                                        'bulletList',
                                        'orderedList',
                                        'undo',
                                        'redo',
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Aviso de Privacidad Simplificado')
                            ->icon('heroicon-m-document-text')
                            ->schema([
                                Forms\Components\RichEditor::make('simplified_content')
                                    ->label('Contenido del Aviso de Privacidad Simplificado')
                                    ->default(fn () => PrivacyNoticeService::getDefaultSimplifiedContent())
                                    ->required()
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'strike',
                                        'link',
                                        'heading',
                                        'h2',
                                        'h3',
                                        'bulletList',
                                        'orderedList',
                                        'blockquote',
                                        'undo',
                                        'redo',
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Aviso de Privacidad Integral')
                            ->icon('heroicon-m-book-open')
                            ->visible(fn (Forms\Get $get): bool => (bool) $get('has_extended_notice'))
                            ->schema([
                                Forms\Components\RichEditor::make('extended_content')
                                    ->label('Contenido del Aviso de Privacidad Integral (Subir / Capturar)')
                                    ->helperText('Requerido cuando la opción "¿Incluir Aviso de Privacidad Integral?" está activada.')
                                    ->default(fn () => PrivacyNoticeService::getDefaultExtendedContent())
                                    ->required(fn (Forms\Get $get): bool => (bool) $get('has_extended_notice'))
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'strike',
                                        'link',
                                        'heading',
                                        'h2',
                                        'h3',
                                        'bulletList',
                                        'orderedList',
                                        'blockquote',
                                        'undo',
                                        'redo',
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Casilla de Aceptación')
                            ->icon('heroicon-m-check-badge')
                            ->schema([
                                Forms\Components\Textarea::make('checkbox_label')
                                    ->label('Texto para la Casilla de Aceptación')
                                    ->default(fn () => PrivacyNoticeService::getDefaultCheckboxLabel())
                                    ->required()
                                    ->rows(4)
                                    ->helperText('Texto legal que acompaña la casilla que el colaborador debe marcar antes de aceptar.'),
                            ]),
                    ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('is_active', 'desc')
            ->columns([
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Vigente')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Nombre del Aviso (Cabecera)')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('version')
                    ->label('Versión')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('flow_summary')
                    ->label('Flujo Configurado')
                    ->badge()
                    ->getStateUsing(function (PrivacyNotice $record): string {
                        if ($record->has_initial_notice && $record->has_extended_notice) {
                            return 'Inicial + Simplificado + Integral';
                        }
                        if ($record->has_initial_notice && !$record->has_extended_notice) {
                            return 'Inicial + Simplificado';
                        }
                        if (!$record->has_initial_notice && $record->has_extended_notice) {
                            return 'Simplificado + Integral';
                        }

                        return 'Solo Simplificado';
                    })
                    ->color(fn (string $state) => match ($state) {
                        'Inicial + Simplificado + Integral' => 'success',
                        'Inicial + Simplificado' => 'info',
                        'Simplificado + Integral' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('scope_type')
                    ->label('Tipo de Configuración')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        PrivacyNotice::SCOPE_RAZON_SOCIAL => 'Por Razón Social',
                        PrivacyNotice::SCOPE_SEDE => 'Por Sede',
                        PrivacyNotice::SCOPE_GENERAL => 'General',
                        default => $state,
                    })
                    ->color(fn (string $state) => match ($state) {
                        PrivacyNotice::SCOPE_RAZON_SOCIAL => 'primary',
                        PrivacyNotice::SCOPE_SEDE => 'warning',
                        PrivacyNotice::SCOPE_GENERAL => 'gray',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('acceptances_count')
                    ->counts('acceptances')
                    ->label('Aceptaciones')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                Tables\Columns\TextColumn::make('provider_name')
                    ->label('Proveedor')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Solo Vigente')
                    ->trueLabel('Avisos Vigentes')
                    ->falseLabel('Históricos'),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->label('Vista Previa')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->action(function (PrivacyNotice $record, $livewire) {
                        $livewire->dispatch('open-privacy-notice-preview', noticeId: $record->id);
                    }),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AcceptancesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrivacyNotices::route('/'),
            'create' => Pages\CreatePrivacyNotice::route('/create'),
            'edit' => Pages\EditPrivacyNotice::route('/{record}/edit'),
        ];
    }
}
