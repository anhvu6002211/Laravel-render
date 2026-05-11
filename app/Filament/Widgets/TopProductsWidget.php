<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Cache;

class TopProductsWidget extends ChartWidget
{
    protected ?string $heading = '🏆 Top 10 Sản phẩm bán chạy';

    protected function getData(): array
    {
        $data     = Cache::get('analytics_data', []);
        $products = $data['top_products'] ?? [];

        $labels = [];
        $values = [];
        $colors = [
            '#f59e0b', '#6366f1', '#10b981', '#ef4444', '#8b5cf6',
            '#ec4899', '#14b8a6', '#f97316', '#84cc16', '#06b6d4',
        ];

        foreach ($products as $i => $product) {
            // Cắt ngắn tên nếu quá dài
            $labels[] = mb_strlen($product['name']) > 20
                ? mb_substr($product['name'], 0, 20) . '…'
                : $product['name'];
            $values[] = $product['total_sold'];
        }

        return [
            'datasets' => [
                [
                    'data'            => $values,
                    'backgroundColor' => array_slice($colors, 0, count($values)),
                    'borderWidth'     => 2,
                    'borderColor'     => '#ffffff',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['position' => 'right'],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(ctx){return ctx.label+": "+ctx.raw+" sản phẩm";}',
                    ],
                ],
            ],
            'cutout' => '60%',
        ];
    }
}
