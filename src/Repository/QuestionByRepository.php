<?php

namespace App\Repository;

use App\Entity\QuestionBy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuestionBy|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionBy|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionBy[]    findAll()
 * @method QuestionBy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionByRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QuestionBy::class);
    }

    // /**
    //  * @return QuestionBy[] Returns an array of QuestionBy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuestionBy
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
