<?php

namespace App\Entity;

use App\Entity\Genre;
use App\Entity\SubGenre;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use App\Repository\ArtistsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

/**
 * @ORM\Entity(repositoryClass=ArtistsRepository::class)
 * @UniqueEntity("name")
 * @ORM\HasLifecycleCallbacks()
 */
class Artists
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, name="name", unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true, )
     */
    private $bandActivityStart;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bandActivityEnd;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logoImg;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $biography;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $altImg;

    /**
     * @ORM\ManyToMany(targetEntity=Genre::class, inversedBy="artists")
     */
    private $genre;

    /**
     * @ORM\ManyToMany(targetEntity=SubGenre::class, inversedBy="artists")
     */
    private $subGenre;

    /**
     * @ORM\OneToMany(targetEntity=Link::class, mappedBy="artists")
     */
    private $link;

    /**
     * @ORM\ManyToMany(targetEntity=Disc::class, inversedBy="artists")
     */
    private $discs;

    /**
     * @ORM\ManyToMany(targetEntity=Video::class, inversedBy="artists")
     */
    private $videos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;


    public function __construct()
    {
        $this->genre = new ArrayCollection();
        $this->subGenre = new ArrayCollection();
        $this->link = new ArrayCollection();
        $this->discs = new ArrayCollection();
        $this->videos = new ArrayCollection();
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

    public function getBandActivityStart(): ?int
    {
        return $this->bandActivityStart;
    }

    public function setBandActivityStart(?int $bandActivityStart): self
    {
        $this->bandActivityStart = $bandActivityStart;

        return $this;
    }

    public function getBandActivityEnd(): ?int
    {
        return $this->bandActivityEnd;
    }

    public function setBandActivityEnd(?int $bandActivityEnd): self
    {
        $this->bandActivityEnd = $bandActivityEnd;

        return $this;
    }

    public function getLogoImg(): ?string
    {
        return $this->logoImg;
    }

    public function setLogoImg(?string $logoImg): self
    {
        $this->logoImg = $logoImg;

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

    /**
     * @return Collection|Genre[]
     */
    public function getGenre(): Collection
    {
        return $this->genre;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genre->contains($genre)) {
            $this->genre[] = $genre;
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        if ($this->genre->contains($genre)) {
            $this->genre->removeElement($genre);
        }

        return $this;
    }

    /**
     * @return Collection|SubGenre[]
     */
    public function getSubGenre(): Collection
    {
        return $this->subGenre;
    }

    public function addSubGenre(SubGenre $subGenre): self
    {
        if (!$this->subGenre->contains($subGenre)) {
            $this->subGenre[] = $subGenre;
        }

        return $this;
    }

    public function removeSubGenre(SubGenre $subGenre): self
    {
        if ($this->subGenre->contains($subGenre)) {
            $this->subGenre->removeElement($subGenre);
        }

        return $this;
    }

    /**
     * @return Collection|Link[]
     */
    public function getLink(): Collection
    {
        return $this->link;
    }

    public function addLink(Link $link): self
    {
        if (!$this->link->contains($link)) {
            $this->link[] = $link;
            $link->setArtists($this);
        }

        return $this;
    }

    public function removeLink(Link $link): self
    {
        if ($this->link->contains($link)) {
            $this->link->removeElement($link);
            // set the owning side to null (unless already changed)
            if ($link->getArtists() === $this) {
                $link->setArtists(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Disc[]
     */
    public function getDiscs(): Collection
    {
        return $this->discs;
    }

    public function addDisc(Disc $disc): self
    {
        if (!$this->discs->contains($disc)) {
            $this->discs[] = $disc;
        }

        return $this;
    }

    public function removeDisc(Disc $disc): self
    {
        if ($this->discs->contains($disc)) {
            $this->discs->removeElement($disc);
        }

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->contains($video)) {
            $this->videos->removeElement($video);
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Create the slug!
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateSlug(){
        if (!$this->slug){
            $slugify = new Slugify();
            $slug = $slugify->slugify($this->getName());
            $this->setSlug($slug);
        }
    }

}
