<?php

namespace App\Models;

use App\Enums\ExamStatus;
use Database\Factories\ExamFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['name', 'slug', 'description', 'exam_category_id', 'status', 'questions'])]
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

    /** @return BelongsTo<ExamCategory, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ExamCategory::class, 'exam_category_id');
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
