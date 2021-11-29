<?php


namespace Scandinaver\Blog\Domain\Event;

use Scandinaver\Blog\Domain\Entity\Category;
use Scandinaver\Core\Domain\Contract\DomainEvent;

/**
 * Class CategoryCreated
 *
 * @package Scandinaver\Blog\Domain\Event
 *
 */
class CategoryCreated implements DomainEvent
{

    private Category $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }
}