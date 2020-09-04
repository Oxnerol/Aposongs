<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GenreRepository::class)
 */
class Genre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Artists::class, mappedBy="genre")
     */
    private $artists;

    public function __construct()
    {
        $this->artists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Artists[]
     */
    public function getArtists(): Collection
    {
        return $this->artists;
    }

    public function addArtist(Artists $artist): self
    {
        if (!$this->artists->contains($artist)) {
            $this->artists[] = $artist;
            $artist->addGenre($this);
        }

        return $this;
    }

    public function removeArtist(Artists $artist): self
    {
        if ($this->artists->contains($artist)) {
            $this->artists->removeElement($artist);
            $artist->removeGenre($this);
        }

        return $this;
    }
}
