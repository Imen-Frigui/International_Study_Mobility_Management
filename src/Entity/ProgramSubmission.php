<?php
namespace App\Entity;

use App\Repository\ProgramSubmissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity(repositoryClass: ProgramSubmissionRepository::class)]
class ProgramSubmission
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    private $id;

    #[ManyToOne(targetEntity: Program::class, inversedBy: 'programSubmissions')]
    private $program;

    #[ManyToMany(targetEntity: Document::class)]
    #[JoinTable(name: 'program_submission_documents')]
    private $documents;

    #[ORM\OneToMany(targetEntity: UploadedFile::class, mappedBy: 'programSubmission', cascade: ['persist'])]
    private $uploadedFiles;

    public function __construct()
    {
        $this->uploadedFiles = new ArrayCollection();
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
    public function getUploadedFiles(): Collection
    {
        return $this->uploadedFiles;
    }

    public function addUploadedFile(UploadedFile $uploadedFile): self
    {
        if (!$this->uploadedFiles->contains($uploadedFile)) {
            $this->uploadedFiles[] = $uploadedFile;
            $uploadedFile->setProgramSubmission($this);
        }

        return $this;
    }

    public function removeUploadedFile(UploadedFile $uploadedFile): self
    {
        if ($this->uploadedFiles->removeElement($uploadedFile)) {
            // set the owning side to null (unless already changed)
            if ($uploadedFile->getProgramSubmission() === $this) {
                $uploadedFile->setProgramSubmission(null);
            }
        }

        return $this;
    }
}
