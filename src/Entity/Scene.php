<?php

namespace App\Entity;

use App\Repository\SceneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SceneRepository::class)
 */
class Scene
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=chapitre::class, inversedBy="scenes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chapitre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @ORM\OneToMany(targetEntity=Cellule::class, mappedBy="scene")
     */
    private $cellules;

    public function __construct()
    {
        $this->cellules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChapitre(): ?chapitre
    {
        return $this->chapitre;
    }

    public function setChapitre(?chapitre $chapitre): self
    {
        $this->chapitre = $chapitre;

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

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return Collection|Cellule[]
     */
    public function getCellules(): Collection
    {
        return $this->cellules;
    }

    public function addCellule(Cellule $cellule): self
    {
        if (!$this->cellules->contains($cellule)) {
            $this->cellules[] = $cellule;
            $cellule->setScene($this);
        }

        return $this;
    }

    public function removeCellule(Cellule $cellule): self
    {
        if ($this->cellules->removeElement($cellule)) {
            // set the owning side to null (unless already changed)
            if ($cellule->getScene() === $this) {
                $cellule->setScene(null);
            }
        }

        return $this;
    }
}
