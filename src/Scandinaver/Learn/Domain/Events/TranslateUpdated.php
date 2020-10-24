<?php


namespace Scandinaver\Learn\Domain\Events;


use Scandinaver\Learn\Domain\Model\Translate;
use Scandinaver\Shared\DomainEvent;

class TranslateUpdated implements DomainEvent
{

    private Translate $translate;

    private string $value;

    public function __construct(Translate $translate, string $value)
    {
        $this->translate = $translate;
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getTranslate(): Translate
    {
        return $this->translate;
    }
}