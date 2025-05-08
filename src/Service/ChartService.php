<?php

namespace App\Service;

final class ChartService
{
    private float $multiplier;

    private array $data = [
        'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        'datasets' => [
            [
                'label' => 'Cookies eaten 🍪',
                'backgroundColor' => 'rgba(255, 99, 132, .4)',
                'borderColor' => 'rgb(255, 99, 132)',
                'data' => [2, 10, 5, 18, 20, 30, 45],
                'fill' => true,
                'tension' => 0.1,
            ],
            [
                'label' => 'Km walked 🏃‍♀️',
                'backgroundColor' => 'rgba(45, 220, 126, .4)',
                'borderColor' => 'rgb(45, 220, 126)',
                'data' => [10, 15, 4, 3, 25, 41, 25],
                'tension' => 0.4,
            ]
        ]
    ];

    public function fetchData($echelle)
    {
        $this->multiplier = $echelle / 50;

        for ($i=0; $i < count($this->data['datasets']) ; $i++) {
            $oldDataset = $this->data['datasets'][$i]['data'];
            $newDataset = array_map([$this, 'calculate'], $oldDataset);
            $this->data['datasets'][$i]['data'] = $newDataset;
        }

        return $this->data;
    }

    private function calculate($item) {
        return $item * $this->multiplier;
    }
}


