<?php

namespace App\Entity;

use App\Repository\AltTextLanguageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AltTextLanguageRepository::class)
 */
class AltTextLanguage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity=ContributionLanguage::class, inversedBy="altTextLanguages")
     */
    private $language;

    /**
     * @ORM\Column(type="integer")
     */
    private $targetId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categoriName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getLanguage(): ?ContributionLanguage
    {
        return $this->language;
    }

    public function setLanguage(?ContributionLanguage $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getTargetId(): ?int
    {
        return $this->targetId;
    }

    public function setTargetId(int $targetId): self
    {
        $this->targetId = $targetId;

        return $this;
    }

    public function getCategoriName(): ?string
    {
        return $this->categoriName;
    }

    public function setCategoriName(string $categoriName): self
    {
        $this->categoriName = $categoriName;

        return $this;
    }
}
