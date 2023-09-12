<?php
// src/Repository/ProgramFileRepository.php

namespace App\Repository;

use App\Entity\ProgramFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProgramFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProgramFile::class);
    }

    // You can add custom query methods here if needed.
}
