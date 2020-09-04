<?php

namespace App\Entity;

use App\Entity\Track;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DiscRepository;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=DiscRepository::class)
 */
class Disc
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cover;

    /**
     * @ORM\Column(type="integer")
     */
    private $releaseDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $altImg;

    /**
     * @ORM\ManyToMany(targetEntity=Artists::class, mappedBy="discs")
     */
    private $artists;

    /**
     * @ORM\OneToMany(targetEntity=Track::class, mappedBy="disc")
     */
    private $tracks;


    public function __construct()
    {
        $this->artists = new ArrayCollection();
        $this->tracks = new ArrayCollection();
        $this->contributions = new ArrayCollection();
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

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getReleaseDate(): ?int
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(?int $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getAltImg(): ?string
    {
        return $this->altImg;
    }

    public function setAltImg(?string $altImg): self
    {
        $this->altImg = $altImg;

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
            $artist->addDisc($this);
        }

        return $this;
    }

    public function removeArtist(Artists $artist): self
    {
        if ($this->artists->contains($artist)) {
            $this->artists->removeElement($artist);
            $artist->removeDisc($this);
        }

        return $this;
    }

    /**
     * @return Collection|tracks[]
     */
    public function getTracks(): Collection
    {
        return $this->tracks;
    }

    public function addTracks(Track $tracks): self
    {
        if (!$this->tracks->contains($tracks)) {
            $this->tracks[] = $tracks;
            $tracks->setDisc($this);
        }

        return $this;
    }

    public function removeTracks(Track $tracks): self
    {
        if ($this->tracks->contains($tracks)) {
            $this->tracks->removeElement($tracks);
            // set the owning side to null (unless already changed)
            if ($tracks->getDisc() === $this) {
                $tracks->setDisc(null);
            }
        }

        return $this;
    }



}
