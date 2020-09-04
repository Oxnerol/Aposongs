<?php

namespace App\Entity;

use App\Repository\NewContributionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewContributionRepository::class)
 */
class NewContribution
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
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $redirect;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerify;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contributionType;

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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getRedirect(): ?string
    {
        return $this->redirect;
    }

    public function setRedirect(string $redirect): self
    {
        $this->redirect = $redirect;

        return $this;
    }

    public function getIsVerify(): ?bool
    {
        return $this->isVerify;
    }

    public function setIsVerify(bool $isVerify): self
    {
        $this->isVerify = $isVerify;

        return $this;
    }

    public function getContributionType(): ?string
    {
        return $this->contributionType;
    }

    public function setContributionType(string $contributionType): self
    {
        $this->contributionType = $contributionType;

        return $this;
    }
}
