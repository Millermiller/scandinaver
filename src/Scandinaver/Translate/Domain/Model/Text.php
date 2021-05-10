<?php


namespace Scandinaver\Translate\Domain\Model;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Scandinaver\Common\Domain\Contract\UserInterface;
use Scandinaver\Common\Domain\Model\Language;
use Scandinaver\Shared\AggregateRoot;

/**
 * Class Text
 *
 * @package Scandinaver\Translate\Domain\Model
 */
class Text extends AggregateRoot
{
    private int $id;

    private int $level;

    private string $title;

    private ?string $description;

    private string $text;

    private string $translate;

    private bool $published;

    private DateTime $createdAt;

    private ?DateTime $updatedAt;

    private ?string $image = null;

    private $users;

    private Language $language;

    private Collection $extra;

    private Collection $words;

    private $textResults;

    private bool $active;

    private bool $available;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return Collection|UserInterface[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getLanguage(): Language
    {
        return $this->language;
    }

    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return Collection|Word[]
     */
    public function getWords(): Collection
    {
        return $this->words;
    }

    /**
     * @return Collection|TextExtra[]
     */
    public function getExtra(): Collection
    {
        return $this->extra;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): void
    {
        $this->published = $published;
    }

    public function getTextResults()
    {
        return $this->textResults;
    }

    public function onDelete()
    {
        // TODO: Implement delete() method.
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $value): void
    {
        $this->active = $value;
    }

    public function isAvailable(): bool
    {
        return $this->available;
    }

    public function setAvailable(bool $value): void
    {
        $this->available = $value;
    }
}
