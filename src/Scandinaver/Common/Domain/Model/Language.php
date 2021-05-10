<?php


namespace Scandinaver\Common\Domain\Model;

use LaravelDoctrine\ORM\Contracts\UrlRoutable;
use Scandinaver\Common\Domain\Event\LanguageCreated;
use Scandinaver\Common\Domain\Event\LanguageDeleted;
use Scandinaver\Shared\AggregateRoot;

/**
 * Class Language
 *
 * @package Scandinaver\Common\Domain\Model
 */
class Language extends AggregateRoot implements UrlRoutable
{
    private int $id;

    private string $letter;

    private string $title;

    private string $flag;

    public function __construct()
    {
        $this->pushEvent(new LanguageCreated($this));
    }

    public static function getRouteKeyName(): string
    {
        return 'name';
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getLetter(): string
    {
        return $this->letter;
    }

    public function setLetter(string $letter): void
    {
        $this->letter = $letter;
    }

    public function getFlag(): string
    {
        return $this->flag;
    }

    public function setFlag(string $flag): void
    {
        $this->flag = $flag;
    }

    public function onDelete()
    {
        $this->pushEvent(new LanguageDeleted($this));
    }
}
