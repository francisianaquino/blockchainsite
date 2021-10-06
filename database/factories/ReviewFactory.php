<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Review;
use App\User;
use App\Game;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'subject' => $faker->sentence(3),
        'description' => $faker->paragraph,
        'rating' => $faker->numberBetween(1, 5),
        'user_id' => function() {
            return User::all()->random();
        },
        'game_id' => function() {
            return Game::all()->random();
        }
    ];
});
