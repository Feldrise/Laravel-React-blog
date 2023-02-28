<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'published',
        'category_id',
        'user_id',
    ];
}
