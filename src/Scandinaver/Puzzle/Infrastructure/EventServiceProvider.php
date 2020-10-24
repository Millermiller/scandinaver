<?php


namespace Scandinaver\Puzzle\Infrastructure;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider
 *
 * @package Scandinaver\Puzzle\Infrastructure
 */
class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Scandinaver\Puzzle\Domain\Events\PuzzleCreated' => [
            'Scandinaver\Puzzle\Domain\Events\Listeners\PuzzleCreatedListener',
        ],
        'Scandinaver\Puzzle\Domain\Events\TestCreated' => [
            'Scandinaver\Puzzle\Domain\Events\Listeners\TestCreatedListener',
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}