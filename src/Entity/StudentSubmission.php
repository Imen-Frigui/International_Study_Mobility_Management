<?php

namespace App\Entity;

use App\Repository\StudentSubmissionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentSubmissionRepository::class)]
class StudentSubmission
{
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_BANNED = 'banned';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Program::class, inversedBy: 'studentSubmissions', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Program $program = null;

    #[ORM\Column(nullable: true)]
    private ?bool $passport = null;

    #[ORM\Column(nullable: true)]
    private ?bool $cv = null;

    #[ORM\Column(nullable: true)]
    private ?bool $recommendationLetter = null;

    #[ORM\Column(nullable: true)]
    private ?bool $englishLanguageCertificate = null;

    #[ORM\Column(nullable: true)]
    private ?bool $otherDocuments = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: 'string', length: 20, nullable: false)]
    private string $status = self::STATUS_PENDING;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgram(): ?Program
    {
        return $this->program;
    }

    public function setProgram(?Program $program): static
    {
        $this->program = $program;

        return $this;
    }

    public function isPassport(): ?bool
    {
        return $this->passport;
    }

    public function setPassport(?string $passport): static
    {
        $this->passport = $passport;

        return $this;
    }

    public function isCv(): ?bool
    {
        return $this->cv;
    }

    public function setCv(?string $cv): static
    {
        $this->cv = $cv;

        return $this;
    }

    public function isRecommendationLetter(): ?bool
    {
        return $this->recommendationLetter;
    }

    public function setRecommendationLetter(?string $recommendationLetter): static
    {
        $this->recommendationLetter = $recommendationLetter;

        return $this;
    }

    public function isEnglishLanguageCertificate(): ?bool
    {
        return $this->englishLanguageCertificate;
    }

    public function setEnglishLanguageCertificate(?bool $englishLanguageCertificate): static
    {
        $this->englishLanguageCertificate = $englishLanguageCertificate;

        return $this;
    }

    public function isOtherDocuments(): ?bool
    {
        return $this->otherDocuments;
    }

    public function setOtherDocuments(?bool $otherDocuments): static
    {
        $this->otherDocuments = $otherDocuments;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }
    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if (!in_array($status, [self::STATUS_PENDING, self::STATUS_ACCEPTED, self::STATUS_BANNED])) {
            throw new \InvalidArgumentException(sprintf('Invalid status "%s"', $status));
        }

        $this->status = $status;

        return $this;
    }
}
