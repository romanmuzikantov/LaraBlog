<?php

namespace App;

use App\Scopes\SoftDeletedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'user_id'];

    public function comments()
    {
        return $this->hasMany('App\Comment')->latest()->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tags');
    }

    public function scopeLatest(Builder $builder)
    {
        $builder->orderBy(Static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $builder)
    {
        $builder->withCount('comments')->has('comments', '>=', 2)->orderBy('comments_count', 'desc');
    }

    public static function boot()
    {
        static::addGlobalScope(new SoftDeletedScope);
        parent::boot();

        // static::addGlobalScope(new LatestScope);

        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
            $blogPost->tags()->syncWithoutDetaching([4]);
            Cache::forget('blog-post-all');
            Cache::forget("blog-post-{$blogPost->id}");
        });

        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
            $blogPost->tags()->detach(4);
            Cache::forget('blog-post-all');
            Cache::forget("blog-post-{$blogPost->id}");
        });

        static::creating(function (BlogPost $blogPost) {
            Cache::forget('blog-post-all');
        });

        static::updating(function (BlogPost $blogPost) {
            Cache::forget("blog-post-{$blogPost->id}");
            Cache::forget('blog-post-all');
        });
    }
}
