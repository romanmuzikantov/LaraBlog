<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Cache::forget('blog-post-all');
        Cache::forget('blog-post-most-commented');
        Cache::forget('user-most-active');

        $this->call([
            UserSeeder::class,
            BlogPostSeeder::class,
            CommentSeeder::class,
            TagsSeeder::class,
        ]);
    }
}
