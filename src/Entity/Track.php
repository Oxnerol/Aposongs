<?php

namespace App\Entity;

use App\Repository\TrackRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LyricRepository::class)
 */
class Track
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $lyric;

    /**
     * @ORM\ManyToOne(targetEntity=Disc::class, inversedBy="tracks")
     */
    private $disc;



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

    public function getLyric(): ?string
    {
        return $this->lyric;
    }

    public function setLyric(?string $lyric): self
    {
        $this->lyric = $lyric;

        return $this;
    }

    public function getDisc(): ?Disc
    {
        return $this->disc;
    }

    public function setDisc(?Disc $disc): self
    {
        $this->disc = $disc;

        return $this;
    }


}
