<?php


namespace Scandinaver\Text\Domain;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * TextExtras
 *
 * @ORM\Table(name="text_extras", indexes={@ORM\Index(name="text_id", columns={"text_id", "orig", "extra"}), @ORM\Index(name="IDX_3317FC22698D3548", columns={"text_id"})})
 * @ORM\Entity
 */
class TextExtra implements JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="orig", type="string", length=255, nullable=false)
     */
    private $orig;

    /**
     * @var string
     *
     * @ORM\Column(name="extra", type="string", length=255, nullable=false)
     */
    private $extra;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var Text
     *
     * @ORM\ManyToOne(targetEntity="Text", inversedBy="extra")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="text_id", referencedColumnName="id")
     * })
     */
    private $text;


    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
       return [
           'id' => $this->id,
           'orig' => $this->orig,
           'extra' => $this->extra,
       ];
    }
}
