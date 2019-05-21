<?php

namespace App\Repository;

use App\Entity\Ad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[]    findAll()
 * @method Ad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ad::class);
    }

    public function getAdsComments() {
        return $this->createQueryBuilder('a')
                    ->select('a as annonce, COUNT(c.comment) as totalComments')
                    ->join('a.comments', 'c')
                    ->groupBy('a')
                    ->orderBy('totalComments', 'DESC')
                    ->getQuery()
                    ->getResult();
    }

    public function getBestAds($limit) {

        return $this->createQueryBuilder('a')
                    ->select('a as annonce, AVG(c.rating) as ratings')
                    ->join('a.comments', 'c')
                    ->groupBy('a')
                    ->orderBy('ratings', 'DESC')
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->getResult();

    }

    // /**
    //  * @return Ad[] Returns an array of Ad objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ad
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
