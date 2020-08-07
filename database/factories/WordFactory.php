<?php

use Faker\Generator as Faker;
use LaravelDoctrine\ORM\Testing\Factory;
use Scandinaver\Learn\Domain\Model\Asset;
use Scandinaver\Learn\Domain\Model\Result;
use Scandinaver\Learn\Domain\Model\Word;
use Scandinaver\User\Domain\Model\User;

/** @var Factory $factory */
$factory->define(\Scandinaver\Learn\Domain\Model\Word::class, function (Faker $faker, array $attributes) {

    return [
        'word' => $faker->unique()->word(),
        'translate' => $faker->unique()->word(),
        'language' => $attributes['language']
    ];
});
