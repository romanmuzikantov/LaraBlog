<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Http\Requests\StorePostRequest;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'edit', 'store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Cache::remember('blog-post-all', now()->addHour(), function () {
            return BlogPost::latest()->withCount(['comments' => function ($builder) {
                $builder->withTrashed();
            }])->with(['user', 'tags'])->get();
        });

        return view('post.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $validateData = $request->validated();
        $validateData['user_id'] = $request->user()->id;

        $newPost = BlogPost::create($validateData);

        $request->session()->flash('status', 'Blog post has been created!');

        return redirect()->route('post.show', ['post' => $newPost->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Cache::remember("blog-post-{$id}", now()->addHour(), function() use($id) {
            return BlogPost::with([
                'comments.user',
                'user',
                'tags'])
                ->findOrFail($id);
        });

        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $usersKey = "blog-post-{$id}-users";

        $users = Cache::get($usersKey, []);
        $usersUpdate = [];
        $diff = 0;
        $now = now();

        // dd($users, $sessionId);

        foreach($users as $session => $lastVisit)
        {
            if($session !== $sessionId)
            {
                if(now()->diffInMinutes($lastVisit) >= 1)
                {
                    $diff--;
                }
                else
                {
                    $usersUpdate[$session] = $lastVisit;
                }
            }
        }

        if(!array_key_exists($sessionId, $users))
        {
            $diff++;
        }
        $usersUpdate[$sessionId] = $now;
        Cache::forever($usersKey, $usersUpdate);
        Cache::increment($counterKey, $diff);

        return view('post.show', [
            'post' => $post,
            'counterKey' => $counterKey,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize($post);

        return view('post.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePostRequest $request, $id)
    {
        $validatedData = $request->validated();

        $updatedPost = BlogPost::find($id);

        $this->authorize($updatedPost);

        $updatedPost->fill($validatedData);
        $updatedPost->save();

        $request->session()->flash('status', 'Blog post was updated !');

        return redirect()->route('post.show', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize($post);

        $post->delete();

        $request->session()->flash('status', 'Post was deleted!');

        return redirect()->route('post.index');
    }

    public function restore(Request $request, $blogPostId)
    {
        $post = BlogPost::findOrFail($blogPostId);

        $this->authorize($post);

        $post->restore();

        $request->session()->flash('status', 'Post was restored!');

        return redirect()->route('post.show', ['id' => $blogPostId]);
    }
}
