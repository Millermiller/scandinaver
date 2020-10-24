<?php


namespace Scandinaver\Shared;

/**
 * Class AggregateRoot
 *
 * @package Scandinaver\Shared
 */
abstract class AggregateRoot
{
    private array $domainEvents = [];

    abstract public function getId(): int;

    abstract public function toDTO(): DTO;

    final public function pullEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function pushEvent(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }

    abstract public function delete();
}