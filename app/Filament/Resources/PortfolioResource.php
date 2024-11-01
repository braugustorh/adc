<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioResource\Pages;
use App\Filament\Resources\PortfolioResource\RelationManagers;
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
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';
    protected static ?string $navigationGroup = 'Colaboradores';
    protected static ?string $navigationLabel = 'Portafolio';
    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return \auth()->user()->hasRole('Administrador');

    }
    public static function canCreate(): bool
    {
        return \auth()->user()->hasRole('Administrador');
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
                                ->get()
                                ->mapWithKeys(fn (User $user): array => [$user->id => $user->name.' '.$user->first_name .' '.$user->last_name]);
                        }else{
                            $user= User::query()
                                ->doesntHave('portfolio')
                                ->with('portfolio') // Incluye la relación 'portfolio' en la consulta
                                ->get()
                                ->mapWithKeys(fn (User $user): array => [
                                    $user->id => $user->name.' '.$user->first_name.' '.$user->last_name
                                ]);
                        }
                            return $user;
                        })
                    ->required(),
                Forms\Components\FileUpload::make('acta_url')
                    ->label('Acta de nacimiento')
                    ->downloadable('true')
                    ->previewable('true')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize('2048')
                    ->default(null),
                Forms\Components\FileUpload::make('curp_url')
                    ->label('CURP')
                    ->downloadable('true')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize('2048')
                    ->default(null),
                Forms\Components\FileUpload::make('rfc_url')
                    ->label('Comprobante de RFC')
                    ->downloadable('true')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize('2048')
                    ->helperText('Los documentos válidos son: Cédula de Identificación fiscal o Constancia de Situación Fiscal. En formato PDF.')
                    ->default(null),
                Forms\Components\FileUpload::make('ine_url')
                    ->label('Identificación Oficial Vigente')
                    ->downloadable('true')
                    ->helperText('Los documentos válidos son: Credencial para votar (INE), Pasaporte o Cédula Profesional.')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize('2048')
                    ->default(null),
                Forms\Components\FileUpload::make('comprobante_domicilio_url')
                    ->label('Comprobante de domicilio')
                    ->downloadable('true')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize('2048')
                    ->default(null),
                Forms\Components\FileUpload::make('comprobante_estudios_url')
                    ->label('Comprobante del último grado de estudios')
                    ->downloadable('true')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize('2048')
                    ->default(null),
                Forms\Components\FileUpload::make('carta_no_antecedentes_url')
                    ->downloadable('true')
                    ->label('Carta de no antecedentes penales')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize('2048')
                    ->default(null),
            ]);
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
            'index' => Pages\ListPortfolios::route('/'),
            'create' => Pages\CreatePortfolio::route('/create'),
            'edit' => Pages\EditPortfolio::route('/{record}/edit'),
        ];
    }
}
