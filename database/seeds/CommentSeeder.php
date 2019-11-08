<?php

use App\BlogPost;
use App\Comment;
use App\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nbrComments = max((int) $this->command->ask('How many comments do you want to create ?', 150), 1);

        $blogPosts = BlogPost::all();
        $users = User::all();

        factory(Comment::class, $nbrComments)->make()->each(function ($comment) use ($blogPosts, $users)
        {
            $comment->blog_post_id = $blogPosts->random()->id;
            $comment->user_id = $users->random()->id;
            $comment->save();
        });

        $this->command->info("$nbrComments comments has been created");
    }
}
