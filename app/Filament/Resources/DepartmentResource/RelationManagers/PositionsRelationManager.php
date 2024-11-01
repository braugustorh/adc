<?php

namespace App\Filament\Resources\DepartmentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PositionsRelationManager extends RelationManager
{
    protected static string $relationship = 'position';
    protected static ?string $title = 'Puestos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre del Puesto')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->label('Descripción del Puesto')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('order')
                    ->label('Orden Gerarquico del Puesto')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('status')
                    ->label('Estatus')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Nombre del Puesto'),
                Tables\Columns\TextColumn::make('description')
                ->label('Descripción del Puesto'),
                Tables\Columns\TextColumn::make('order')
                ->label('Orden Jerárquico del Puesto'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Agregar Puesto'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
