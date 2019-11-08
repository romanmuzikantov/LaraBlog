<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BlogPost;
use Faker\Generator as Faker;

$factory->define(BlogPost::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'content' => $faker->paragraphs(4, true)
    ];
});

$factory->state(BlogPost::class, 'title-test', function (Faker $faker)
{
    return [
        'title' => 'This is title test',
        'content' => 'This is content test'
    ];
});
