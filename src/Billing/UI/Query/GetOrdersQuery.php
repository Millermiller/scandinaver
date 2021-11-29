<?php


namespace Scandinaver\Billing\UI\Query;

use Scandinaver\Billing\Application\Handler\Query\GetOrdersQueryHandler;
use Scandinaver\Core\Domain\Attribute\Query;
use Scandinaver\Core\Domain\Contract\QueryInterface;

/**
 * Class GetOrdersQuery
 *
 * @package Scandinaver\Billing\UI\Query
 */
#[Query(GetOrdersQueryHandler::class)]
class GetOrdersQuery implements QueryInterface
{
    public function __construct()
    {

    }
}