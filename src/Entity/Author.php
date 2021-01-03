<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Manuscript;
use App\Entity\Act;
use App\Entity\Chapter;
use App\Entity\Scene;
use App\Entity\Cell;

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
     * @ORM\Column(type="string", length=30, nullable=true, name="last_name")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=30, nullable=true, name="first_name")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=30, nullable=true, name="pen_name")
     */
    private $penName;

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
     */
    private $manuscripts;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Author")
     * @ORM\JoinColumn(nullable=true)
     */
    private $User;

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
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPenName(): ?string
    {
        return $this->penName;
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

    public function __toString()
    {
        return $this->getPenName();
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
    


}
