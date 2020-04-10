<?php

namespace App\Repository;

use App\Entity\VideoData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method VideoData|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoData|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoData[]    findAll()
 * @method VideoData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoData::class);
    }

    // /**
    //  * @return VideoData[] Returns an array of VideoData objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VideoData
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
