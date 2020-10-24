<?php


namespace Scandinaver\Learn\Application\Handler\Query;

use Scandinaver\Learn\Domain\Contract\Query\AssetsCountHandlerInterface;
use Scandinaver\Learn\Domain\Services\AssetService;
use Scandinaver\Learn\Domain\Services\AudioService;
use Scandinaver\Learn\UI\Query\AssetsCountQuery;

/**
 * Class AssetsCountHandler
 *
 * @package Scandinaver\Learn\Application\Handler\Query
 */
class AssetsCountHandler implements AssetsCountHandlerInterface
{
    private AssetService $assetService;

    public function __construct(AssetService $assetService)
    {
        $this->assetService = $assetService;
    }

    /**
     * @param  AssetsCountQuery  $query
     *
     * @return int
     */
    public function handle($query): int
    {
        return $this->assetService->count($query->getLanguage());
    }
}