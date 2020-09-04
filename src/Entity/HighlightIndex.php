<?php

namespace App\Entity;

use App\Repository\HighlightIndexRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HighlightIndexRepository::class)
 */
class HighlightIndex
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $targetId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->videoCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

}
