<?php

namespace App\Filament\Resources\ExamCategories\Pages;

use App\Filament\Resources\ExamCategories\ExamCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExamCategory extends CreateRecord
{
    protected static string $resource = ExamCategoryResource::class;
}
