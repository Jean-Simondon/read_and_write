<?php

namespace App\Entity;

use App\Repository\ActRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Author;
use App\Entity\Manuscript;
use App\Entity\Chapter;
use App\Entity\Scene;
use App\Entity\Cell;

/**
 * @ORM\Entity(repositoryClass=ActRepository::class)
 */
class Act
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=manuscript::class, inversedBy="acts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $manuscript;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=chapter::class, mappedBy="act")
     */
    private $chapters;

    public function __construct()
    {
        $this->chapters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManuscript(): ?manuscript
    {
        return $this->manuscript;
    }

    public function setManuscript(?manuscript $manuscript): self
    {
        $this->manuscript = $manuscript;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Chapter[]
     */
    public function getChapters(): Collection
    {
        return $this->chapters;
    }

    public function addChapter(Chapter $chapter): self
    {
        if (!$this->chapters->contains($chapter)) {
            $this->chapters[] = $chapter;
            $chapter->setAct($this);
        }

        return $this;
    }

    public function removeChapter(Chapter $chapter): self
    {
        if ($this->chapters->removeElement($chapter)) {
            // set the owning side to null (unless already changed)
            if ($chapter->getAct() === $this) {
                $chapter->setAct(null);
            }
        }

        return $this;
    }
}
