<?php

use Faker\Generator as Faker;

$factory->define(App\Helpers\Eloquent\Word::class, function (Faker $faker) {
    return [
        'word' => $faker->unique()->word,
        'transcription' => '[au:]',
        'audio' => '/files/audio/36b7148acc1b607c473a15a47fa17706.mp3',
        'sentence' => 0,
        'is_public' => 1,
        'language_id' => 1,
    ];
});