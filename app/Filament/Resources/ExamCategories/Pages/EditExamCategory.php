<?php

namespace App\Filament\Resources\ExamCategories\Pages;

use App\Filament\Resources\ExamCategories\ExamCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditExamCategory extends EditRecord
{
    protected static string $resource = ExamCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
