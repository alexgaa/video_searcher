<?php

namespace App\Repository;

use App\Entity\InputUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method InputUrl|null find($id, $lockMode = null, $lockVersion = null)
 * @method InputUrl|null findOneBy(array $criteria, array $orderBy = null)
 * @method InputUrl[]    findAll()
 * @method InputUrl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InputUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InputUrl::class);
    }

    // /**
    //  * @return InputUrl[] Returns an array of InputUrl objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InputUrl
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
