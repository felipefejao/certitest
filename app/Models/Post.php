<?php

namespace App\Models;

use App\Enums\PostStatus;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'slug', 'excerpt', 'body', 'meta_title', 'meta_description', 'status', 'published_at'])]
class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => PostStatus::class,
            'published_at' => 'datetime',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('status', PostStatus::Published);
    }
}
