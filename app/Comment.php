<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['content', 'user_id', 'blog_post_id'];

    public function blogPost()
    {
        return $this->belongsTo('App\BlogPost');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeLatest(Builder $builder)
    {
        $builder->orderBy(Static::CREATED_AT, 'desc');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function (Comment $comment) {
            Cache::forget("blog-post-{$comment->blog_post_id}");
        });
    }
}
