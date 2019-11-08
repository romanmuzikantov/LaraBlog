<?php

namespace App\Http\Controllers;

use App\Tags;
use Illuminate\Http\Request;

class PostTagController extends Controller
{
    public function index($tagId)
    {
        $tag = Tags::with(['blogPosts' => function ($builder) {
            $builder->with(['user', 'tags'])->withCount('comments');
        }])->findOrFail($tagId);

        return view('post.index', 
            [
                'posts' => $tag->blogPosts,
            ]);
    }
}
