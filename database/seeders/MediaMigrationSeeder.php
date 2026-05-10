<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MediaMigrationSeeder extends Seeder
{
    public function run(): void
    {
        // Migrate Products
        $products = Product::whereNotNull('image')->get();
        foreach ($products as $product) {
            try {
                if (filter_var($product->image, FILTER_VALIDATE_URL)) {
                    $product->addMediaFromUrl($product->image)
                        ->preservingOriginal()
                        ->toMediaCollection('image');
                    $this->command->info("Migrated URL image for product: {$product->name}");
                } else {
                    $imagePath = public_path('storage/' . $product->image);
                    if (file_exists($imagePath)) {
                        $product->addMedia($imagePath)
                            ->preservingOriginal()
                            ->toMediaCollection('image');
                        $this->command->info("Migrated local image for product: {$product->name}");
                    } else {
                        $this->command->warn("Image not found for product: {$product->name}");
                    }
                }
            } catch (\Exception $e) {
                $this->command->error("Failed to migrate image for product: {$product->name}. Error: {$e->getMessage()}");
            }
        }

        // Migrate Categories
        $categories = Category::whereNotNull('image')->get();
        foreach ($categories as $category) {
            try {
                if (filter_var($category->image, FILTER_VALIDATE_URL)) {
                    $category->addMediaFromUrl($category->image)
                        ->preservingOriginal()
                        ->toMediaCollection('image');
                    $this->command->info("Migrated URL image for category: {$category->name}");
                } else {
                    $imagePath = public_path('storage/' . $category->image);
                    if (file_exists($imagePath)) {
                        $category->addMedia($imagePath)
                            ->preservingOriginal()
                            ->toMediaCollection('image');
                        $this->command->info("Migrated local image for category: {$category->name}");
                    } else {
                        $this->command->warn("Image not found for category: {$category->name}");
                    }
                }
            } catch (\Exception $e) {
                $this->command->error("Failed to migrate image for category: {$category->name}. Error: {$e->getMessage()}");
            }
        }
    }
}
