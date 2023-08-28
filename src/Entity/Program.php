<?php

namespace App\Entity;

use App\Repository\ProgramRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private ?string $link = null;

    #[ORM\OneToMany(mappedBy: 'program', targetEntity: Document::class)]
    private Collection $documents;

    #[ORM\OneToMany(mappedBy: 'program', targetEntity: ProgramSubmission::class)]
    private Collection $programSubmissions;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->programSubmissions = new ArrayCollection();
    }


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


    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): static
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
            $document->setProgram($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): static
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getProgram() === $this) {
                $document->setProgram(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProgramSubmission>
     */
    public function getProgramSubmissions(): Collection
    {
        return $this->programSubmissions;
    }

    public function addProgramSubmission(ProgramSubmission $programSubmission): static
    {
        if (!$this->programSubmissions->contains($programSubmission)) {
            $this->programSubmissions->add($programSubmission);
            $programSubmission->setProgram($this);
        }

        return $this;
    }

    public function removeProgramSubmission(ProgramSubmission $programSubmission): static
    {
        if ($this->programSubmissions->removeElement($programSubmission)) {
            // set the owning side to null (unless already changed)
            if ($programSubmission->getProgram() === $this) {
                $programSubmission->setProgram(null);
            }
        }

        return $this;
    }


}
