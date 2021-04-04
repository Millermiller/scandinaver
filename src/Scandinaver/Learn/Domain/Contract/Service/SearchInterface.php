<?php


namespace Scandinaver\Learn\Domain\Contract\Service;

use Scandinaver\Common\Domain\Model\Language;

/**
 * Class SearchInterface
 *
 * @package Scandinaver\Learn\Domain\Contract\Service
 */
interface SearchInterface
{
    public function search(Language $language, string $query, bool $isSentence): array;
}