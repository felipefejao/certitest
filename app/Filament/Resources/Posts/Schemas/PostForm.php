<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\PostStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug((string) $state)))
                    ->columnSpanFull(),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique('posts', 'slug', ignoreRecord: true),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        PostStatus::Draft->value => 'Rascunho',
                        PostStatus::Published->value => 'Publicado',
                    ])
                    ->default(PostStatus::Draft->value)
                    ->required(),

                DateTimePicker::make('published_at')
                    ->label('Publicado em'),

                Textarea::make('excerpt')
                    ->label('Resumo')
                    ->rows(3)
                    ->columnSpanFull(),

                MarkdownEditor::make('body')
                    ->label('Conteúdo')
                    ->required()
                    ->columnSpanFull(),

                Section::make('SEO')
                    ->columnSpanFull()
                    ->collapsible()
                    ->collapsed()
                    ->schema([
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
