<?php

namespace App\Twig\Components\Chart;

use App\Service\ChartService;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent]
final class ChartComponent
{
    use DefaultActionTrait;

    public function __construct(
        private ChartBuilderInterface $chartBuilder,
        private ChartService $chartService,
    ) {
    }

    #[LiveProp(writable: true)]
    public int $echelle = 50;

    #[ExposeInTemplate]
    public function getChart()
    {
        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData($this->chartService->fetchData(
            $this->echelle
        ));

        $chart->setOptions([
            'maintainAspectRatio' => false,
            'scales' => [
                'x' => [
                    'display' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Month',
                        'color' => '#911',
                        'font' => [
                            'family' => 'Comic Sans MS',
                            'size' => 20,
                            'weight' => 'bold',
                            'lineHeight' => 1.2,
                        ],
                        'padding' => ['top' => 20, 'left' => 0, 'right' => 0, 'bottom' => 0]
                    ]
                ],
                'y' => [
                    'display' => true,
                    'type' => 'logarithmic',
                    'position' => 'left',
                    'min' => 0,
                    'max' => 100,
                    'title' => [
                        'display' => true,
                        'text' => 'Value',
                        'color' => '#191',
                        'font' => [
                            'family' => 'Times',
                            'size' => 20,
                            'style' => 'normal',
                            'lineHeight' => 1.2
                        ],
                        'padding' => ['top' => 30, 'left' => 0, 'right' => 0, 'bottom' => 0]
                    ]
                ]
            ],
            'plugins' => [
                'zoom' => [
                    'zoom' => [
                        'wheel' => ['enabled' => true],
                        'pinch' => ['enabled' => true],
                        'mode' => 'xy',
                    ],
                ],
                'title' => [
                    'display' => true,
                    'text' => \sprintf(
                        'Echelle de %d%%',
                        abs($this->echelle)
                    ),
                    'color' => '#119',
                    'font' => [
                        'family' => 'Arial',
                        'size' => 22,
                        'style' => 'normal',
                        'lineHeight' => 1.2
                    ],
                ],
                'legend' => [
                    'labels' => [
                        'boxHeight' => 20,
                        'boxWidth' => 50,
                        'padding' => 20,
                        'font' => [
                            'size' => 14,
                        ],
                    ],
                ],
            ],
            'elements' => [
                'line' => [
                    'borderWidth' => 5,
                    'tension' => 0.25,
                    'borderCapStyle' => 'round',
                    'borderJoinStyle' => 'round',
                ],
            ],
        ]);

        return $chart;
    }
}
