<?php

namespace App\Filament\Resources\Exams\Tables;

use App\Enums\ExamStatus;
use App\Models\Exam;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ExamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (ExamStatus $state): string => match ($state) {
                        ExamStatus::Draft => 'Rascunho',
                        ExamStatus::Published => 'Publicado',
                        ExamStatus::Inactive => 'Inativo',
                    })
                    ->color(fn (ExamStatus $state): string => match ($state) {
                        ExamStatus::Draft => 'gray',
                        ExamStatus::Published => 'success',
                        ExamStatus::Inactive => 'warning',
                    }),

                TextColumn::make('questions_count')
                    ->label('Questões')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Rascunho',
                        'published' => 'Publicado',
                        'inactive' => 'Inativo',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('publish')
                    ->label('Publicar')
                    ->icon('heroicon-m-eye')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (Exam $record) => $record->update(['status' => ExamStatus::Published]))
                    ->hidden(fn (Exam $record): bool => $record->status === ExamStatus::Published)
                    ->authorize(fn (Exam $record): bool => $record->status !== ExamStatus::Published),
                Action::make('unpublish')
                    ->label('Despublicar')
                    ->icon('heroicon-m-eye-slash')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(fn (Exam $record) => $record->update(['status' => ExamStatus::Draft]))
                    ->visible(fn (Exam $record): bool => $record->status === ExamStatus::Published)
                    ->authorize(fn (Exam $record): bool => $record->status === ExamStatus::Published),
                Action::make('delete')
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn (Exam $record) => $record->delete()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
