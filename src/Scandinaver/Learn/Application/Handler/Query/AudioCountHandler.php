<?php


namespace Scandinaver\Learn\Application\Handler\Query;

use Scandinaver\Learn\Domain\Contract\Query\AudioCountHandlerInterface;
use Scandinaver\Learn\Domain\Services\AudioService;
use Scandinaver\Learn\UI\Query\AudioCountQuery;

/**
 * Class AudioCountHandler
 *
 * @package Scandinaver\Learn\Application\Handler\Query
 */
class AudioCountHandler implements AudioCountHandlerInterface
{
    private AudioService $audioService;

    public function __construct(AudioService $audioService)
    {
        $this->audioService = $audioService;
    }

    /**
     * @param  AudioCountQuery  $query
     *
     * @return int
     */
    public function handle($query): int
    {
        return $this->audioService->count();
    }
}