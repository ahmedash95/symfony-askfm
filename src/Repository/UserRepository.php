<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByUserNameOrEmail($key) : ?User
    {
        $result  = $this->createQueryBuilder('u')
            ->andWhere('u.username = :val')
            ->orWhere('u.username = :val')
            ->setParameter('val', $key)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
        return count($result) > 0 ? $result[0] : null;
    }
}
