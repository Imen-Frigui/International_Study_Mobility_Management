<?php

namespace App\Repository;

use App\Entity\Program;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Program>
 *
 * @method Program|null find($id, $lockMode = null, $lockVersion = null)
 * @method Program|null findOneBy(array $criteria, array $orderBy = null)
 * @method Program[]    findAll()
 * @method Program[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Program::class);
    }

    public function getStudentStatusCount($programId, $status)
    {
        $qb = $this->createQueryBuilder('p')
            ->select('count(s.id)')
            ->join('p.programSubmissions', 's')
            ->where('p.id = :programId')
            ->andWhere('s.status = :status')
            ->setParameter('programId', $programId)
            ->setParameter('status', $status);

        return $qb->getQuery()->getSingleScalarResult();
    }
    public function findBySearchQuery($searchQuery)
    {
        return $this->createQueryBuilder('p')
            ->where('p.title LIKE :query')
            ->setParameter('query', '%'.$searchQuery.'%')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Program[] Returns an array of Program objects
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

//    public function findOneBySomeField($value): ?Program
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
