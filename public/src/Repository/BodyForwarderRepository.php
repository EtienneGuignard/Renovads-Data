<?php

namespace App\Repository;

use App\Entity\BodyForwarder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BodyForwarder>
 *
 * @method BodyForwarder|null find($id, $lockMode = null, $lockVersion = null)
 * @method BodyForwarder|null findOneBy(array $criteria, array $orderBy = null)
 * @method BodyForwarder[]    findAll()
 * @method BodyForwarder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BodyForwarderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BodyForwarder::class);
    }

    public function add(BodyForwarder $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BodyForwarder $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return BodyForwarder[] Returns an array of BodyForwarder objects
    */
   public function findByFkforwarder($forwarderId): array
   {
       return $this->createQueryBuilder('b')
           ->andWhere('b.fkForwarder = :val')
           ->setParameter('val', $forwarderId)
           ->orderBy('b.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?BodyForwarder
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
