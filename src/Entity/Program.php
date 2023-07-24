<?php

namespace App\Entity;

use App\Repository\ProgramRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgramRepository::class)]
class Program
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(length: 255)]
    private ?string $eligibilityCriteria = null;

    #[ORM\Column(length: 255)]
    private ?string $documentsNeeded = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\ManyToOne(inversedBy: 'programs')]
    private ?University $University = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getEligibilityCriteria(): ?string
    {
        return $this->eligibilityCriteria;
    }

    public function setEligibilityCriteria(string $eligibilityCriteria): static
    {
        $this->eligibilityCriteria = $eligibilityCriteria;

        return $this;
    }

    public function getDocumentsNeeded(): ?string
    {
        return $this->documentsNeeded;
    }

    public function setDocumentsNeeded(string $documentsNeeded): static
    {
        $this->documentsNeeded = $documentsNeeded;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getUniversity(): ?University
    {
        return $this->University;
    }

    public function setUniversity(?University $University): static
    {
        $this->University = $University;

        return $this;
    }
}
