<?php

namespace App\Filament\Resources\Attempts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AttemptsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Candidato')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('exam.name')
                    ->label('Prova')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('total_questions')
                    ->label('Questões')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('correct_answers')
                    ->label('Acertos')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('wrong_answers')
                    ->label('Erros')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('percentage')
                    ->label('Aproveitamento')
                    ->suffix('%')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),

                TextColumn::make('finished_at')
                    ->label('Finalizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
