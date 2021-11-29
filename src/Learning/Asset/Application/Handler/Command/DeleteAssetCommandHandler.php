<?php


namespace Scandinaver\Learning\Asset\Application\Handler\Command;

use Illuminate\Contracts\Container\BindingResolutionException;
use League\Fractal\Resource\NullResource;
use Scandinaver\Learning\Asset\Domain\Exception\AssetNotFoundException;
use Scandinaver\Learning\Asset\Domain\Service\{AssetService};
use Scandinaver\Learning\Asset\UI\Command\DeleteAssetCommand;
use Scandinaver\Core\Domain\AbstractHandler;
use Scandinaver\Core\Domain\Contract\CommandInterface;

/**
 * Class DeleteAssetCommandHandler
 *
 * @package Scandinaver\Learning\Asset\Application\Handler\Command
 */
class DeleteAssetCommandHandler extends AbstractHandler
{

    public function __construct(protected AssetService $assetService)
    {
        parent::__construct();
    }

    /**
     * @param  DeleteAssetCommand  $command
     *
     * @throws BindingResolutionException
     * @throws AssetNotFoundException
     */
    public function handle(CommandInterface $command): void
    {
        $this->assetService->delete($command->getAsset());

        $this->resource = new NullResource();
    }
}