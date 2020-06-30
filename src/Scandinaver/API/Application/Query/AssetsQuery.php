<?php


namespace Scandinaver\API\Application\Query;

use Illuminate\Contracts\Auth\Authenticatable;
use Scandinaver\Common\Domain\Language;
use Scandinaver\Shared\Contracts\Query;
use Scandinaver\User\Domain\User;

/**
 * Class AssetsQuery
 *
 * @package Scandinaver\API\Application\Query
 * @see     \Scandinaver\API\Application\Handlers\AssetsHandler
 */
class AssetsQuery implements Query
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $language;

    /**
     * AssetsQuery constructor.
     *
     * @param Authenticatable $user
     * @param Language        $language
     */
    public function __construct(Authenticatable $user, Language $language)
    {
        $this->user     = $user;
        $this->language = $language;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }
}