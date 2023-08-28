<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'documents')]
    private ?Program $program = null;

    #[ORM\OneToMany(mappedBy: 'documents', targetEntity: ProgramSubmission::class)]
    private Collection $programSubmissions;

    public function __construct()
    {
        $this->programSubmissions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
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
            $programSubmission->setDocuments($this);
        }

        return $this;
    }

    public function removeProgramSubmission(ProgramSubmission $programSubmission): static
    {
        if ($this->programSubmissions->removeElement($programSubmission)) {
            // set the owning side to null (unless already changed)
            if ($programSubmission->getDocuments() === $this) {
                $programSubmission->setDocuments(null);
            }
        }

        return $this;
    }
}
