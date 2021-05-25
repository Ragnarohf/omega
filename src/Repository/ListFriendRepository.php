<?php

namespace App\Repository;

use App\Entity\ListFriend;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListFriend|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListFriend|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListFriend[]    findAll()
 * @method ListFriend[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListFriendRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListFriend::class);
    }

    // /**
    //  * @return ListFriend[] Returns an array of ListFriend objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListFriend
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
