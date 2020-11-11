<?php

namespace App\Entity;

use App\Repository\CellRepository;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Author;
use App\Entity\Manuscript;
use App\Entity\Act;
use App\Entity\Chapter;
use App\Entity\Scene;

/**
 * @ORM\Entity(repositoryClass=CellRepository::class)
 */
class Cell
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=scene::class, inversedBy="cells")
     * @ORM\JoinColumn(nullable=false)
     */
    private $scene;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text_content;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $audio_content;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScene(): ?scene
    {
        return $this->scene;
    }

    public function setScene(?scene $scene): self
    {
        $this->scene = $scene;

        return $this;
    }

    public function getTextContent(): ?string
    {
        return $this->text_content;
    }

    public function setTextContent(?string $text_content): self
    {
        $this->text_content = $text_content;

        return $this;
    }

    public function getAudioContent()
    {
        return $this->audio_content;
    }

    public function setAudioContent($audio_content): self
    {
        $this->audio_content = $audio_content;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }
}
