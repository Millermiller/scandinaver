<?php


namespace Scandinaver\Shared;


use Scandinaver\Shared\Contract\ValueObjectInterface;

/**
 * Class ValueObject
 *
 * @package Scandinaver\Shared
 */
class StringValueObject implements ValueObjectInterface
{

    protected string $value;

    public function isNull(): bool
    {
        return $this->value === null;
    }

    public function isSame(ValueObject $object): bool
    {
        return $this->toNative() === $object->toNative();
    }

    public function fromNative($native)
    {
        $this->value = $native;
    }

    public function toNative()
    {
        return $this->value;
    }

}