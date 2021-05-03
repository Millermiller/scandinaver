<?php


namespace Scandinaver\Common\Domain\Service;

use Scandinaver\Common\Domain\DTO\LanguageDTO;
use Scandinaver\Common\Domain\Model\Language;

/**
 * Class LanguageFactory
 *
 * @package Scandinaver\Common\Domain\Service
 */
class LanguageFactory
{
    public static function fromDTO(LanguageDTO $languageDTO): Language
    {
        $language = new Language();

        $language->setLetter($languageDTO->getLetter());
        $language->setTitle($languageDTO->getTitle());

        return $language;
    }

    public static function toDTO(Language $language): LanguageDTO
    {
        $languageDTO = new LanguageDTO();

        $languageDTO->setId($language->getId());
        $languageDTO->setTitle($language->getTitle());
        $languageDTO->setLetter($language->getLetter());
        $languageDTO->setFlag(asset('img/'.$language->getFlag()));

        return $languageDTO;
    }
}