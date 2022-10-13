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
   
        $chart = $chartBuilderInterface->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['00h', '01h', '03h', '04h', '05h', '06h', '07h', '8h', '9h', '10h','11h','12h','13h','14h','15h','16h','17h','18h','19h','20h','21h','22h', '23h', '00h'],
            'datasets' => [
                [
                    'label' => 'Lead Per Day',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => ['00h', '01h', '03h', '04h', '05h', '06h', '07h', '8h', '9h', '10h','11h','12h','13h','14h','15h','16h','17h','18h','19h','20h','21h','22h', '23h', '00h'],
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