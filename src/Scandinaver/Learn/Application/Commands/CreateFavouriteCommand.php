<?php


namespace Scandinaver\Learn\Application\Commands;

use App\Entities\User;
use Scandinaver\Learn\Domain\{Translate, Word};
use Scandinaver\Shared\Command;

/**
 * Class CreateFavouriteCommand
 * @package Scandinaver\Learn\Application\Commands
 */
class CreateFavouriteCommand implements Command
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Word
     */
    private $word;

    /**
     * @var Translate
     */
    private $translate;

    /**
     * CreateFavouriteCommand constructor.
     * @param User $user
     * @param Word $word
     * @param Translate $translate
     */
    public function __construct(User $user, Word $word, Translate $translate)
    {
        $this->user = $user;
        $this->word = $word;
        $this->translate = $translate;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Word
     */
    public function getWord(): Word
    {
        return $this->word;
    }

    /**
     * @return Translate
     */
    public function getTranslate(): Translate
    {
        return $this->translate;
    }
}