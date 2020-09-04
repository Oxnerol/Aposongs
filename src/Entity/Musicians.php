<?php

namespace App\Entity;

use App\Repository\MusiciansRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MusiciansRepository::class)
 */
class Musicians
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nickname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nationality;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $born;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $death;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $musicianImg;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $biography;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $altImg;


    public function __construct()
    {
        $this->altTextLanguages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

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

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getBorn(): ?\DateTimeInterface
    {
        return $this->born;
    }

    public function setBorn(?\DateTimeInterface $born): self
    {
        $this->born = $born;

        return $this;
    }

    public function getDeath(): ?\DateTimeInterface
    {
        return $this->death;
    }

    public function setDeath(?\DateTimeInterface $death): self
    {
        $this->death = $death;

        return $this;
    }

    public function getMusicianImg(): ?string
    {
        return $this->musicianImg;
    }

    public function setMusicianImg(?string $musicianImg): self
    {
        $this->musicianImg = $musicianImg;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): self
    {
        $this->biography = $biography;

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


}
