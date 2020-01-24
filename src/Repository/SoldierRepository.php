<?php

namespace App\Repository;

use App\Entity\Soldier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;

/**
 * @method Soldier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Soldier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Soldier[]    findAll()
 * @method Soldier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SoldierRepository extends EntityRepository
{


    // /**
    //  * @return Soldier[] Returns an array of Soldier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

   
    public function findOneBySomeField($value): ?Soldier
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p From App:Soldier WHERE p.first_name = nam4'
            )->getResult();

//        return $this->createQueryBuilder('s')
//            ->andWhere('s.first_name = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
    }
}
