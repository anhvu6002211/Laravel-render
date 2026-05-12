<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ImportScrapedData extends Command
{
    protected $signature = 'import:scraped-data {file}';
    protected $description = 'Import product data from a scraped JSON file';

    public function handle()
    {
        $filePath = $this->argument('file');
        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return;
        }

        $jsonData = json_decode(file_get_contents($filePath), true);
        if (!$jsonData) {
            $this->error("Invalid JSON format.");
            return;
        }

        foreach ($jsonData as $categoryName => $products) {
            $this->info("Importing category: {$categoryName}");

            $category = Category::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => ucfirst($categoryName), 'is_active' => true]
            );

            foreach ($products as $item) {
                // Clean price: "37.590.000đ" -> 37590000
                $price = (int) str_replace(['.', 'đ', ' '], '', $item['price'] ?? '0');
                
                if (empty($item['name'])) continue;

                Product::updateOrCreate(
                    ['slug' => Str::slug($item['name'])],
                    [
                        'name' => $item['name'],
                        'description' => "Sản phẩm chính hãng từ CellphoneS. Xem thêm tại: " . ($item['link'] ?? '#'),
                        'price' => $price,
                        'image' => $item['image'] ?? null,
                        'category_id' => $category->id,
                        'stock' => rand(10, 50),
                        'is_active' => true,
                        'view' => rand(100, 2000),
                    ]
                );
            }
        }

        $this->info("Import completed successfully!");
    }
}
