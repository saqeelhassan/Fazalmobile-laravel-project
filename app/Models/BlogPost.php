<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'meta_title', 'meta_description', 'excerpt', 'body',
        'image', 'category', 'author_name', 'status', 'is_featured',
        'views', 'created_by', 'published_at',
    ];

    protected $casts = [
        'is_featured'  => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (BlogPost $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if (empty($post->published_at)) {
                $post->published_at = now();
            }
        });
    }

    public static function categories(): array
    {
        return ['Smart Watches', 'Gaming', 'Airbuds', 'Cables', 'Projector', 'Charger', 'Cooling Fan', 'Buying Guides', 'News'];
    }
}
