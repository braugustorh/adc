<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EvaluationsTypesResource\Pages;
use App\Filament\Resources\EvaluationsTypesResource\RelationManagers;
use App\Models\EvaluationsTypes;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EvaluationsTypesResource extends Resource
{
    protected static ?string $model = EvaluationsTypes::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Tipos de Evaluaciones';
    protected static ?string $navigationGroup = 'Configurar Evaluaciones';
    protected static ?string $label = 'Tipos de Evaluaciones';
    protected static ?int $navigationSort = 1;
    public static function canViewAny(): bool
    {
        return \auth()->user()->hasRole('Administrador');

    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Tipos de Evaluaciones')
                    ->description('Completa la información para crear un Tipo de Evaluación')
                    ->icon('heroicon-s-calendar-days')
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->maxLength(255),
                Forms\Components\Toggle::make('status')
                    ->label('Estatus')
                    ->default(true),
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                ->wrap()
                ->label('Descripción'),
                Tables\Columns\BooleanColumn::make('status')
                    ->label('Estatus')
                    ->sortable(),

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
            'index' => Pages\ListEvaluationsTypes::route('/'),
            'create' => Pages\CreateEvaluationsTypes::route('/create'),
            'edit' => Pages\EditEvaluationsTypes::route('/{record}/edit'),
        ];
    }
}
