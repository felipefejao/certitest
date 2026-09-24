<?php

namespace App\Filament\Resources\ExamThemeSuggestions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ExamThemeSuggestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('theme')
                    ->label('Tema')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Toggle::make('published')
                    ->label('Publicado'),
            ]);
    }
}
