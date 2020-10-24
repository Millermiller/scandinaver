<?php


namespace Scandinaver\Learn\Infrastructure;

use Illuminate\Support\ServiceProvider;

/**
 * Class LearnServiceProvider
 *
 * @package Scandinaver\Learn\Infrastructure
 */
class LearnServiceProvider extends ServiceProvider
{
    public function register()
    {
        /** COMMAND **/
        $this->app->bind(
            'AddBasicLevelHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\AddBasicLevelHandler'
        );

        $this->app->bind(
            'AddCardToAssetHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\AddCardToAssetHandler'
        );

        $this->app->bind(
            'AddWordAndTranslateHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\AddWordAndTranslateHandler'
        );

        $this->app->bind(
            'CreateAssetHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\CreateAssetHandler'
        );

        $this->app->bind(
            'CreateCardHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\CreateCardHandler'
        );

        $this->app->bind(
            'CreateFavouriteHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\CreateFavouriteHandler'
        );

        $this->app->bind(
            'CreateTranslateHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\CreateTranslateHandler'
        );

        $this->app->bind(
            'DeleteAssetHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\DeleteAssetHandler'
        );

        $this->app->bind(
            'DeleteCardFromAssetHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\DeleteCardFromAssetHandler'
        );

        $this->app->bind(
            'DeleteFavouriteHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\DeleteFavouriteHandler'
        );

        $this->app->bind(
            'EditTranslateHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\EditTranslateHandler'
        );

        $this->app->bind(
            'FillDictionaryHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\FillDictionaryHandler'
        );

        $this->app->bind(
            'GiveNextLevelHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\GiveNextLevelHandler'
        );

        $this->app->bind(
            'SaveTestResultHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\SaveTestResultHandler'
        );

        $this->app->bind(
            'SetTranslateForCardHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\SetTranslateForCardHandler'
        );

        $this->app->bind(
            'UpdateAssetHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\UpdateAssetHandler'
        );

        $this->app->bind(
            'UpdateCardHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\UpdateCardHandler'
        );

        $this->app->bind(
            'UploadAudioHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Command\UploadAudioHandler'
        );

        /** QUERY **/
        $this->app->bind(
            'AssetForUserByTypeHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\AssetForUserByTypeHandler'
        );

        $this->app->bind(
            'AssetsCountByLanguageHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\AssetsCountByLanguageHandler'
        );

        $this->app->bind(
            'AssetsCountHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\AssetsCountHandler'
        );

        $this->app->bind(
            'AssetsHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\AssetsHandler'
        );

        $this->app->bind(
            'AudioCountByLanguageHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\AudioCountByLanguageHandler'
        );

        $this->app->bind(
            'AudioCountHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\AudioCountHandler'
        );

        $this->app->bind(
            'CardsOfAssetHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\CardsOfAssetHandler'
        );

        $this->app->bind(
            'CreateCardHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\CreateCardHandler'
        );

        $this->app->bind(
            'FindAudioHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\FindAudioHandler'
        );

        $this->app->bind(
            'GetAssetsByTypeHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\GetAssetsByTypeHandler'
        );

        $this->app->bind(
            'GetExamplesForCardHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\GetExamplesForCardHandler'
        );

        $this->app->bind(
            'GetTranslatesByWordHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\GetTranslatesByWordHandler'
        );

        $this->app->bind(
            'GetUnusedSentencesHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\GetUnusedSentencesHandler'
        );

        $this->app->bind(
            'PersonalAssetsHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\PersonalAssetsHandler'
        );

        $this->app->bind(
            'TextsCountByLanguageHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\TextsCountByLanguageHandler'
        );

        $this->app->bind(
            'TextsCountHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\TextsCountHandler'
        );

        $this->app->bind(
            'WordsCountByLanguageHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\WordsCountByLanguageHandler'
        );

        $this->app->bind(
            'WordsCountHandlerInterface',
            'Scandinaver\Learn\Application\Handler\Query\WordsCountHandler'
        );
    }
}