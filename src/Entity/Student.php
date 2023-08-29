<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column]
    private ?float $firstYearGrade = null;

    #[ORM\Column]
    private ?float $secondYearGrade = null;

    #[ORM\Column]
    private ?float $thirdYearGrade = null;

    #[ORM\Column]
    private ?float $fourthYearGrade = null;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: ProgramSubmission::class)]
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

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstYearGrade(): ?float
    {
        return $this->firstYearGrade;
    }

    public function setFirstYearGrade(float $firstYearGrade): static
    {
        $this->firstYearGrade = $firstYearGrade;

        return $this;
    }

    public function getSecondYearGrade(): ?float
    {
        return $this->secondYearGrade;
    }

    public function setSecondYearGrade(float $secondYearGrade): static
    {
        $this->secondYearGrade = $secondYearGrade;

        return $this;
    }

    public function getThirdYearGrade(): ?float
    {
        return $this->thirdYearGrade;
    }

    public function setThirdYearGrade(float $thirdYearGrade): static
    {
        $this->thirdYearGrade = $thirdYearGrade;

        return $this;
    }

    public function getGetAverageGradeYear4(): ?float
    {
        return $this->getAverageGradeYear4;
    }

    public function setFourthYearGrade(float $fourthYearGrade): static
    {
        $this->fourthYearGrade = $fourthYearGrade;

        return $this;
    }
    public function getAverageGrade(): ?float
    {
        return ($this->firstYearGrade + $this->secondYearGrade + $this->thirdYearGrade + $this->fourthYearGrade) / 4;
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
            $programSubmission->setStudent($this);
        }

        return $this;
    }

    public function removeProgramSubmission(ProgramSubmission $programSubmission): static
    {
        if ($this->programSubmissions->removeElement($programSubmission)) {
            // set the owning side to null (unless already changed)
            if ($programSubmission->getStudent() === $this) {
                $programSubmission->setStudent(null);
            }
        }

        return $this;
    }

}
