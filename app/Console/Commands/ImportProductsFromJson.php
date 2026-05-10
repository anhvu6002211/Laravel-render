<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImportProductsFromJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-products {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from a JSON file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');

        if (!File::exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        $jsonContent = File::get($filePath);
        $data = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error("Invalid JSON format: " . json_last_error_msg());
            return 1;
        }

        $this->info("Starting import...");

        foreach ($data as $categoryName => $products) {
            $this->info("Importing category: {$categoryName}");

            $category = Category::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => ucfirst($categoryName), 'is_active' => true]
            );

            foreach ($products as $productData) {
                if (empty($productData['name'])) {
                    continue;
                }

                // Clean price: "37.590.000đ" -> 37590000
                $priceString = $productData['price'] ?? '0';
                $price = (float) str_replace(['.', 'đ', '₫', ' '], '', $priceString);

                $product = Product::updateOrCreate(
                    ['slug' => Str::slug($productData['name'])],
                    [
                        'name' => $productData['name'],
                        'image' => $productData['image'] ?? null,
                        'price' => $price,
                        'category_id' => $category->id,
                        'stock' => rand(10, 100),
                        'is_active' => true,
                        'description' => "Link gốc: " . ($productData['link'] ?? 'N/A'),
                    ]
                );

                $this->line("  - Imported: {$product->name}");
            }
        }

        $this->info("Import completed successfully!");
        return 0;
    }
}
