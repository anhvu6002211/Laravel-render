<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MigrateImagesToMediaLibrary extends Command
{
    protected $signature = 'app:migrate-images {--limit=0 : Limit number of products to process (0 = all)}';
    protected $description = 'Download product images from URLs and attach to Spatie Media Library';

    public function handle()
    {
        $limit = (int) $this->option('limit');

        // Get products that have an image URL but no media attached
        $query = Product::whereNotNull('image')
            ->where('image', '!=', '')
            ->whereDoesntHave('media');

        if ($limit > 0) {
            $query->limit($limit);
        }

        $products = $query->get();

        if ($products->isEmpty()) {
            $this->info('No products need image migration.');
            return 0;
        }

        $this->info("Found {$products->count()} products to migrate images for.");
        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        $success = 0;
        $failed = 0;

        foreach ($products as $product) {
            try {
                $imageUrl = $product->image;

                // Skip non-URL values
                if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                    $bar->advance();
                    continue;
                }

                // Download image with timeout
                $response = Http::timeout(15)
                    ->withOptions(['verify' => false])
                    ->get($imageUrl);

                if (!$response->successful()) {
                    $this->line("\n  ✗ Failed to download: {$product->name} (HTTP {$response->status()})");
                    $failed++;
                    $bar->advance();
                    continue;
                }

                // Determine filename from URL
                $urlPath = parse_url($imageUrl, PHP_URL_PATH);
                $filename = basename($urlPath) ?: 'product_' . $product->id . '.jpg';

                // Ensure valid extension
                if (!preg_match('/\.(jpg|jpeg|png|webp|gif)$/i', $filename)) {
                    $filename .= '.jpg';
                }

                // Save to temp file
                $tempPath = storage_path('app/temp/' . $filename);
                if (!is_dir(dirname($tempPath))) {
                    mkdir(dirname($tempPath), 0755, true);
                }
                file_put_contents($tempPath, $response->body());

                // Add to Media Library
                $product->addMedia($tempPath)
                    ->toMediaCollection('image');

                $success++;
            } catch (\Exception $e) {
                $this->line("\n  ✗ Error for '{$product->name}': {$e->getMessage()}");
                $failed++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Migration complete! ✓ {$success} succeeded, ✗ {$failed} failed.");

        return 0;
    }
}
