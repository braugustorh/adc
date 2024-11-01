<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers;
use App\Models\Question;
use App\Models\Competence;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\TextInput;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Reactivos';
    protected static ?string $navigationGroup = 'Configurar Evaluaciones';
    protected static ?int $navigationSort = 4;
    protected static ?string $label = 'Reactivos';
    public static function canViewAny(): bool
    {
        return \auth()->user()->hasRole('Administrador');

    }

    public static function form(Form $form): Form
    {
        $formQuestion= Section::make('Reactivos')
            ->description('Completa la información del Reactivo selecciona el tipo de reactivo, la competencia,
            el nivel de dificultad y la evaluación a la que pertenece')
            ->icon('heroicon-s-calendar-days')
            ->schema([
                Forms\Components\RichEditor::make('question')
                    ->label('Pregunta')
                    ->required()
                    ->maxLength(65535) // El máximo de caracteres que puedes almacenar en un campo tipo TEXT en MySQL
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike', 'link', 'bulletList', 'orderedList', 'blockquote', 'codeBlock', 'undo',
                        'redo', 'image', 'table', 'horizontalRule', 'removeFormat', 'copyFormat', 'alignment', 'paste'
                    ]),
                Forms\Components\Textarea::make('comment')
                    ->label('Comentario')
                    ->maxLength(255),

                Forms\Components\Toggle::make('status')
                    ->label('Active')
                    ->default(true),

                Forms\Components\Select::make('evaluations_type_id')
                    ->label('Tipo de Evaluación')
                    ->relationship('evaluationType', 'name')
                    ->required()
                    ->reactive()  // Permite que el campo reaccione a cambios
                    ->afterStateUpdated(function (callable $set) {
                        $set('competence_id', null); // Resetea el campo de competencia cuando se selecciona otro tipo de evaluación
                    }),

                Forms\Components\Select::make('competence_id')
                    ->label('Competence')
                    ->required()
                    ->options(function (callable $get) {
                        $evaluationTypeId = $get('evaluations_type_id');
                        if ($evaluationTypeId) {
                            return Competence::where('evaluations_type_id', $evaluationTypeId)
                                ->pluck('name', 'id');
                        }

                        return Competence::all()->pluck('name', 'id'); // Opcional: mostrar todas las competencias si no se ha seleccionado un tipo de evaluación
                    }),


                Forms\Components\Select::make('evaluationType')
                    ->label('Tipo de Respuesta')
                    ->relationship('answerType', 'name')
                    ->required(),
            ]);
        return $form
            ->schema([
                $formQuestion,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('evaluationType.name')
                    ->searchable()
                    ->sortable()
                    ->label('Evaluación'),
                Tables\Columns\TextColumn::make('competence.name')
                    ->searchable()
                    ->sortable()
                    ->label('Competencia'),
                Tables\Columns\TextColumn::make('question')
                ->wrap()
                    ->searchable()
                    ->label('Pregunta'),
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
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
