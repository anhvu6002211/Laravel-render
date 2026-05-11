<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class AnalyticsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $data     = Cache::get('analytics_data', []);
        $overview = $data['overview'] ?? null;
        $growth   = $data['growth'] ?? null;

        if (! $overview) {
            return [
                Stat::make('Chưa có dữ liệu', 'Chạy: php artisan analytics:run')
                    ->description('Analytics chưa được khởi tạo')
                    ->color('warning'),
            ];
        }

        $growthPct   = $growth['revenue_growth_pct'] ?? 0;
        $growthIcon  = $growthPct >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $growthColor = $growthPct >= 0 ? 'success' : 'danger';
        $growthSign  = $growthPct >= 0 ? '+' : '';

        return [
            Stat::make('Tổng doanh thu', number_format($overview['total_revenue'], 0, ',', '.') . '₫')
                ->description("{$growthSign}{$growthPct}% so với tháng trước")
                ->descriptionIcon($growthIcon)
                ->color($growthColor),

            Stat::make('Tổng đơn hàng', number_format($overview['total_orders'], 0, ',', '.'))
                ->description('Đơn chờ xử lý: ' . $overview['pending_orders'])
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),

            Stat::make('Giá trị đơn TB', number_format($overview['avg_order_value'], 0, ',', '.') . '₫')
                ->description('Tháng này: ' . number_format($growth['this_month_revenue'] ?? 0, 0, ',', '.') . '₫')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('info'),

            Stat::make('Người dùng', number_format($overview['total_users'], 0, ',', '.'))
                ->description('Sản phẩm active: ' . $overview['active_products'])
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}
