<?php

namespace App\Controller\Admin;

use App\Controller\CampaignController;
use App\Controller\ChartController;
use App\Entity\Campaign;
use App\Entity\Leads;
use App\Entity\RuleGroup;
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
        private ChartBuilderInterface $chartBuilder
    )
    {
    
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        $url= $this->adminUrlGenerator
                ->setController(CampaignCrudController::class)
                ->generateUrl();
                


        return $this->redirect($url);
        // return $this->render('admin/index.html.twig', [
        //     'chart' => $this->chart(),
        // ]);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }
        
        // $chart = $chartBuilder->createChart(Chart::TYPE_LINE)
        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }


    private function chart(): Chart
    {
        
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
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
        yield MenuItem::linkToCrud('Rule group', 'fas fa-list', RuleGroup::class);
        yield MenuItem::linkToCrud('Campaign', 'fas fa-bullhorn', Campaign::class);
        yield MenuItem::linkToCrud('Leads', 'fas fa-user', Leads::class);
    }
}
