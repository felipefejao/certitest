<?php

namespace App\Models;

use Database\Factories\ExamCategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug'])]
class ExamCategory extends Model
{
    /** @use HasFactory<ExamCategoryFactory> */
    use HasFactory;

    /** @return HasMany<Exam, $this> */
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}
