<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\UX\StimulusBundle\Ux\UxPackageMetadata;

final class ChartController extends AbstractController
{
    #[Route('/chart', name: 'app_chart')]
    public function index(ChartBuilderInterface $chartBuilder): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'Cookies eaten 🍪',
                    'backgroundColor' => 'rgb(255, 99, 132, .4)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [2, 10, 5, 18, 20, 30, 45],
                    'fill' => true,
                    'tension' => 0.1,
                ],
                [
                    'label' => 'Km walked 🏃‍♀️',
                    'backgroundColor' => 'rgba(45, 220, 126, .4)',
                    'borderColor' => 'rgba(45, 220, 126)',
                    'data' => [10, 15, 4, 3, 25, 41, 25],
                    'tension' => 0.4,
                ],
            ],
        ]);

        $chart->setOptions([
            'maintainAspectRatio' => false,
            'scales' => [
                'y' => [
                    'type' => 'logarithmic',
                    'position' => 'left',
                    'min' => 0,
                    'max' => 100,
                ],
            ],
        ]);

        return $this->render('chart/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}
