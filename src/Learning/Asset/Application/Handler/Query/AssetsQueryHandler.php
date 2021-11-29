<?php


namespace Scandinaver\Learning\Asset\Application\Handler\Query;

use Exception;
use League\Fractal\Resource\Collection;
use Scandinaver\Learning\Asset\Domain\Service\AssetService;
use Scandinaver\Learning\Asset\UI\Query\AssetsQuery;
use Scandinaver\Learning\Asset\UI\Resource\AssetTransformer;
use Scandinaver\Core\Domain\AbstractHandler;
use Scandinaver\Core\Domain\Contract\BaseCommandInterface;

/**
 * Class AssetsQueryHandler
 *
 * @package Scandinaver\Learn\Application\Handler\Query
 */
class AssetsQueryHandler extends AbstractHandler
{

    public function __construct(private AssetService $assetService)
    {
        parent::__construct();
    }

    /**
     * @param  AssetsQuery  $query
     *
     * @throws Exception
     */
    public function handle(BaseCommandInterface $query): void
    {
        $assetDTOs = $this->assetService->getAssetsForApp($query->getLanguage(), $query->getUser());

        $this->resource = new Collection($assetDTOs, new AssetTransformer());
    }
}