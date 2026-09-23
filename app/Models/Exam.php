<?php

namespace App\Models;

use App\Enums\ExamStatus;
use Database\Factories\ExamFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'slug', 'description', 'status', 'questions'])]
class Exam extends Model
{
    /** @use HasFactory<ExamFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'status' => ExamStatus::class,
            'questions' => 'array',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('status', ExamStatus::Published);
    }

    public function getQuestionsCountAttribute(): int
    {
        return count($this->questions ?? []);
    }
}
