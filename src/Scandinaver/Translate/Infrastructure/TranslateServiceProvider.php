<?php


namespace Scandinaver\Translate\Infrastructure;

use Illuminate\Support\ServiceProvider;

/**
 * Class TranslateServiceProvider
 *
 * @package Scandinaver\Translate\Infrastructure
 */
class TranslateServiceProvider extends ServiceProvider
{
    public function register()
    {
        /** COMMAND **/
        $this->app->bind(
            'CompleteTextHandlerInterface',
            'Scandinaver\Translate\Application\Handler\Command\CompleteTextHandler'
        );

        $this->app->bind(
            'CreateSynonymHandlerInterface',
            'Scandinaver\Translate\Application\Handler\Command\CreateSynonymHandler'
        );

        $this->app->bind(
            'CreateTextHandlerInterface',
            'Scandinaver\Translate\Application\Handler\Command\CreateTextHandler'
        );

        $this->app->bind(
            'CreateTextExtraHandlerInterface',
            'Scandinaver\Translate\Application\Handler\Command\CreateTextExtraHandler'
        );

        $this->app->bind(
            'DeleteSynonymHandlerInterface',
            'Scandinaver\Translate\Application\Handler\Command\DeleteSynonymHandler'
        );

        $this->app->bind(
            'DeleteTextHandlerInterface',
            'Scandinaver\Translate\Application\Handler\Command\DeleteTextHandler'
        );

        $this->app->bind(
            'PublishTextHandlerInterface',
            'Scandinaver\Translate\Application\Handler\Command\PublishTextHandler'
        );

        $this->app->bind(
            'UnpublishTextHandlerInterface',
            'Scandinaver\Translate\Application\Handler\Command\UnpublishTextHandler'
        );

        $this->app->bind(
            'UpdateDescriptionHandlerInterface',
            'Scandinaver\Translate\Application\Handler\Command\UpdateDescriptionHandler'
        );

        /** QUERY **/
        $this->app->bind(
            'GetSynonymsHandlerInterface',
            'Scandinaver\Translate\Application\Handler\Query\GetSynonymsHandler'
        );

        $this->app->bind(
            'GetTextHandlerInterface',
            'Scandinaver\Translate\Application\Handler\Query\GetTextHandler'
        );

        $this->app->bind(
            'GetTextsHandlerInterface',
            'Scandinaver\Translate\Application\Handler\Query\GetTextsHandler'
        );
    }
}