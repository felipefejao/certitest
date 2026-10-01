<?php

namespace App\Filament\Resources\ExamCategories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ExamCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug((string) $state)))
                    ->columnSpanFull(),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique('exam_categories', 'slug', ignoreRecord: true),

                Section::make('SEO')
                    ->columnSpanFull()
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Textarea::make('description')
                            ->label('Descrição (página pública)')
                            ->rows(4),

                        TextInput::make('meta_title')
                            ->label('Título meta')
                            ->maxLength(255),

                        Textarea::make('meta_description')
                            ->label('Meta descrição')
                            ->rows(2),
                    ]),
            ]);
    }
}
