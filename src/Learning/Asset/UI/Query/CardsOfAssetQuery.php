<?php


namespace Scandinaver\Learning\Asset\UI\Query;

use Scandinaver\Core\Domain\Attribute\Query;
use Scandinaver\Core\Domain\Contract\QueryInterface;
use Scandinaver\Core\Domain\Contract\UserInterface;
use Scandinaver\Learning\Asset\Application\Handler\Query\CardsOfAssetQueryHandler;

/**
 * Class CardsOfAssetQuery
 *
 * @package Scandinaver\Learn\UI\Query
 */
#[Query(CardsOfAssetQueryHandler::class)]
class CardsOfAssetQuery implements QueryInterface
{

    public function __construct(private UserInterface $user, private int $asset)
    {
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getAsset(): int
    {
        return $this->asset;
    }
}