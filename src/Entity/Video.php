<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 */
class Video
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
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\ManyToMany(targetEntity=Artists::class, mappedBy="videos")
     */
    private $artists;

    /**
     * @ORM\ManyToOne(targetEntity=VideoCategory::class, inversedBy="videos")
     */
    private $category;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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
            $artist->addVideo($this);
        }

        return $this;
    }

    public function removeArtist(Artists $artist): self
    {
        if ($this->artists->contains($artist)) {
            $this->artists->removeElement($artist);
            $artist->removeVideo($this);
        }

        return $this;
    }

    public function getCategory(): ?VideoCategory
    {
        return $this->category;
    }

    public function setCategory(?VideoCategory $category): self
    {
        $this->category = $category;

        return $this;
    }



}
