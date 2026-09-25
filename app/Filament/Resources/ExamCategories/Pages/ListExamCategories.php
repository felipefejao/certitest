<?php

namespace App\Filament\Resources\ExamCategories\Pages;

use App\Filament\Resources\ExamCategories\ExamCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExamCategories extends ListRecords
{
    protected static string $resource = ExamCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
