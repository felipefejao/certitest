<?php

namespace App\Filament\Resources\ExamCategories;

use App\Filament\Resources\ExamCategories\Pages\CreateExamCategory;
use App\Filament\Resources\ExamCategories\Pages\EditExamCategory;
use App\Filament\Resources\ExamCategories\Pages\ListExamCategories;
use App\Filament\Resources\ExamCategories\Schemas\ExamCategoryForm;
use App\Filament\Resources\ExamCategories\Tables\ExamCategoriesTable;
use App\Models\ExamCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExamCategoryResource extends Resource
{
    protected static ?string $model = ExamCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    public static function getNavigationLabel(): string
    {
        return 'Categorias';
    }

    public static function getModelLabel(): string
    {
        return 'categoria';
    }

    public static function getPluralModelLabel(): string
    {
        return 'categorias';
    }

    public static function form(Schema $schema): Schema
    {
        return ExamCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExamCategoriesTable::configure($table);
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
            'index' => ListExamCategories::route('/'),
            'create' => CreateExamCategory::route('/create'),
            'edit' => EditExamCategory::route('/{record}/edit'),
        ];
    }
}
