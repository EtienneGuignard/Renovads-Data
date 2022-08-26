<?php

namespace App\Repository;

use App\Entity\CampaignLeads;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;

/**
 * @extends ServiceEntityRepository<CampaignLeads>
 *
 * @method CampaignLeads|null find($id, $lockMode = null, $lockVersion = null)
 * @method CampaignLeads|null findOneBy(array $criteria, array $orderBy = null)
 * @method CampaignLeads[]    findAll()
 * @method CampaignLeads[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampaignLeadsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CampaignLeads::class);
    }

    public function add(CampaignLeads $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CampaignLeads $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
//    /**
//     * @return CampaignLeads[] Returns an array of CampaignLeads objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CampaignLeads
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
