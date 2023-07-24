<?php

namespace App\Repository;

use App\Entity\ProgramSubmission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProgramSubmission>
 *
 * @method ProgramSubmission|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgramSubmission|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgramSubmission[]    findAll()
 * @method ProgramSubmission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramSubmissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProgramSubmission::class);
    }

//    /**
//     * @return ProgramSubmission[] Returns an array of ProgramSubmission objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProgramSubmission
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
