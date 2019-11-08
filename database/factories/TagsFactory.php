<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tags;
use Faker\Generator as Faker;

$factory->define(Tags::class, function (Faker $faker) {
    return [
        
    ];
});

$factory->state(Tags::class, 'math', function (Faker $faker) {
    return [
        'name' => 'Math',
        'type' => 'success',
    ];
});

$factory->state(Tags::class, 'science', function (Faker $faker) {
    return [
        'name' => 'Science',
        'type' => 'success',
    ];
});

$factory->state(Tags::class, 'it', function (Faker $faker) {
    return [
        'name' => 'IT',
        'type' => 'success',
    ];
});

$factory->state(Tags::class, 'trashed', function (Faker $faker) {
    return [
        'name' => 'Trashed',
        'type' => 'danger',
    ];
});
