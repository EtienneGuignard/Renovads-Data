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


    public function campaignLeadExist($leadId, $campaignId, $entityManagerInterface)
    {
        $conn=$entityManagerInterface->getConnection();
        $rawSql = "SELECT campaign_leads.id, campaign_leads.lead_id_id, campaign_leads.campaign_id_id, leads.email   FROM `campaign_leads`
        LEFT JOIN leads
        ON campaign_leads.lead_id_id=leads.id
	    WHERE campaign_leads.lead_id_id =:leadId  AND campaign_leads.campaign_id_id=:campaignId";

        $query=$conn->prepare($rawSql);
        $result= $query->executeQuery([
                                    'leadId'=>$leadId,
                                    'campaignId'=>$campaignId,
                                ]);
        return $result->fetchAllAssociative();
    }
    public function campaignLeadExistPerEmail($emailUser, $campaignId, $entityManagerInterface)
    {
        $conn=$entityManagerInterface->getConnection();
        $rawSql = "SELECT campaign_leads.id, campaign_leads.lead_id_id, campaign_leads.campaign_id_id, leads.email   FROM `campaign_leads`
        LEFT JOIN leads
        ON campaign_leads.lead_id_id=leads.id
	    WHERE leads.email =:emailUser  AND campaign_leads.campaign_id_id=:campaignId";
        $query=$conn->prepare($rawSql);
        $result= $query->executeQuery([
                                    'emailUser'=>$emailUser,
                                    'campaignId'=>$campaignId,
                                ]);
        return $result->fetchAllAssociative();
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
