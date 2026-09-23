<?php

namespace App\Filament\Resources\Exams\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ExamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique('exams', 'slug', ignoreRecord: true),

                Textarea::make('description')
                    ->label('Descrição')
                    ->rows(3)
                    ->columnSpanFull(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Rascunho',
                        'published' => 'Publicado',
                        'inactive' => 'Inativo',
                    ])
                    ->required()
                    ->default('draft')
                    ->native(false),

                Repeater::make('questions')
                    ->label('Questões')
                    ->addActionLabel('Adicionar questão')
                    ->reorderable()
                    ->collapsible()
                    ->columnSpanFull()
                    ->schema([
                        Hidden::make('id')
                            ->default(fn () => (string) Str::uuid()),

                        Textarea::make('question')
                            ->label('Pergunta')
                            ->required()
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('options.A')
                                    ->label('Opção A')
                                    ->required(),
                                TextInput::make('options.B')
                                    ->label('Opção B')
                                    ->required(),
                                TextInput::make('options.C')
                                    ->label('Opção C')
                                    ->required(),
                                TextInput::make('options.D')
                                    ->label('Opção D')
                                    ->required(),
                            ]),

                        Select::make('correct_answer')
                            ->label('Resposta correta')
                            ->options([
                                'A' => 'A',
                                'B' => 'B',
                                'C' => 'C',
                                'D' => 'D',
                            ])
                            ->required()
                            ->native(false),
                    ]),
            ]);
    }
}
