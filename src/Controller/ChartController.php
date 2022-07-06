<?php

namespace App\Controller;

use App\Repository\LeadsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartController extends AbstractController
{
    #[Route('/chart', name: 'app_chart')]
    public function index(ChartBuilderInterface $chartBuilderInterface,
    LeadsRepository $leadsRepository,
    EntityManagerInterface $entityManagerInterface
    ): Response
    {

        $timeArr=hoursRange();
        // var_dump($timeArr);
        echo $timeArr['01:00'];
        // $hour01=count($leadsRepository->selectLeadChart($timeArr['00:00'],$timeArr['01:00'], $entityManagerInterface ));
        // $hour02=count($leadsRepository->selectLeadChart($timeArr['01:00'],$timeArr['02:00'], $entityManagerInterface ));
        // $hour03=count($leadsRepository->selectLeadChart($timeArr['02:00'],$timeArr['03:00'], $entityManagerInterface ));
        // $hour04=count($leadsRepository->selectLeadChart($timeArr['03:00'],$timeArr['04:00'], $entityManagerInterface ));
        // $hour05=count($leadsRepository->selectLeadChart($timeArr['04:00'],$timeArr['05:00'], $entityManagerInterface ));
        // $hour06=count($leadsRepository->selectLeadChart($timeArr['05:00'],$timeArr['06:00'], $entityManagerInterface ));
        // $hour07=count($leadsRepository->selectLeadChart($timeArr['06:00'],$timeArr['07:00'], $entityManagerInterface ));
        // $hour08=count($leadsRepository->selectLeadChart($timeArr['07:00'],$timeArr['08:00'], $entityManagerInterface ));
        // $hour09=count($leadsRepository->selectLeadChart($timeArr['08:00'],$timeArr['09:00'], $entityManagerInterface ));
        // $hour10=count($leadsRepository->selectLeadChart($timeArr['09:00'],$timeArr['10:00'], $entityManagerInterface ));
        // $hour11=count($leadsRepository->selectLeadChart($timeArr['10:00'],$timeArr['11:00'], $entityManagerInterface ));
        // $hour12=count($leadsRepository->selectLeadChart($timeArr['11:00'],$timeArr['12:00'], $entityManagerInterface ));
        // $hour13=count($leadsRepository->selectLeadChart($timeArr['12:00'],$timeArr['13:00'], $entityManagerInterface ));
        // $hour14=count($leadsRepository->selectLeadChart($timeArr['13:00'],$timeArr['14:00'], $entityManagerInterface ));
        // $hour15=count($leadsRepository->selectLeadChart($timeArr['14:00'],$timeArr['15:00'], $entityManagerInterface ));
        // $hour16=count($leadsRepository->selectLeadChart($timeArr['15:00'],$timeArr['16:00'], $entityManagerInterface ));
        // $hour17=count($leadsRepository->selectLeadChart($timeArr['16:00'],$timeArr['17:00'], $entityManagerInterface ));
        // $hour18=count($leadsRepository->selectLeadChart($timeArr['17:00'],$timeArr['18:00'], $entityManagerInterface ));
        // $hour19=count($leadsRepository->selectLeadChart($timeArr['18:00'],$timeArr['19:00'], $entityManagerInterface ));
        // $hour20=count($leadsRepository->selectLeadChart($timeArr['19:00'],$timeArr['20:00'], $entityManagerInterface ));
        // $hour21=count($leadsRepository->selectLeadChart($timeArr['20:00'],$timeArr['21:00'], $entityManagerInterface ));
        // $hour22=count($leadsRepository->selectLeadChart($timeArr['21:00'],$timeArr['22:00'], $entityManagerInterface ));
        // $hour23=count($leadsRepository->selectLeadChart($timeArr['22:00'],$timeArr['23:00'], $entityManagerInterface ));
        // $hour24=count($leadsRepository->selectLeadChartLastHour($timeArr['23:00'], $entityManagerInterface ));
        echo $hour12;
        echo $hour17;
        echo $hour18;
        $chart = $chartBuilderInterface->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['00h', '01h', '03h', '04h', '05h', '06h', '07h', '8h', '9h', '10h','11h','12h','13h','14h','15h','16h','17h','18h','19h','20h','21h','22h', '23h', '00h'],
            'datasets' => [
                [
                    'label' => 'Lead Per Day',
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
        return $this->render('admin/chart.html.twig', [
            'controller_name' => 'ChartController',
            'chart' => $chart,
        ]);
    }
    #[Route('/chart/test', name: 'test_chart')]
    public function FunctionName(): Response
    {
        return $this->render('chart/testChart.html.twig', []);
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