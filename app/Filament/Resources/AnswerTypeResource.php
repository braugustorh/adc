<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnswerTypeResource\Pages;
use App\Filament\Resources\AnswerTypeResource\RelationManagers;
use App\Models\AnswerType;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnswerTypeResource extends Resource
{
    protected static ?string $model = AnswerType::class;

    protected static ?string $navigationIcon = 'heroicon-s-calendar-days';
    protected static ?string $navigationLabel = 'Tipo de Respuestas';
    protected static ?string $navigationGroup = 'Configurar Evaluaciones';
    protected static ?int $navigationSort = 3;
    protected static ?string $label = 'Tipo de Respuestas';
    public static function canViewAny(): bool
    {
        return \auth()->user()->hasRole('Administrador');

    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Tipo de Rspuestas')
                    ->description('Agrega la información del Puesto para cada departamento')
                    ->icon('heroicon-s-calendar-days')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->required(),
                        Forms\Components\TextInput::make('description')
                            ->label('Descripción')
                            ->required(),
                        Forms\Components\Toggle::make('status')
                            ->label('Estatus')
                            ->default(true)
                            ->required(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->label('Nombre de la Campaña')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción de la Campaña')
                    ->wrap()
                    ->searchable(),
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
            'index' => Pages\ListAnswerTypes::route('/'),
            'create' => Pages\CreateAnswerType::route('/create'),
            'edit' => Pages\EditAnswerType::route('/{record}/edit'),
        ];
    }
}
