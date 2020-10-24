<?php


namespace Scandinaver\User\Infrastructure;

use Illuminate\Support\ServiceProvider;

/**
 * Class UserServiceProvider
 *
 * @package Scandinaver\User\Infrastructure
 */
class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        /** COMMAND **/
        $this->app->bind(
            'CreatePlanHandlerInterface',
            'Scandinaver\User\Application\Handler\Command\CreatePlanHandler'
        );

        $this->app->bind(
            'CreateUserHandlerInterface',
            'Scandinaver\User\Application\Handler\Command\CreateUserHandler'
        );

        $this->app->bind(
            'DeletePlanHandlerInterface',
            'Scandinaver\User\Application\Handler\Command\DeletePlanHandler'
        );

        $this->app->bind(
            'DeleteUserHandlerInterface',
            'Scandinaver\User\Application\Handler\Command\DeleteUserHandler'
        );

        $this->app->bind(
            'LoginHandlerInterface',
            'Scandinaver\User\Application\Handler\Command\LoginHandler'
        );

        $this->app->bind(
            'LogoutHandlerInterface',
            'Scandinaver\User\Application\Handler\Command\LogoutHandler'
        );

        $this->app->bind(
            'UpdatePlanHandlerInterface',
            'Scandinaver\User\Application\Handler\Command\UpdatePlanHandler'
        );

        $this->app->bind(
            'UpdateUserHandlerInterface',
            'Scandinaver\User\Application\Handler\Command\UpdateUserHandler'
        );

        /** QUERY **/
        $this->app->bind(
            'GetStateHandlerInterface',
            'Scandinaver\User\Application\Handler\Query\GetStateHandler'
        );

        $this->app->bind(
            'GetUserHandlerInterface',
            'Scandinaver\User\Application\Handler\Query\GetUserHandler'
        );

        $this->app->bind(
            'PlanHandlerInterface',
            'Scandinaver\User\Application\Handler\Query\PlanHandler'
        );

        $this->app->bind(
            'PlansHandlerInterface',
            'Scandinaver\User\Application\Handler\Query\PlansHandler'
        );

        $this->app->bind(
            'UserHandlerInterface',
            'Scandinaver\User\Application\Handler\Query\UserHandler'
        );

        $this->app->bind(
            'UserStateHandlerInterface',
            'Scandinaver\User\Application\Handler\Query\UserStateHandler'
        );

        $this->app->bind(
            'UsersHandlerInterface',
            'Scandinaver\User\Application\Handler\Query\UsersHandler'
        );
    }
}