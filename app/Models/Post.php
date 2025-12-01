<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    // Allow mass assignment for common post fields
    protected $fillable = [
        'posts_types_id', 
        'title',
        'content',
        'excerpt', 
        'template', 
        'is_highlighted',
        'comments_enabled', 
        'views_count', 
        'published_at', 
        'users_id', 
        'posts_status_id',
        'media_id', 
        'categories_id', 
        'parent_id', 
        'tags',
    ];
}
