<?php

namespace App\Controller\Admin;

use App\Controller\CampaignController;
use App\Controller\ChartController;
use App\Entity\Campaign;
use App\Entity\Forwarder;
use App\Entity\Leads;
use App\Entity\RuleGroup;
use App\Entity\Supplier;
use App\Repository\LeadsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class DashboardController extends AbstractDashboardController
{
  
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator,
        private ChartBuilderInterface $chartBuilder,
        private LeadsRepository $leadsRepository,
        private EntityManagerInterface $entityManagerInterface,
    )
    {
    
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

      
        return $this->render('admin/index.html.twig', [
            'chart' => $this->chart(),
        ]);

    }

    private function chart(): Chart
    {
        $timeArr=hoursRange();

        $hour01=count($this->leadsRepository->selectLeadChart($timeArr['00:00'],$timeArr['01:00'], $this->entityManagerInterface ));
        $hour02=count($this->leadsRepository->selectLeadChart($timeArr['01:00'],$timeArr['02:00'], $this->entityManagerInterface ));
        $hour03=count($this->leadsRepository->selectLeadChart($timeArr['02:00'],$timeArr['03:00'], $this->entityManagerInterface ));
        $hour04=count($this->leadsRepository->selectLeadChart($timeArr['03:00'],$timeArr['04:00'], $this->entityManagerInterface ));
        $hour05=count($this->leadsRepository->selectLeadChart($timeArr['04:00'],$timeArr['05:00'], $this->entityManagerInterface ));
        $hour06=count($this->leadsRepository->selectLeadChart($timeArr['05:00'],$timeArr['06:00'], $this->entityManagerInterface ));
        $hour07=count($this->leadsRepository->selectLeadChart($timeArr['06:00'],$timeArr['07:00'], $this->entityManagerInterface ));
        $hour08=count($this->leadsRepository->selectLeadChart($timeArr['07:00'],$timeArr['08:00'], $this->entityManagerInterface ));
        $hour09=count($this->leadsRepository->selectLeadChart($timeArr['08:00'],$timeArr['09:00'], $this->entityManagerInterface ));
        $hour10=count($this->leadsRepository->selectLeadChart($timeArr['09:00'],$timeArr['10:00'], $this->entityManagerInterface ));
        $hour11=count($this->leadsRepository->selectLeadChart($timeArr['10:00'],$timeArr['11:00'], $this->entityManagerInterface ));
        $hour12=count($this->leadsRepository->selectLeadChart($timeArr['11:00'],$timeArr['12:00'], $this->entityManagerInterface ));
        $hour13=count($this->leadsRepository->selectLeadChart($timeArr['12:00'],$timeArr['13:00'], $this->entityManagerInterface ));
        $hour14=count($this->leadsRepository->selectLeadChart($timeArr['13:00'],$timeArr['14:00'], $this->entityManagerInterface ));
        $hour15=count($this->leadsRepository->selectLeadChart($timeArr['14:00'],$timeArr['15:00'], $this->entityManagerInterface ));
        $hour16=count($this->leadsRepository->selectLeadChart($timeArr['15:00'],$timeArr['16:00'], $this->entityManagerInterface ));
        $hour17=count($this->leadsRepository->selectLeadChart($timeArr['16:00'],$timeArr['17:00'], $this->entityManagerInterface ));
        $hour18=count($this->leadsRepository->selectLeadChart($timeArr['17:00'],$timeArr['18:00'], $this->entityManagerInterface ));
        $hour19=count($this->leadsRepository->selectLeadChart($timeArr['18:00'],$timeArr['19:00'], $this->entityManagerInterface ));
        $hour20=count($this->leadsRepository->selectLeadChart($timeArr['19:00'],$timeArr['20:00'], $this->entityManagerInterface ));
        $hour21=count($this->leadsRepository->selectLeadChart($timeArr['20:00'],$timeArr['21:00'], $this->entityManagerInterface ));
        $hour22=count($this->leadsRepository->selectLeadChart($timeArr['21:00'],$timeArr['22:00'], $this->entityManagerInterface ));
        $hour23=count($this->leadsRepository->selectLeadChart($timeArr['22:00'],$timeArr['23:00'], $this->entityManagerInterface ));
        $hour24=count($this->leadsRepository->selectLeadChartLastHour($timeArr['23:00'], $this->entityManagerInterface ));
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['00h', '01h', '02', '03h', '04h', '05h', '06h', '07h', '8h', '9h', '10h','11h','12h','13h','14h','15h','16h','17h','18h','19h','20h','21h','22h', '23h'],

            'datasets' => [
                [
                    'label' => 'New leads',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [$hour01, $hour02, $hour03, $hour04, $hour05, $hour06, $hour07, $hour08,$hour09,$hour10,$hour11,$hour12,$hour13,$hour14,$hour15,$hour16,$hour17,$hour18,$hour19,$hour20,$hour21,$hour22,$hour23,$hour24],
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

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Renovads Data');
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
       
    }
}

function hoursRange( $lower = 0, $upper = 86400, $step = 3600, $format = '' ) {
    $times = array();

    if ( empty( $format ) ) {
        $format = 'Y-m-d H:i';
    }

    foreach ( range( $lower, $upper, $step ) as $increment ) {
        $now=date_create('now');
        $increment = date( 'H:i', $increment );
        list( $hour, $minutes ) = explode( ':', $increment );
        $date = new DateTime( $hour . ':' . $minutes );
        $times[(string) $increment] = $date->format( $format );
    }

    return $times;
}