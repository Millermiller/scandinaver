<?php


namespace Scandinaver\RBAC\UI\Command;

use Scandinaver\Core\Domain\Attribute\Handler;
use Scandinaver\Core\Domain\Contract\CommandInterface;
use Scandinaver\Core\Domain\DTO;
use Scandinaver\RBAC\Application\Handler\Command\DeletePermissionGroupCommandHandler;

/**
 * Class DeletePermissionGroupCommand
 *
 * @package Scandinaver\RBAC\UI\Command
 */
#[Handler(DeletePermissionGroupCommandHandler::class)]
class DeletePermissionGroupCommand implements CommandInterface
{

    public function __construct(private int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function buildDTO(): DTO
    {
        // TODO: Implement buildDTO() method.
    }
}