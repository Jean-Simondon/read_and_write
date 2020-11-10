<?php

namespace App\Entity;

use App\Repository\ChapitreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChapitreRepository::class)
 */
class Chapitre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=acte::class, inversedBy="chapitres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $acte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $introduction;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @ORM\OneToMany(targetEntity=Scene::class, mappedBy="chapitre", orphanRemoval=true)
     */
    private $scenes;

    public function __construct()
    {
        $this->scenes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActe(): ?acte
    {
        return $this->acte;
    }

    public function setActe(?acte $acte): self
    {
        $this->acte = $acte;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(?string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getPublish(): ?bool
    {
        return $this->publish;
    }

    public function setPublish(bool $publish): self
    {
        $this->publish = $publish;

        return $this;
    }

    /**
     * @return Collection|Scene[]
     */
    public function getScenes(): Collection
    {
        return $this->scenes;
    }

    public function addScene(Scene $scene): self
    {
        if (!$this->scenes->contains($scene)) {
            $this->scenes[] = $scene;
            $scene->setChapitre($this);
        }

        return $this;
    }

    public function removeScene(Scene $scene): self
    {
        if ($this->scenes->removeElement($scene)) {
            // set the owning side to null (unless already changed)
            if ($scene->getChapitre() === $this) {
                $scene->setChapitre(null);
            }
        }

        return $this;
    }
}
