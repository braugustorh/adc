<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompetenceResource\Pages;
use App\Filament\Resources\CompetenceResource\RelationManagers;
use App\Models\Competence;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Pages\CreateRecord;

class CompetenceResource extends Resource
{
    protected static ?string $model = Competence::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Competencias';
    protected static ?string $navigationGroup = 'Configurar Evaluaciones';
    protected static ?string $label = 'Competencias';
    protected static ?int $navigationSort = 2;

    protected function afterSave(): void
    {
        // Redirige a la página de listado del recurso después de guardar
        $this->redirect($this->getResource()::getUrl('index'));
    }
    public static function canViewAny(): bool
    {
        return \auth()->user()->hasRole('Administrador');

    }

    public static function form(Form $form): Form
    {
        $formCompetence = Section::make('Competencias')
            ->description('Completa la información de la Competencia')
            ->icon('heroicon-s-calendar-days')
            ->schema([
                Forms\Components\Select::make('evaluations_type_id')
                    ->label('Tipo de Evaluación')
                    ->relationship('evaluationType', 'name')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set) {
                        $set('competence_id', null);
                    }),
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->maxLength(255),
                Forms\Components\Select::make('level')
                    ->label('Nivel')
                    ->options([
                        '1' => 'Básico',
                        '2' => 'Intermedio',
                        '3' => 'Avanzado',
                    ])
                    ->required(),
                Forms\Components\Toggle::make('status')
                    ->label('Estatus')
                    ->default(false),
            ]);

        return $form
            ->schema([
                $formCompetence,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('evaluationType.name')
                    ->searchable()
                    ->label('Tipo de Evaluación')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Competencia')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->label('Descripción')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\BooleanColumn::make('status')
                    ->label('Estatus'),
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
            'index' => Pages\ListCompetences::route('/'),
            'create' => Pages\CreateCompetence::route('/create'),
            'edit' => Pages\EditCompetence::route('/{record}/edit'),
        ];
    }
}
