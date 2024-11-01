<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PositionResource\Pages;
use App\Filament\Resources\PositionResource\RelationManagers;
use App\Models\Department;
use App\Models\Position;
use App\Models\Sede;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'ADC Estructura';
    protected static ?string $navigationLabel = 'Puestos';
    protected static ?int $navigationSort = 3;
    public static function canViewAny(): bool
    {
        return \auth()->user()->hasRole('Administrador');

    }

    public static function form(Form $form): Form
    {
        $formulario= Section::make('Información del Puesto')
            ->description('Agrega la información del Puesto para cada departamento')
            ->icon('heroicon-m-identification')
            ->schema([
                Forms\Components\Select::make('sede')
                    ->label('Sede')
                    ->relationship('department.sede', 'name')
                    ->required()
                    ->reactive()
                    ->preload()
                    ->loadStateFromRelationshipsUsing(function ($state) {
                        return $state->department->sede_id ?? null;
                    })
                    ->afterStateUpdated(function (callable $set) {
                        $set('department_id', null);
                    }),

                Forms\Components\Select::make('department_id')
                    ->label('Departamento')
                    ->options(function (Get $get, ?string $state): Collection {
                        // Si estamos editando y hay un valor en state
                        if ($state) {
                            $departments = Department::where('sede_id', $get('sede'))
                                ->orWhere('id', $state)  // Incluye el departamento actual
                                ->get();
                        } else {
                            $departments = Department::where('sede_id', $get('sede'))->get();
                        }
                        return $departments->pluck('name', 'id');
                    })
                    ->required()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->label('Nombre del Puesto')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('description')
                    ->label('Descripción del Puesto')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('order')
                    ->label('Orden Jerarquico del Puesto')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('supervisor_id')
                    ->label('Supervisor')
                    ->relationship('supervisor', 'name')
                    ->nullable()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('evaluation_grades')
                    ->label('Tipos de Evaluación 360')
                    ->helperText('Selecciona el tipo de evaluación 360 correspondiente al puesto')
                    ->options([
                        180 => '180',
                        270 => '270',
                        360 => '360',
                    ])
                    ->required(),
                Forms\Components\Toggle::make('status')
                    ->label('Estatus')
                    ->default(true)
                    ->required(),
            ]);

        return $form->schema([
            $formulario,
        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('department.sede.name')
                    ->searchable()
                    ->label('Sede')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Puesto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('supervisor.name')
                    ->label('Jefe Inmediato')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->searchable()
                    ->label('Departamento')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('evaluation_grades')
                    ->label('Tipo de 360')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
                    ->label('Orden Jerarquico')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Estatus')
                    ->boolean(),
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPositions::route('/'),
            'create' => Pages\CreatePosition::route('/create'),
            'edit' => Pages\EditPosition::route('/{record}/edit'),
        ];
    }
}
