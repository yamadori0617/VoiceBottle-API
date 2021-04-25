<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(Post::class, function (Faker $faker) {
    return [
        'audio_path' => "../Audio/hoge_20210423_222416.gp3",
        'delivered' => false,
    ];
});
