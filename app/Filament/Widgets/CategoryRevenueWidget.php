<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Cache;

class CategoryRevenueWidget extends ChartWidget
{
    protected ?string $heading = '📊 Doanh thu theo danh mục';

    protected function getData(): array
    {
        $data       = Cache::get('analytics_data', []);
        $categories = $data['revenue_by_category'] ?? [];

        $labels  = [];
        $revenue = [];
        $colors  = [
            'rgba(245,158,11,0.8)', 'rgba(99,102,241,0.8)', 'rgba(16,185,129,0.8)',
            'rgba(239,68,68,0.8)',  'rgba(139,92,246,0.8)', 'rgba(236,72,153,0.8)',
        ];

        foreach ($categories as $i => $cat) {
            $labels[]  = $cat['category'];
            $revenue[] = $cat['revenue'];
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Doanh thu (₫)',
                    'data'            => $revenue,
                    'backgroundColor' => array_slice($colors, 0, count($revenue)),
                    'borderRadius'    => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',   // Horizontal bar
            'plugins'   => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'x' => [
                    'ticks' => [
                        'callback' => 'function(v){return (v/1000000).toFixed(1)+"M₫"}',
                    ],
                ],
            ],
        ];
    }
}
