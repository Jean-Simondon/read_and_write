<?php

namespace App\Entity;

use App\Repository\CelluleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CelluleRepository::class)
 */
class Cellule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=scene::class, inversedBy="cellules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $scene;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contenu_texte;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $contenu_audio;

    /**
     * @ORM\Column(type="string", length=20, nullable=true CHECK(type = 'action' OR type = 'desciption' OR type = 'explication', OR type = 'dialogue'))
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

    public function getContenuTexte(): ?string
    {
        return $this->contenu_texte;
    }

    public function setContenuTexte(?string $contenu_texte): self
    {
        $this->contenu_texte = $contenu_texte;

        return $this;
    }

    public function getContenuAudio()
    {
        return $this->contenu_audio;
    }

    public function setContenuAudio($contenu_audio): self
    {
        $this->contenu_audio = $contenu_audio;

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
