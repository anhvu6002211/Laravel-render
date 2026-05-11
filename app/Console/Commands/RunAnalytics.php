<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class RunAnalytics extends Command
{
    protected $signature   = 'analytics:run {--force : Bỏ qua cache, chạy lại}';
    protected $description = 'Chạy Python analytics script và cache kết quả';

    public function handle(): int
    {
        $dbPath     = database_path('database.sqlite');
        $scriptPath = base_path('scripts/analytics.py');
        $python     = config('analytics.python_bin', 'python3');

        if (! file_exists($dbPath)) {
            $this->error("SQLite file không tồn tại: {$dbPath}");
            return self::FAILURE;
        }

        if (! file_exists($scriptPath)) {
            $this->error("Analytics script không tồn tại: {$scriptPath}");
            return self::FAILURE;
        }

        if ($this->option('force')) {
            Cache::forget('analytics_data');
        }

        $this->info('Đang chạy Python analytics...');

        $escaped = escapeshellarg($dbPath);
        $output  = shell_exec("{$python} {$scriptPath} {$escaped} 2>&1");

        if (! $output) {
            $this->error('Python script không trả về kết quả.');
            return self::FAILURE;
        }

        $data = json_decode($output, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Kết quả Python không phải JSON hợp lệ:');
            $this->line($output);
            return self::FAILURE;
        }

        if (isset($data['error'])) {
            $this->error('Analytics error: ' . $data['error']);
            return self::FAILURE;
        }

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
