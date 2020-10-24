<?php


namespace Scandinaver\Puzzle\Infrastructure;

use Illuminate\Support\ServiceProvider;

/**
 * Class PuzzleServiceProvider
 *
 * @package Scandinaver\Puzzle\Infrastructure
 */
class PuzzleServiceProvider extends ServiceProvider
{
    public function register()
    {
        /** COMMAND **/
        $this->app->bind(
            'CreatePuzzleHandlerInterface',
            'Scandinaver\Puzzle\Application\Handler\Command\CreatePuzzleHandler'
        );

        $this->app->bind(
            'DeletePuzzleHandlerInterface',
            'Scandinaver\Puzzle\Application\Handler\Command\DeletePuzzleHandler'
        );

        $this->app->bind(
            'PuzzleCompleteHandlerInterface',
            'Scandinaver\Puzzle\Application\Handler\Command\PuzzleCompleteHandler'
        );

        /** QUERY **/
        $this->app->bind(
            'PuzzleHandlerInterface',
            'Scandinaver\Puzzle\Application\Handler\Query\PuzzleHandler'
        );

        $this->app->bind(
            'PuzzlesHandlerInterface',
            'Scandinaver\Puzzle\Application\Handler\Query\PuzzlesHandler'
        );

        $this->app->bind(
            'UserPuzzlesHandlerInterface',
            'Scandinaver\Puzzle\Application\Handler\Query\UserPuzzlesHandler'
        );
    }
}