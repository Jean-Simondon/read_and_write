<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuteurRepository::class)
 */
class Auteur
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
    private $login;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $nom_de_plume;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $mail;

    /**
     * @ORM\OneToMany(targetEntity=Manuscrit::class, mappedBy="auteur")
     */
    private $manuscrits;

    public function __construct()
    {
        $this->manuscrits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNomDePlume(): ?string
    {
        return $this->nom_de_plume;
    }

    public function setNomDePlume(?string $nom_de_plume): self
    {
        $this->nom_de_plume = $nom_de_plume;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return Collection|Manuscrit[]
     */
    public function getManuscrits(): Collection
    {
        return $this->manuscrits;
    }

    public function addManuscrit(Manuscrit $manuscrit): self
    {
        if (!$this->manuscrits->contains($manuscrit)) {
            $this->manuscrits[] = $manuscrit;
            $manuscrit->setAuteur($this);
        }

        return $this;
    }

    public function removeManuscrit(Manuscrit $manuscrit): self
    {
        if ($this->manuscrits->removeElement($manuscrit)) {
            // set the owning side to null (unless already changed)
            if ($manuscrit->getAuteur() === $this) {
                $manuscrit->setAuteur(null);
            }
        }

        return $this;
    }
}
