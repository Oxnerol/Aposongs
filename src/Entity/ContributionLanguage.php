<?php

namespace App\Entity;

use App\Repository\ContributionLanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContributionLanguageRepository::class)
 */
class ContributionLanguage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $language;

    /**
     * @ORM\OneToMany(targetEntity=AltTextLanguage::class, mappedBy="language")
     */
    private $altTextLanguages;

    public function __construct()
    {
        $this->altTextLanguages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return Collection|AltTextLanguage[]
     */
    public function getAltTextLanguages(): Collection
    {
        return $this->altTextLanguages;
    }

    public function addAltTextLanguage(AltTextLanguage $altTextLanguage): self
    {
        if (!$this->altTextLanguages->contains($altTextLanguage)) {
            $this->altTextLanguages[] = $altTextLanguage;
            $altTextLanguage->setLanguage($this);
        }

        return $this;
    }

    public function removeAltTextLanguage(AltTextLanguage $altTextLanguage): self
    {
        if ($this->altTextLanguages->contains($altTextLanguage)) {
            $this->altTextLanguages->removeElement($altTextLanguage);
            // set the owning side to null (unless already changed)
            if ($altTextLanguage->getLanguage() === $this) {
                $altTextLanguage->setLanguage(null);
            }
        }

        return $this;
    }
}
