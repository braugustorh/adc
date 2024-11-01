<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PortfolioRelationManager extends RelationManager
{
    protected static string $relationship = 'portfolio';
    protected static ?string $title = 'Portafolio';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('acta_url')
                    ->label('Acta de nacimiento')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize('2048')
                    ->default(null),
                Forms\Components\FileUpload::make('curp_url')
                    ->label('CURP')

                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize('2048')
                    ->default(null),
                Forms\Components\FileUpload::make('rfc_url')
                    ->label('Comprobante de RFC')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize('2048')
                    ->helperText('Los documentos válidos son: Cédula de Identificación fiscal o Constancia de Situación Fiscal. En formato PDF.')
                    ->default(null),
                Forms\Components\FileUpload::make('ine_url')
                    ->label('Identificación Oficial Vigente')
                    ->helperText('Los documentos válidos son: Credencial para votar (INE), Pasaporte o Cédula Profesional.')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize('2048')
                    ->default(null),
                Forms\Components\FileUpload::make('comprobante_domicilio_url')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize('2048')
                    ->default(null),
                Forms\Components\FileUpload::make('comprobante_estudios_url')
                    ->label('Comprobante del último grado de estudios')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize('2048')
                    ->default(null),
                Forms\Components\FileUpload::make('carta_no_antecedentes_url')
                    ->label('Carta de no antecedentes penales')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize('2048')
                    ->default(null),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle('Portafolio de Documentos')
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
                    ->label('Penales')
                    ->icon(function ($record): string {
                        $url =$record->carta_no_antecedentes_url;
                        dd($url);
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
            ->headerActions([

                //Tables\Actions\CreateAction::make(),
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
