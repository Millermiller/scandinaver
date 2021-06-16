<?php


namespace Scandinaver\Learn\Domain\Contract\Repository;

use Scandinaver\Common\Domain\Entity\Language;
use Scandinaver\Learn\Domain\Entity\Asset;
use Scandinaver\Shared\Contract\BaseRepositoryInterface;

/**
 * Interface AssetRepositoryInterface
 *
 * @package Scandinaver\Learn\Domain\Contract\Repository
 */
interface AssetRepositoryInterface extends BaseRepositoryInterface
{
    public function getByLanguage(Language $language): array;

    public function getPublicAssets(Language $language): array;

    public function getCountByLanguage(Language $language): int;

    public function getFirstAsset(Language $language, int $type): Asset;
}