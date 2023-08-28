<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class UploadedFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $path;

    #[ORM\ManyToOne(targetEntity: ProgramSubmission::class, inversedBy: 'uploadedFiles')]
    #[ORM\JoinColumn(nullable: false)]
    private $programSubmission;

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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getProgramSubmission(): ?ProgramSubmission
    {
        return $this->programSubmission;
    }

    public function setProgramSubmission(?ProgramSubmission $programSubmission): self
    {
        $this->programSubmission = $programSubmission;

        return $this;
    }
}
