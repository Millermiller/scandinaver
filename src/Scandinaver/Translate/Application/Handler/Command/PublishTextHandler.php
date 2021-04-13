<?php


namespace Scandinaver\Translate\Application\Handler\Command;

use Scandinaver\Shared\AbstractHandler;
use Scandinaver\Shared\Contract\Command;
use Scandinaver\Translate\Domain\Contract\Command\PublishTextHandlerInterface;
use Scandinaver\Translate\UI\Command\PublishTextCommand;

/**
 * Class PublishTextHandler
 *
 * @package Scandinaver\Translate\Application\Handler\Command
 */
class PublishTextHandler extends AbstractHandler implements PublishTextHandlerInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param  PublishTextCommand|Command  $command
     */
    public function handle($command): void
    {
        // TODO: Implement handle() method.
    }
} 