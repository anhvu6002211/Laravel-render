<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RunAnalytics extends Command
{
    protected $signature   = 'analytics:run {--force : Bỏ qua cache, chạy lại}';
    protected $description = 'Chạy Python analytics script và cache kết quả';

    public function handle(): int
    {
        if ($this->option('force')) {
            Cache::forget('analytics_data');
        }

        $this->info('Đang chạy analytics (MySQL/DB)...');

        $totalOrders = (int) DB::table('orders')->count();
        $totalRevenue = (float) DB::table('orders')
            ->where('status', '!=', 'cancelled')
            ->sum('total_price');
        $pendingOrders = (int) DB::table('orders')->where('status', 'pending')->count();
        $activeProducts = (int) DB::table('products')->where('is_active', 1)->count();
        $totalUsers = (int) DB::table('users')->count();

        $overview = [
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'pending_orders' => $pendingOrders,
            'active_products' => $activeProducts,
            'total_users' => $totalUsers,
            'avg_order_value' => $totalOrders > 0 ? round($totalRevenue / $totalOrders, 0) : 0,
        ];

        $startDate = now()->subDays(29)->startOfDay();
        $rows = DB::table('orders')
            ->selectRaw('DATE(created_at) as day, SUM(total_price) as revenue, COUNT(*) as orders')
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', $startDate)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $revenueByDay = [];
        foreach ($rows as $row) {
            $revenueByDay[$row->day] = [
                'revenue' => (float) ($row->revenue ?? 0),
                'orders' => (int) ($row->orders ?? 0),
            ];
        }

        $dailyRevenue = [];
        for ($i = 0; $i < 30; $i++) {
            $day = now()->subDays(29 - $i)->format('Y-m-d');
            $dailyRevenue[] = [
                'date' => $day,
                'revenue' => $revenueByDay[$day]['revenue'] ?? 0,
                'orders' => $revenueByDay[$day]['orders'] ?? 0,
            ];
        }

        $topProducts = DB::table('order_items as oi')
            ->join('products as p', 'p.id', '=', 'oi.product_id')
            ->join('orders as o', 'o.id', '=', 'oi.order_id')
            ->where('o.status', '!=', 'cancelled')
            ->selectRaw('p.name, p.price, SUM(oi.quantity) as total_sold, SUM(oi.quantity * oi.price) as revenue')
            ->groupBy('oi.product_id', 'p.name', 'p.price')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get()
            ->map(fn ($row) => [
                'name' => $row->name,
                'price' => (float) $row->price,
                'total_sold' => (int) $row->total_sold,
                'revenue' => (float) $row->revenue,
            ])
            ->values()
            ->all();

        $orderStatus = DB::table('orders')
            ->select('status', DB::raw('COUNT(*) as cnt'))
            ->groupBy('status')
            ->orderByDesc('cnt')
            ->get()
            ->map(fn ($row) => ['status' => $row->status, 'count' => (int) $row->cnt])
            ->values()
            ->all();

        $revenueByCategory = DB::table('order_items as oi')
            ->join('products as p', 'p.id', '=', 'oi.product_id')
            ->join('categories as c', 'c.id', '=', 'p.category_id')
            ->join('orders as o', 'o.id', '=', 'oi.order_id')
            ->where('o.status', '!=', 'cancelled')
            ->selectRaw('c.name as category, SUM(oi.quantity * oi.price) as revenue, SUM(oi.quantity) as units')
            ->groupBy('c.id', 'c.name')
            ->orderByDesc('revenue')
            ->get()
            ->map(fn ($row) => [
                'category' => $row->category,
                'revenue' => (float) $row->revenue,
                'units' => (int) $row->units,
            ])
            ->values()
            ->all();

        $lowStock = DB::table('products')
            ->select('name', 'stock', 'price')
            ->where('is_active', 1)
            ->where('stock', '<', 10)
            ->orderBy('stock')
            ->limit(10)
            ->get()
            ->map(fn ($row) => [
                'name' => $row->name,
                'stock' => (int) $row->stock,
                'price' => (float) $row->price,
            ])
            ->values()
            ->all();

        $startThisMonth = now()->startOfMonth();
        $startLastMonth = now()->subMonthNoOverflow()->startOfMonth();
        $endLastMonth = $startThisMonth->copy()->subSecond();

        $thisMonthRevenue = (float) DB::table('orders')
            ->where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$startThisMonth, now()])
            ->sum('total_price');
        $lastMonthRevenue = (float) DB::table('orders')
            ->where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$startLastMonth, $endLastMonth])
            ->sum('total_price');

        $ordersThisMonth = (int) DB::table('orders')
            ->where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$startThisMonth, now()])
            ->count();
        $ordersLastMonth = (int) DB::table('orders')
            ->where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$startLastMonth, $endLastMonth])
            ->count();

        $growthPct = $lastMonthRevenue > 0
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : 0;

        $growth = [
            'this_month_revenue' => $thisMonthRevenue,
            'last_month_revenue' => $lastMonthRevenue,
            'revenue_growth_pct' => $growthPct,
            'orders_this_month' => $ordersThisMonth,
            'orders_last_month' => $ordersLastMonth,
        ];

        $data = [
            'overview' => $overview,
            'daily_revenue' => $dailyRevenue,
            'top_products' => $topProducts,
            'order_status' => $orderStatus,
            'revenue_by_category' => $revenueByCategory,
            'low_stock' => $lowStock,
            'growth' => $growth,
            'generated_at' => now()->toIso8601String(),
        ];

        // Cache 10 phút
        Cache::put('analytics_data', $data, now()->addMinutes(10));

        $this->info('✅ Analytics hoàn tất! Đã cache 10 phút.');
        $this->table(
            ['Chỉ số', 'Giá trị'],
            [
                ['Tổng đơn hàng', $data['overview']['total_orders'] ?? 0],
                ['Doanh thu', number_format($data['overview']['total_revenue'] ?? 0, 0, ',', '.') . '₫'],
                ['Đơn chờ xử lý', $data['overview']['pending_orders'] ?? 0],
                ['Sản phẩm active', $data['overview']['active_products'] ?? 0],
            ]
        );

        return self::SUCCESS;
    }
}
