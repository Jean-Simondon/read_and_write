<?php

namespace App\Entity;

use App\Repository\ManuscritRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ManuscritRepository::class)
 */
class Manuscrit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resume;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $genre;

    /**
     * @ORM\ManyToOne(targetEntity=auteur::class, inversedBy="manuscrits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auteur;

    /**
     * @ORM\OneToMany(targetEntity=Acte::class, mappedBy="manuscrit")
     */
    private $actes;

    public function __construct()
    {
        $this->actes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getAuteur(): ?auteur
    {
        return $this->auteur;
    }

    public function setAuteur(?auteur $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * @return Collection|Acte[]
     */
    public function getActes(): Collection
    {
        return $this->actes;
    }

    public function addActe(Acte $acte): self
    {
        if (!$this->actes->contains($acte)) {
            $this->actes[] = $acte;
            $acte->setManuscrit($this);
        }

        return $this;
    }

    public function removeActe(Acte $acte): self
    {
        if ($this->actes->removeElement($acte)) {
            // set the owning side to null (unless already changed)
            if ($acte->getManuscrit() === $this) {
                $acte->setManuscrit(null);
            }
        }

        return $this;
    }

}
