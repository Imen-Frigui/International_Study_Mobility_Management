<?php

namespace App\Entity;

use App\Repository\ProgramSubmissionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgramSubmissionRepository::class)]
class ProgramSubmission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nationality = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $passportNumber = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $cv = null;

    #[ORM\Column(type: 'boolean')]
    private bool $passportNeeded = false;

    #[ORM\Column(type: 'boolean')]
    private bool $cvNeeded = false;

    #[ORM\Column(type: 'boolean')]
    private bool $recommendationLetterNeeded = false;

    #[ORM\Column(type: 'boolean')]
    private bool $englishLanguageCertificateNeeded = false;

    #[ORM\Column(type: 'boolean')]
    private bool $otherDocumentsNeeded = false;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $phone = null;

    #[ORM\ManyToOne(targetEntity: Program::class, inversedBy: 'submissions', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Program $program = null;
    // Getters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function getPassportNumber(): ?string
    {
        return $this->passportNumber;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function isPassportNeeded(): bool
    {
        return $this->passportNeeded;
    }

    public function isCvNeeded(): bool
    {
        return $this->cvNeeded;
    }

    public function isRecommendationLetterNeeded(): bool
    {
        return $this->recommendationLetterNeeded;
    }

    public function isEnglishLanguageCertificateNeeded(): bool
    {
        return $this->englishLanguageCertificateNeeded;
    }

    public function isOtherDocumentsNeeded(): bool
    {
        return $this->otherDocumentsNeeded;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getProgram(): ?Program
    {
        return $this->program;
    }

    // Setters

    public function setNationality(?string $nationality): self
    {
        $this->nationality = $nationality;
        return $this;
    }

    public function setPassportNumber(?string $passportNumber): self
    {
        $this->passportNumber = $passportNumber;
        return $this;
    }

    public function setCv(?string $cv): self
    {
        $this->cv = $cv;
        return $this;
    }

    public function setPassportNeeded(bool $passportNeeded): self
    {
        $this->passportNeeded = $passportNeeded;
        return $this;
    }

    public function setCvNeeded(bool $cvNeeded): self
    {
        $this->cvNeeded = $cvNeeded;
        return $this;
    }

    public function setRecommendationLetterNeeded(bool $recommendationLetterNeeded): self
    {
        $this->recommendationLetterNeeded = $recommendationLetterNeeded;
        return $this;
    }

    public function setEnglishLanguageCertificateNeeded(bool $englishLanguageCertificateNeeded): self
    {
        $this->englishLanguageCertificateNeeded = $englishLanguageCertificateNeeded;
        return $this;
    }

    public function setOtherDocumentsNeeded(bool $otherDocumentsNeeded): self
    {
        $this->otherDocumentsNeeded = $otherDocumentsNeeded;
        return $this;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function setProgram(?Program $program): self
    {
        $this->program = $program;
        return $this;
    }
}
