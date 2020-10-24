<?php


namespace Scandinaver\Translate\Domain;

use Scandinaver\Common\Infrastructure\Container;
use Scandinaver\Translate\Domain\Contract\Repository\TextRepositoryInterface;
use Scandinaver\Translate\Domain\Exception\TextNotFoundException;
use Scandinaver\Translate\Domain\Model\Text;

/**
 * Trait TextTrait
 *
 * @package Scandinaver\Translate\Domain
 */
trait TextTrait
{
    private function getText(int $id): Text
    {
        /** @var  TextRepositoryInterface $repository */
        $repository = Container::getInstance()->get(TextRepositoryInterface::class);

        /** @var Text $text */
        $text = $repository->find($id);

        if ($text === null) {
            throw new TextNotFoundException();
        }

        return $text;
    }
}