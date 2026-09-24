<?php

namespace App\Filament\Resources\ExamThemeSuggestions\Pages;

use App\Filament\Resources\ExamThemeSuggestions\ExamThemeSuggestionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExamThemeSuggestions extends ListRecords
{
    protected static string $resource = ExamThemeSuggestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
