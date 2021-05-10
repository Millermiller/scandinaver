<?php


namespace App\Helpers;

use Scandinaver\Common\Domain\Contract\UserInterface;

/**
 * Class Auth
 *
 * @package App\Helpers
 */
class Auth
{

    public static function user(): ?UserInterface
    {
        return \Auth::user();
    }
}