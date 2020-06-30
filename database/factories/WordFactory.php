<?php

use Faker\Generator as Faker;
use LaravelDoctrine\ORM\Testing\Factory;
use Scandinaver\Learn\Domain\Asset;
use Scandinaver\Learn\Domain\Result;
use Scandinaver\Learn\Domain\Word;
use Scandinaver\User\Domain\User;

/** @var Factory $factory */
$factory->define(\Scandinaver\Learn\Domain\Word::class, function (Faker $faker, array $attributes) {

    return [
        'word' => $faker->unique()->word(),
        'translate' => $faker->unique()->word(),
        'language' => $attributes['language']
    ];
});
