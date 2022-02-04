<?php

namespace App\Repository;

use App\Entity\ContentInvoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContentInvoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContentInvoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContentInvoice[]    findAll()
 * @method ContentInvoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentInvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContentInvoice::class);
    }

    // /**
    //  * @return ContentInvoice[] Returns an array of ContentInvoice objects
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
    public function findOneBySomeField($value): ?ContentInvoice
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
