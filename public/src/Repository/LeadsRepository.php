<?php

namespace App\Repository;

use App\Entity\Leads;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Leads>
 *
 * @method Leads|null find($id, $lockMode = null, $lockVersion = null)
 * @method Leads|null findOneBy(array $criteria, array $orderBy = null)
 * @method Leads[]    findAll()
 * @method Leads[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeadsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Leads::class);
    }

    public function add(Leads $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Leads $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    
    public function selectLeadChart($date1, $date2, EntityManagerInterface $entityManagerInterface)
    {
        $conn=$entityManagerInterface->getConnection();
        $rawSql = "SELECT * FROM leads
        WHERE created_at BETWEEN :date1 AND :date2";
        $query=$conn->prepare($rawSql);
        $result= $query->executeQuery([
                                    'date1'=>$date1,
                                    'date2'=>$date2
                                ]);
        return $result->fetchAllAssociative();
    }

    public function selectLeadChartLastHour($time, EntityManagerInterface $entityManagerInterface)
    {
        $conn=$entityManagerInterface->getConnection();
        $rawSql = "SELECT * FROM leads
        WHERE created_at > :time";
        $query=$conn->prepare($rawSql);
        $result= $query->executeQuery([
                                    'time'=>$time,
                                ]);
        return $result->fetchAllAssociative();
    }
    public function selectLeadReport($startDate, $endDate, $campaignId, $supplierId, $status, $entityManagerInterface)
    {
        $conn=$entityManagerInterface->getConnection();
        $rawSql = "SELECT * FROM `leads`
        LEFT JOIN campaign_leads
        ON leads.id=campaign_leads.lead_id_id
        LEFT JOIN supplier
        ON leads.supplier_id=supplier.id
	  WHERE created_at BETWEEN :startDate AND :endDate
        AND  campaign_leads.campaign_id_id=IF(:campaignId IS NULL, campaign_leads.campaign_id_id, :campaignId)
        AND  leads.supplier_id=IF(:supplierId IS NULL, leads.supplier_id, :supplierId)
        AND campaign_leads.status=IF(:status IS NULL, campaign_leads.status, :status)";
        $query=$conn->prepare($rawSql);
        $result= $query->executeQuery([
                                    'startDate'=>$startDate,
                                    'endDate'=>$endDate,
                                    'campaignId'=>$campaignId,
                                    'supplierId'=>$supplierId,
                                    'status'=>$status
                                ]);
        return $result->fetchAllAssociative();
    }
    public function selectLeadReportGlobal($startDate, $endDate, $campaignId, $supplierId, $status, $entityManagerInterface)
    {
        $conn=$entityManagerInterface->getConnection();
        $rawSql = "SELECT COUNT(leads.id) AS NumberOfLeads FROM `leads`
        LEFT JOIN campaign_leads
        ON leads.id=campaign_leads.lead_id_id
        LEFT JOIN supplier
        ON leads.supplier_id=supplier.id
	  WHERE created_at BETWEEN :startDate AND :endDate
        AND  campaign_leads.campaign_id_id=IF(:campaignId IS NULL, campaign_leads.campaign_id_id, :campaignId)
        AND  leads.supplier_id=IF(:supplierId IS NULL, leads.supplier_id, :supplierId)
        AND campaign_leads.status=IF(:status IS NULL, campaign_leads.status, :status)";
        $query=$conn->prepare($rawSql);
        $result= $query->executeQuery([
                                    'startDate'=>$startDate,
                                    'endDate'=>$endDate,
                                    'campaignId'=>$campaignId,
                                    'supplierId'=>$supplierId,
                                    'status'=>$status
                                ]);
        return $result->fetchAllAssociative();
    }

    public function selectLeadperday($dates, $campaignId, $supplierId, $status, $entityManagerInterface)
    {
        $conn=$entityManagerInterface->getConnection();
        $rawSql = "SELECT leads.id FROM `leads`
        LEFT JOIN campaign_leads
        ON leads.id=campaign_leads.lead_id_id
        LEFT JOIN supplier
        ON leads.supplier_id=supplier.id
	    WHERE created_at LIKE :date
        AND  campaign_leads.campaign_id_id=IF(:campaignId IS NULL, campaign_leads.campaign_id_id, :campaignId)
        AND  leads.supplier_id=IF(:supplierId IS NULL, leads.supplier_id, :supplierId)
        AND campaign_leads.status=IF(:status IS NULL, campaign_leads.status, :status)";
        $query=$conn->prepare($rawSql);
        $result= $query->executeQuery([
                                    'date'=>$dates,
                                    'campaignId'=>$campaignId,
                                    'supplierId'=>$supplierId,
                                    'status'=>$status
                                ]);
        return $result->fetchAllAssociative();
    }

    public function selectLeadDasboard($entityManagerInterface)
    {
        $conn=$entityManagerInterface->getConnection();
        $rawSql = "SELECT supplier.reference, COUNT(*) AS NumberOfLeads FROM `leads`
        LEFT JOIN campaign_leads
        ON leads.id=campaign_leads.lead_id_id
        LEFT JOIN supplier
        ON leads.supplier_id=supplier.id
	    WHERE campaign_leads.status='Accepted' GROUP BY supplier.id";
        $query=$conn->prepare($rawSql);
        $result= $query->executeQuery([
                                ]);
        return $result->fetchAllAssociative();
    }


//     /**
//     * @return Leads[] Returns an array of Leads objects
//     */
// public function findByExampleField($value): array
//     {
//     $hours=hoursRange();

//         return $this->createQueryBuilder('l')
//             ->andWhere('l.exampleField = :val')
//             ->setParameter('val', $value)
//             ->orderBy('l.id', 'ASC')
//             ->setMaxResults(10)
//             ->getQuery()
//             ->getResult();
//     }

//    public function findOneBySomeField($value): ?Leads
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
