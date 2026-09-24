<?php

namespace App\Models;

use Database\Factories\ExamThemeSuggestionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['theme', 'email', 'published'])]
class ExamThemeSuggestion extends Model
{
    /** @use HasFactory<ExamThemeSuggestionFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}
