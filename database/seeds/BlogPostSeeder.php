<?php

use App\BlogPost;
use App\User;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nbrPosts = max((int) $this->command->ask('How many posts do you want to create ?', 50), 1);

        $users = User::all();

        factory(BlogPost::class, $nbrPosts)->make()->each(function ($post) use ($users)
        {
            $post->user_id = $users->random()->id;
            $post->save();
        });

        $this->command->info("$nbrPosts posts has been created");
    }
}
