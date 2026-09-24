<?php

namespace App\Filament\Resources\ExamThemeSuggestions\Tables;

use App\Models\ExamThemeSuggestion;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ExamThemeSuggestionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('theme')
                    ->label('Tema')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),

                IconColumn::make('published')
                    ->label('Publicado')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Sugerido em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('published')
                    ->label('Publicado'),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('publish')
                    ->label('Publicar')
                    ->icon('heroicon-m-eye')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (ExamThemeSuggestion $record) => $record->update(['published' => true]))
                    ->hidden(fn (ExamThemeSuggestion $record): bool => $record->published)
                    ->authorize(fn (ExamThemeSuggestion $record): bool => ! $record->published),
                Action::make('unpublish')
                    ->label('Despublicar')
                    ->icon('heroicon-m-eye-slash')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(fn (ExamThemeSuggestion $record) => $record->update(['published' => false]))
                    ->visible(fn (ExamThemeSuggestion $record): bool => $record->published)
                    ->authorize(fn (ExamThemeSuggestion $record): bool => $record->published),
                Action::make('delete')
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn (ExamThemeSuggestion $record) => $record->delete()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
