<?php

namespace App\Repository;

use App\Entity\DataAcrossHeader;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataAcrossHeader>
 *
 * @method DataAcrossHeader|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataAcrossHeader|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataAcrossHeader[]    findAll()
 * @method DataAcrossHeader[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataAcrossHeaderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataAcrossHeader::class);
    }

    public function add(DataAcrossHeader $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DataAcrossHeader $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DataAcrossHeader[] Returns an array of DataAcrossHeader objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DataAcrossHeader
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
