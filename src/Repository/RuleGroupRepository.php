<?php

namespace App\Repository;

use App\Entity\RuleGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RuleGroup>
 *
 * @method RuleGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method RuleGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method RuleGroup[]    findAll()
 * @method RuleGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RuleGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RuleGroup::class);
    }

    public function add(RuleGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RuleGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return RuleGroup[] Returns an array of RuleGroup objects
    */
   public function ruleList($entityManagerInterface, $campaignId): array
   {
       
    $conn=$entityManagerInterface->getConnection();

    $rawSql = "SELECT * FROM `rule_group`
    LEFT JOIN rule_group_campaign
    ON rule_group.id=rule_group_campaign.rule_group_id
    WHERE rule_group_campaign.campaign_id = :campaignId";
    $query=$conn->prepare($rawSql);
    $result= $query->executeQuery([
                                'campaignId'=>$campaignId,
                            ]);
    return $result->fetchAllAssociative();
   }

//    public function findOneBySomeField($value): ?RuleGroup
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
