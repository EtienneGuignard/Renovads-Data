<?php

namespace App\Controller;

use App\Repository\LeadsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(AuthenticationUtils $authenticationUtils,
    ): Response
    {
  
        
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

       

        return $this->render('home/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            

        ]);
    }
    #[Route('/profile/result', name: 'app_profile_result')]
    public function resultSearch(AuthenticationUtils $authenticationUtils,
    LeadsRepository $leadsRepository,
    EntityManagerInterface $entityManagerInterface,
    ChartBuilderInterface $chartBuilder,
    ): Response
    {
  
        $user = $this->getUser();
        $userId=$user->getId();
        $supplierId=$user->getFkSupplier()->getId();

       
       if (isset($_POST['search'])) {

            $startDate=$_POST['startDate'];
            $endDate=$_POST['endDate'];
            $campaignId= 1;
           
            $status='accepted';

      
       

        $datesArr = getBetweenDatesAffiliates($startDate, $endDate);
        $dates =[];
        $leadPerday=[];
        
        foreach ($datesArr as $date) {
            $dates=$date."%";
            $leadPerdayArr=count($leadsRepository->selectLeadperday($dates, $campaignId, $supplierId, $status, $entityManagerInterface));
            $leadPerday[]=$leadPerdayArr;

        }

        $chart=chartSearchAffiliates($datesArr, $leadPerday, $chartBuilder);
       $resultsGlobal=$leadsRepository->selectLeadReportGlobal($startDate, $endDate, $campaignId, $supplierId, $status, $entityManagerInterface);
       $results=$leadsRepository->selectLeadReport($startDate, $endDate, $campaignId, $supplierId, $status, $entityManagerInterface);
      
    }
        return $this->render('home/resultAffiliate.html.twig', [

            'resultsGlobal'=>$resultsGlobal,
            'results'=>$results,
            'chart' =>$chart

        ]);
    }
}

function getBetweenDatesAffiliates($startDate, $endDate)
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

 function chartSearchAffiliates( $datesArr, $leadPerday, $chartBuilder):Chart
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => $datesArr,
            'datasets' => [
                [
                    'label' => 'leads',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    
                    'data' => $leadPerday,
                    'responsive'=> true,
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
            'maintainAspectRatio'=> false,
        ]);
        return $chart;
    }
