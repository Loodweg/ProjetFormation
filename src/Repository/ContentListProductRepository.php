<?php

namespace App\Repository;

use App\Entity\ContentListProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContentListProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContentListProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContentListProduct[]    findAll()
 * @method ContentListProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentListProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContentListProduct::class);
    }

    // /**
    //  * @return ContentListProduct[] Returns an array of ContentListProduct objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ContentListProduct
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
