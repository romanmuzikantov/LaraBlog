<?php

use App\BlogPost;
use App\Tags;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Tags::class)->states('math')->create();
        factory(Tags::class)->states('science')->create();
        factory(Tags::class)->states('it')->create();
        factory(Tags::class)->states('trashed')->create();

        $tags = Tags::where('name', '!=', 'trashed')->get();

        $posts = BlogPost::all();

        $posts->map(function ($post) use ($tags) {
            $rdm = rand(1, 3);
            for ($i=0; $i < $rdm; $i++) { 
                $post->tags()->syncWithoutDetaching($tags->random());
            }
        });
    }
}
