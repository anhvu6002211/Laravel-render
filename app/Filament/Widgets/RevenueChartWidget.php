<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Cache;

class RevenueChartWidget extends ChartWidget
{
    protected ?string $heading = '📈 Doanh thu 30 ngày qua';
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $data  = Cache::get('analytics_data', []);
        $daily = $data['daily_revenue'] ?? [];

        $labels  = [];
        $revenue = [];
        $orders  = [];

        foreach ($daily as $row) {
            // Hiển thị dạng "11/05" thay vì "2026-05-11"
            $parts    = explode('-', $row['date']);
            $labels[] = $parts[2] . '/' . $parts[1];
            $revenue[] = $row['revenue'];
            $orders[]  = $row['orders'];
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Doanh thu (₫)',
                    'data'            => $revenue,
                    'borderColor'     => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill'            => true,
                    'tension'         => 0.4,
                    'yAxisID'         => 'y',
                ],
                [
                    'label'           => 'Số đơn hàng',
                    'data'            => $orders,
                    'borderColor'     => '#6366f1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                    'fill'            => false,
                    'tension'         => 0.4,
                    'yAxisID'         => 'y1',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'interaction' => ['mode' => 'index', 'intersect' => false],
            'scales'      => [
                'y'  => ['position' => 'left', 'ticks' => ['callback' => 'function(v){return v.toLocaleString("vi-VN")+"₫"}']],
                'y1' => ['position' => 'right', 'grid' => ['drawOnChartArea' => false]],
            ],
            'plugins' => [
                'legend' => ['display' => true],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(ctx){if(ctx.dataset.yAxisID==="y")return ctx.dataset.label+": "+ctx.raw.toLocaleString("vi-VN")+"₫";return ctx.dataset.label+": "+ctx.raw+" đơn";}',
                    ],
                ],
            ],
        ];
    }
}
