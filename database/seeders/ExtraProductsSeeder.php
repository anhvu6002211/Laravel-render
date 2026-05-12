<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ExtraProductsSeeder extends Seeder
{
    public function run(): void
    {
        $categoryMap = [
            'dien-thoai' => 'Dien thoai',
            'laptop' => 'Laptop',
            'may-tinh-bang' => 'May tinh bang',
            'tai-nghe-loa' => 'Tai nghe & Loa',
            'dong-ho-thong-minh' => 'Dong ho thong minh',
            'phu-kien' => 'Phu kien',
        ];

        $categoryIds = [];
        foreach ($categoryMap as $slug => $name) {
            $category = Category::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'is_active' => true]
            );
            $categoryIds[$slug] = $category->id;
        }

        $products = [
            [
                'name' => 'iPhone 15 Plus 128GB',
                'description' => 'Large display, fast performance, and all-day battery life.',
                'price' => 21990000,
                'stock' => 18,
                'view' => 420,
                'category_slug' => 'dien-thoai',
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&q=80',
            ],
            [
                'name' => 'Google Pixel 8 Pro',
                'description' => 'Flagship camera system with AI-powered photo tools.',
                'price' => 24990000,
                'stock' => 12,
                'view' => 530,
                'category_slug' => 'dien-thoai',
                'image' => 'https://images.unsplash.com/photo-1510557880182-3d4d3c6a5c97?w=600&q=80',
            ],
            [
                'name' => 'OPPO Find X7 Ultra',
                'description' => 'Premium design with fast charging and a bright AMOLED display.',
                'price' => 18990000,
                'stock' => 9,
                'view' => 380,
                'category_slug' => 'dien-thoai',
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&q=80',
            ],
            [
                'name' => 'OnePlus 12',
                'description' => 'Smooth performance with a high-refresh-rate display.',
                'price' => 17990000,
                'stock' => 14,
                'view' => 410,
                'category_slug' => 'dien-thoai',
                'image' => 'https://images.unsplash.com/photo-1510557880182-3d4d3c6a5c97?w=600&q=80',
            ],
            [
                'name' => 'Lenovo ThinkPad X1 Carbon Gen 12',
                'description' => 'Lightweight business laptop with excellent keyboard and battery.',
                'price' => 48990000,
                'stock' => 7,
                'view' => 260,
                'category_slug' => 'laptop',
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&q=80',
            ],
            [
                'name' => 'HP Spectre x360 14',
                'description' => 'Convertible laptop with OLED display and premium build.',
                'price' => 39990000,
                'stock' => 11,
                'view' => 310,
                'category_slug' => 'laptop',
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=600&q=80',
            ],
            [
                'name' => 'Acer Swift Go 14',
                'description' => 'Portable laptop for everyday work and study.',
                'price' => 18990000,
                'stock' => 22,
                'view' => 190,
                'category_slug' => 'laptop',
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&q=80',
            ],
            [
                'name' => 'MSI Prestige 14 Evo',
                'description' => 'Slim creator laptop with strong performance and color-accurate display.',
                'price' => 23990000,
                'stock' => 6,
                'view' => 175,
                'category_slug' => 'laptop',
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=600&q=80',
            ],
            [
                'name' => 'iPad Air M2 11',
                'description' => 'Powerful tablet for productivity and entertainment.',
                'price' => 18990000,
                'stock' => 16,
                'view' => 240,
                'category_slug' => 'may-tinh-bang',
                'image' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=600&q=80',
            ],
            [
                'name' => 'Lenovo Tab P12',
                'description' => 'Large display tablet with quad speakers for media.',
                'price' => 10990000,
                'stock' => 8,
                'view' => 160,
                'category_slug' => 'may-tinh-bang',
                'image' => 'https://images.unsplash.com/photo-1512418490979-92798cec1380?w=600&q=80',
            ],
            [
                'name' => 'Xiaomi Pad 6S Pro',
                'description' => 'High-performance tablet with smooth stylus support.',
                'price' => 14990000,
                'stock' => 13,
                'view' => 220,
                'category_slug' => 'may-tinh-bang',
                'image' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=600&q=80',
            ],
            [
                'name' => 'Sony WF-1000XM5',
                'description' => 'Industry-leading noise canceling in a compact design.',
                'price' => 6290000,
                'stock' => 9,
                'view' => 440,
                'category_slug' => 'tai-nghe-loa',
                'image' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=600&q=80',
            ],
            [
                'name' => 'Bose QuietComfort Ultra Earbuds',
                'description' => 'Deep bass with premium comfort and call quality.',
                'price' => 7990000,
                'stock' => 10,
                'view' => 330,
                'category_slug' => 'tai-nghe-loa',
                'image' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=600&q=80',
            ],
            [
                'name' => 'JBL Charge 5',
                'description' => 'Portable speaker with punchy sound and long battery.',
                'price' => 3790000,
                'stock' => 15,
                'view' => 290,
                'category_slug' => 'tai-nghe-loa',
                'image' => 'https://images.unsplash.com/photo-1519671482749-fd09be7ccebf?w=600&q=80',
            ],
            [
                'name' => 'Marshall Emberton II',
                'description' => 'Classic design with balanced sound and rugged build.',
                'price' => 3390000,
                'stock' => 5,
                'view' => 210,
                'category_slug' => 'tai-nghe-loa',
                'image' => 'https://images.unsplash.com/photo-1519671482749-fd09be7ccebf?w=600&q=80',
            ],
            [
                'name' => 'Garmin Venu 3',
                'description' => 'Health tracking with AMOLED display and long battery life.',
                'price' => 9990000,
                'stock' => 8,
                'view' => 260,
                'category_slug' => 'dong-ho-thong-minh',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&q=80',
            ],
            [
                'name' => 'Xiaomi Watch 2 Pro',
                'description' => 'Wear OS smartwatch with GPS and fitness tracking.',
                'price' => 5490000,
                'stock' => 14,
                'view' => 200,
                'category_slug' => 'dong-ho-thong-minh',
                'image' => 'https://images.unsplash.com/photo-1503602642458-232111445657?w=600&q=80',
            ],
            [
                'name' => 'Amazfit Balance',
                'description' => 'Lightweight smartwatch with multi-sport modes.',
                'price' => 4590000,
                'stock' => 6,
                'view' => 180,
                'category_slug' => 'dong-ho-thong-minh',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&q=80',
            ],
            [
                'name' => 'Anker 737 Power Bank 24000mAh',
                'description' => 'High-capacity power bank with fast charging.',
                'price' => 2990000,
                'stock' => 20,
                'view' => 310,
                'category_slug' => 'phu-kien',
                'image' => 'https://images.unsplash.com/photo-1591370874773-6702e8f12fd8?w=600&q=80',
            ],
            [
                'name' => 'Logitech MX Keys Mini',
                'description' => 'Compact wireless keyboard with backlit keys.',
                'price' => 2490000,
                'stock' => 17,
                'view' => 240,
                'category_slug' => 'phu-kien',
                'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600&q=80',
            ],
            [
                'name' => 'Samsung T7 Shield 1TB',
                'description' => 'Rugged portable SSD with fast USB-C speeds.',
                'price' => 2290000,
                'stock' => 9,
                'view' => 200,
                'category_slug' => 'phu-kien',
                'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=600&q=80',
            ],
            [
                'name' => 'UGREEN GaN 65W Charger',
                'description' => 'Compact multi-port charger for phone and laptop.',
                'price' => 790000,
                'stock' => 25,
                'view' => 150,
                'category_slug' => 'phu-kien',
                'image' => 'https://images.unsplash.com/photo-1591370874773-6702e8f12fd8?w=600&q=80',
            ],
        ];

        foreach ($products as $product) {
            $slug = Str::slug($product['name']);
            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'image' => $product['image'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'view' => $product['view'],
                    'is_active' => true,
                    'category_id' => $categoryIds[$product['category_slug']],
                ]
            );
        }
    }
}
