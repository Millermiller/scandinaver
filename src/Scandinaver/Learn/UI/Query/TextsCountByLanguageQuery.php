<?php


namespace Scandinaver\Learn\UI\Query;

use Scandinaver\Common\Domain\Model\Language;
use Scandinaver\Shared\Contract\Query;

/**
 * Class TextsCountByLanguageQuery
 *
 * @see     \Scandinaver\Learn\Application\Handler\Query\TextsCountByLanguageHandler
 * @package Scandinaver\Learn\UI\Query
 */
class TextsCountByLanguageQuery implements Query
{
    private Language $language;

    public function __construct(Language $language)
    {
        $this->language = $language;
    }

    public function getLanguage(): Language
    {
        return $this->language;
    }
}