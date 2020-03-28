<?php


namespace Scandinaver\Learn\Application\Commands;

use Scandinaver\Common\Domain\Language;
use Scandinaver\User\Domain\User;
use Scandinaver\Shared\Contracts\Command;

/**
 * Class CreateAssetCommand
 * @package Scandinaver\Learn\Application\Commands
 */
class CreateAssetCommand implements Command
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var string
     */
    private $title;
    
    /**
     * @var Language
     */
    private $language;
    
    /**
     * CreateAssetCommand constructor.
     *
     * @param Language $language
     * @param User     $user
     * @param string   $title
     */
    public function __construct(Language $language, User $user, string $title)
    {
        $this->language = $language;
        $this->user = $user;
        $this->title = $title;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
    
    /**
     * @return Language
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }
}