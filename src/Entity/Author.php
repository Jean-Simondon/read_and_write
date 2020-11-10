<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuthorRepository::class)
 */
class Author
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
    private $last_name;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $pen_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=Manuscript::class, mappedBy="author")
s     */
    private $manuscripts;

    public function __construct()
    {
        $this->manuscripts = new ArrayCollection();
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

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getPenName(): ?string
    {
        return $this->pen_name;
    }

    public function setPenName(?string $pen_name): self
    {
        $this->pen_name = $pen_name;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Manuscript[]
     */
    public function getManuscripts(): Collection
    {
        return $this->manuscripts;
    }

    public function addManuscript(Manuscript $manuscript): self
    {
        if (!$this->manuscripts->contains($manuscript)) {
            $this->manuscripts[] = $manuscript;
            $manuscript->setAuthor($this);
        }

        return $this;
    }

    public function removeManuscript(Manuscript $manuscript): self
    {
        if ($this->manuscripts->removeElement($manuscript)) {
            // set the owning side to null (unless already changed)
            if ($manuscript->getAuthor() === $this) {
                $manuscript->setAuthor(null);
            }
        }

        return $this;
    }
}
