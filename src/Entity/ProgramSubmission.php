<?php

namespace App\Entity;

use App\Repository\ProgramSubmissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[ORM\Entity(repositoryClass: ProgramSubmissionRepository::class)]
class ProgramSubmission
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Program::class, inversedBy: 'programSubmissions')]
    private $program;

    #[ORM\ManyToMany(targetEntity: Document::class)]
    #[ORM\JoinTable(name: 'program_submission_documents')]
    private $documents;

    #[ORM\OneToMany(targetEntity: ProgramFile::class, mappedBy: 'programSubmission', cascade: ['persist'])]
    private $programFiles;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'programSubmissions')]
    private $student;

    public function __construct()
    {
        $this->programFiles = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgram(): ?Program
    {
        return $this->program;
    }

    public function setProgram(?Program $program): self
    {
        $this->program = $program;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        $this->documents->removeElement($document);

        return $this;
    }

    public function getProgramFiles(): Collection
    {
        return $this->programFiles;
    }

    public function addProgramFile(ProgramFile $programFile): self
    {
        if (!$this->programFiles->contains($programFile)) {
            $this->programFiles[] = $programFile;
            $programFile->setProgramSubmission($this);
        }

        return $this;
    }

    public function removeProgramFile(ProgramFile $programFile): self
    {
        if ($this->programFiles->removeElement($programFile)) {
            // set the owning side to null (unless already changed)
            if ($programFile->getProgramSubmission() === $this) {
                $programFile->setProgramSubmission(null);
            }
        }

        return $this;
    }
}
