<?php

namespace App\Repository;

use App\Entity\MilitaryUnit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MilitaryUnit|null find($id, $lockMode = null, $lockVersion = null)
 * @method MilitaryUnit|null findOneBy(array $criteria, array $orderBy = null)
 * @method MilitaryUnit[]    findAll()
 * @method MilitaryUnit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MilitaryUnitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MilitaryUnit::class);
    }

    // /**
    //  * @return MilitaryUnit[] Returns an array of MilitaryUnit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MilitaryUnit
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
