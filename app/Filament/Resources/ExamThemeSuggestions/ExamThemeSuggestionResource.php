<?php

namespace App\Filament\Resources\ExamThemeSuggestions;

use App\Filament\Resources\ExamThemeSuggestions\Pages\CreateExamThemeSuggestion;
use App\Filament\Resources\ExamThemeSuggestions\Pages\EditExamThemeSuggestion;
use App\Filament\Resources\ExamThemeSuggestions\Pages\ListExamThemeSuggestions;
use App\Filament\Resources\ExamThemeSuggestions\Schemas\ExamThemeSuggestionForm;
use App\Filament\Resources\ExamThemeSuggestions\Tables\ExamThemeSuggestionsTable;
use App\Models\ExamThemeSuggestion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExamThemeSuggestionResource extends Resource
{
    protected static ?string $model = ExamThemeSuggestion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLightBulb;

    public static function getNavigationLabel(): string
    {
        return 'Temas sugeridos';
    }

    public static function getModelLabel(): string
    {
        return 'sugestão de tema';
    }

    public static function getPluralModelLabel(): string
    {
        return 'sugestões de tema';
    }

    public static function form(Schema $schema): Schema
    {
        return ExamThemeSuggestionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExamThemeSuggestionsTable::configure($table);
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
            'index' => ListExamThemeSuggestions::route('/'),
            'create' => CreateExamThemeSuggestion::route('/create'),
            'edit' => EditExamThemeSuggestion::route('/{record}/edit'),
        ];
    }
}
