<?php

namespace App\Entity;

use App\Repository\ManuscriptRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Author;
use App\Entity\Act;
use App\Entity\Chapter;
use App\Entity\Scene;
use App\Entity\Cell;

/**
 * @ORM\Entity(repositoryClass=ManuscriptRepository::class)
 */
class Manuscript
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
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $fourthCover;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=author::class, inversedBy="manuscripts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=Act::class, cascade={"remove"}, mappedBy="manuscript")
     */
    private $acts;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cover;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $subTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $storyTelling;

    public function __construct()
    {
        $this->acts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFourthCover(): ?string
    {
        return $this->fourthCover;
    }

    public function setFourthCover(?string $fourthCover): self
    {
        $this->fourthCover = $fourthCover;

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

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Act[]
     */
    public function getActs(): Collection
    {
        return $this->acts;
    }

    public function addAct(Act $act): self
    {
        if (!$this->acts->contains($act)) {
            $this->acts[] = $act;
            $act->setManuscript($this);
        }

        return $this;
    }

    public function removeAct(Act $act): self
    {
        if ($this->acts->removeElement($act)) {
            // set the owning side to null (unless already changed)
            if ($act->getManuscript() === $this) {
                $act->setManuscript(null);
            }
        }

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSubTitle(): ?string
    {
        return $this->subTitle;
    }

    public function setSubTitle(?string $subTitle): self
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    public function getStoryTelling(): ?string
    {
        return $this->storyTelling;
    }

    public function setStoryTelling(?string $storyTelling): self
    {
        $this->storyTelling = $storyTelling;

        return $this;
    }

}
