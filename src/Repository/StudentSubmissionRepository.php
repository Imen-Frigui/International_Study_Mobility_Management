<?php

namespace App\Repository;

use App\Entity\StudentSubmission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StudentSubmission>
 *
 * @method StudentSubmission|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentSubmission|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentSubmission[]    findAll()
 * @method StudentSubmission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentSubmissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentSubmission::class);
    }

//    /**
//     * @return StudentSubmission[] Returns an array of StudentSubmission objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StudentSubmission
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
