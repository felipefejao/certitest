<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('published_at')
                    ->label('Publicado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('published_at', 'desc')
            ->recordActions([
                EditAction::make(),
                Action::make('delete')
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn (Post $record) => $record->delete()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
