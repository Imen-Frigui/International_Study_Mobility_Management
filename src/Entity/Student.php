<?php

namespace App\Entity;

use App\Repository\StudentRepository;
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
    private ?float $getAverageGradeYear1 = null;

    #[ORM\Column]
    private ?float $getAverageGradeYear2 = null;

    #[ORM\Column]
    private ?float $getAverageGradeYear3 = null;

    #[ORM\Column]
    private ?float $getAverageGradeYear4 = null;

    #[ORM\Column]
    private ?float $getAverageGradeYear5 = null;

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

    public function getGetAverageGradeYear1(): ?float
    {
        return $this->getAverageGradeYear1;
    }

    public function setGetAverageGradeYear1(float $getAverageGradeYear1): static
    {
        $this->getAverageGradeYear1 = $getAverageGradeYear1;

        return $this;
    }

    public function getGetAverageGradeYear2(): ?float
    {
        return $this->getAverageGradeYear2;
    }

    public function setGetAverageGradeYear2(float $getAverageGradeYear2): static
    {
        $this->getAverageGradeYear2 = $getAverageGradeYear2;

        return $this;
    }

    public function getGetAverageGradeYear3(): ?float
    {
        return $this->getAverageGradeYear3;
    }

    public function setGetAverageGradeYear3(float $getAverageGradeYear3): static
    {
        $this->getAverageGradeYear3 = $getAverageGradeYear3;

        return $this;
    }

    public function getGetAverageGradeYear4(): ?float
    {
        return $this->getAverageGradeYear4;
    }

    public function setGetAverageGradeYear4(float $getAverageGradeYear4): static
    {
        $this->getAverageGradeYear4 = $getAverageGradeYear4;

        return $this;
    }

    public function getGetAverageGradeYear5(): ?float
    {
        return $this->getAverageGradeYear5;
    }

    public function setGetAverageGradeYear5(float $getAverageGradeYear5): static
    {
        $this->getAverageGradeYear5 = $getAverageGradeYear5;

        return $this;
    }
}
