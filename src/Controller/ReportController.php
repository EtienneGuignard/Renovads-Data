<?php

namespace App\Controller;

use App\Entity\ApiToken;
use App\Entity\Campaign;
use App\Entity\Forwarder;
use App\Entity\Leads;
use App\Entity\RuleGroup;
use App\Entity\Supplier;
use App\Entity\User;
use App\Form\ReportType;
use App\Repository\CampaignRepository;
use App\Repository\LeadsRepository;
use App\Repository\SupplierRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ReportController extends AbstractDashboardController
{
    #[Route('/report', name: 'app_report')]
    public function report(CampaignRepository $campaignRepository, SupplierRepository $supplierRepository, Request $request): Response
    {
        
        $campaigns=$campaignRepository->findAll();
        $suppliers=$supplierRepository->findAll();

        return $this->render('report/index.html.twig', [
            
            'suppliers'=>$suppliers,
            'campaigns'=>$campaigns
        ]);
    }

    #[Route('/reportAffiliate', name: 'app_report_affiliate')]
    public function reportAffiliate(CampaignRepository $campaignRepository, SupplierRepository $supplierRepository, Request $request): Response
    {
        
       

        return $this->render('report/form.html.twig', [
        
        ]);
    }

    #[Route('/report/result', name: 'app_report_results')]
    public function searchresult(EntityManagerInterface $entityManagerInterface, 
    LeadsRepository $leadsRepository,
     ChartBuilderInterface $chartBuilder, 
     CampaignRepository $campaignRepository, SupplierRepository $supplierRepository,
     ): Response
    {
        
        $campaigns=$campaignRepository->findAll();
        $suppliers=$supplierRepository->findAll();
       
       if (isset($_POST['search'])) {

            $startDate=$_POST['startDate'];
            $endDate=$_POST['endDate'];
            $campaignId=null;
            $supplierId=null;
            $status=null;
        
        if (isset($_POST['campaign'])) {
            
            $campaignId=$_POST['campaign'];
        }
        if (isset($_POST['supplier'])) {
            
            $supplierId=$_POST['supplier'];
        }
        if (isset($_POST['status'])) {
            
            $status=$_POST['status'];
        }
        $resultsGlobal=$leadsRepository->selectLeadReportGlobal($startDate, $endDate, $campaignId, $supplierId, $status, $entityManagerInterface);
        $results=$leadsRepository->selectLeadReport($startDate, $endDate, $campaignId, $supplierId, $status, $entityManagerInterface);
        
 
        $datesArr = getBetweenDates($startDate, $endDate);
        $dates =[];
        $leadPerday=[];
        
        foreach ($datesArr as $date) {
            $dates=$date."%";
            $leadPerdayArr=count($leadsRepository->selectLeadperday($dates, $campaignId, $supplierId, $status, $entityManagerInterface));
            $leadPerday[]=$leadPerdayArr;
        }

       $chart=chartSearch($datesArr, $leadPerday, $chartBuilder);
    }   
        return $this->render('report/results.html.twig', [
            'results'=>$results,
            'resultGlobal'=>$resultsGlobal,
            'chart'=>$chart,
            'suppliers'=>$suppliers,
            'campaigns'=>$campaigns

        ]);
    }
  

    #[Route('/report/result/report.csv', name: 'app_results_csv')]
    public function resultCSV(EntityManagerInterface $entityManagerInterface, 
    LeadsRepository $leadsRepository, 
     CampaignRepository $campaignRepository, SupplierRepository $supplierRepository,
     ): Response
    {
        
        $campaigns=$campaignRepository->findAll();
        $suppliers=$supplierRepository->findAll();
       
       if (isset($_POST['export'])) {

            $startDate=$_POST['startDate'];
            $endDate=$_POST['endDate'];
            $campaignId=null;
            $supplierId=null;
            $status=null;
        
        if (isset($_POST['campaign'])) {
            
            $campaignId=$_POST['campaign'];
        }
        if (isset($_POST['supplier'])) {
            
            $supplierId=$_POST['supplier'];
        }
        if (isset($_POST['status'])) {
            
            $status=$_POST['status'];
        }
        
        $datas=$leadsRepository->selectLeadCsvExport($startDate, $endDate, $campaignId, $supplierId, $status, $entityManagerInterface);
        
        $rows = array('id,created_at,' );
        foreach ($datas as $data) {
            $data = [$data['id'], $data['created_at'],$data['url'],$data['reference'],$data['sid'], $data['status'],$data['firstname'], $data['lastname'], $data['dob'], $data['address_1'], $data['zip'], $data['job'], $data['children'], $data['confirm_partners'],] ;

    
            $rows[] = implode(',', $data);
        }
    $content = implode("\n", $rows);
    $response = new Response($content);
    $response->headers->set('Content-Type', 'text/csv');

    return $response;
    
        $content = implode("\n", $rows);
     
   

     
    }   
    }

    #[Route('/report/resultAffiliate', name: 'app_report_results_affiliate')]
    public function affiliateReportResult(EntityManagerInterface $entityManagerInterface, LeadsRepository $leadsRepository ): Response
    {
        
        $form= $this->createForm(ReportType::class);
        
        $startDate=$_POST['startDate'];
        $endDate=$_POST['endDate'];
        $campaignId=$_POST['campaign'];
        $supplierId=$_POST['supplier'];
        $status=$_POST['status'];
       
        $results=$leadsRepository->selectLeadReportGlobal($startDate, $endDate, $campaignId, $supplierId, $status, $entityManagerInterface);
        
        return $this->render('report/affiliateResults.html.twig', [
            
            'form'=> $form->createView(),
            'results'=>$results
        ]);
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Results');
    }
    
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // necessary to implement easyadmin in app_select_rule_group
        yield MenuItem::linkToRoute('select', 'fa fa-home', 'app_select_rule_group')
        ->setCssClass("d-none");
        
        yield MenuItem::linkToRoute('select', 'fa fa-home', 'app_report_results')
        ->setCssClass("d-none");
        yield MenuItem::linkToCrud('Rule group', 'fas fa-list', RuleGroup::class);
        yield MenuItem::linkToCrud('Campaign', 'fas fa-bullhorn', Campaign::class);
        yield MenuItem::linkToCrud('Leads', 'fas fa-user', Leads::class);
        yield MenuItem::linkToCrud('Supplier', 'fas fa-building', Supplier::class);
        yield MenuItem::linkToCrud('Forwader', 'fas fa-exchange', Forwarder::class);
        yield MenuItem::linkToRoute('Report', 'fa fa-bar-chart', 'app_report');
        yield MenuItem::linkToCrud('Users', 'fas fa-address-book', User::class);
        yield MenuItem::linkToCrud('Token', 'fas fa-certificate', ApiToken::class);
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addWebpackEncoreEntry('admin');
    }

}
 function getBetweenDates($startDate, $endDate)
    {
        $rangArray = [];
            
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
             
        for ($currentDate = $startDate; $currentDate <= $endDate; 
                                        $currentDate += (86400)) {
                                                
            $date = date('Y-m-d', $currentDate);
            $rangArray[] = $date;
        }
  
        return $rangArray;
    }

 function chartSearch( $datesArr, $leadPerday, $chartBuilder):Chart
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => $datesArr,
            'datasets' => [
                [
                    'label' => 'New leads',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $leadPerday,
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);
        return $chart;
    }
