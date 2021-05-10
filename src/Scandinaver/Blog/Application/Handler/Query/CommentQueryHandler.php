<?php


namespace Scandinaver\Blog\Application\Handler\Query;

use League\Fractal\Resource\Item;
use Scandinaver\Blog\Domain\Exception\CommentNotFoundException;
use Scandinaver\Blog\Domain\Service\CommentService;
use Scandinaver\Blog\UI\Query\CommentQuery;
use Scandinaver\Blog\UI\Resources\CommentTransformer;
use Scandinaver\Shared\AbstractHandler;
use Scandinaver\Shared\Contract\BaseCommandInterface;

/**
 * Class CommentQueryHandler
 *
 * @package Scandinaver\Blog\Application\Handler\Query
 */
class CommentQueryHandler extends AbstractHandler
{

    private CommentService $service;

    public function __construct(CommentService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * @param  CommentQuery|BaseCommandInterface  $query
     *
     * @throws CommentNotFoundException
     */
    public function handle(BaseCommandInterface $query): void
    {
        $comment = $this->service->one($query->getId());

        $this->resource = new Item($comment, new CommentTransformer());
    }
} 