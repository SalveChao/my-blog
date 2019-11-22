<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'user_id'=>$faker->numberBetween(1,5),
        'content' => $faker->sentence(4),
    ];
});
