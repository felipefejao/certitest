<?php

namespace App\Filament\Resources\ExamThemeSuggestions\Pages;

use App\Filament\Resources\ExamThemeSuggestions\ExamThemeSuggestionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditExamThemeSuggestion extends EditRecord
{
    protected static string $resource = ExamThemeSuggestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
