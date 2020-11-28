<?php


namespace Scandinaver\Common\Infrastructure;


use Illuminate\Support\ServiceProvider;
use Scandinaver\Common\Domain\Contract\HashInterface;
use Scandinaver\Common\Domain\Contract\RedisInterface;

/**
 * Class CustomServiceProvider
 *
 * @package Scandinaver\Common\Infrastructure
 */
class CustomServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'EventBusInterface',
            'Scandinaver\Common\Infrastructure\Service\LaravelEventBus'
        );

        $this->app->bind(
            HashInterface::class,
            'Scandinaver\Common\Infrastructure\Service\LaravelHash'
        );

        $this->app->bind(
            RedisInterface::class,
            'Scandinaver\Common\Infrastructure\Service\LaravelRedis'
        );
    }
}