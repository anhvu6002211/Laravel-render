<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CellphoneSSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = env('CELLPHONES_JSON_PATH', '/home/vu/caof sanr pham/cellphones_full_data.json');

        if (is_string($jsonPath) && file_exists($jsonPath)) {
            $payload = json_decode(file_get_contents($jsonPath), true);

            if (!is_array($payload)) {
                throw new \RuntimeException('File JSON khong hop le: ' . $jsonPath);
            }

            foreach ($payload as $group => $items) {
                if (!is_array($items)) {
                    continue;
                }

                $categoryName = $this->normalizeCategoryName((string) $group);
                $category = Category::firstOrCreate(['name' => $categoryName]);

                foreach ($items as $item) {
                    if (!is_array($item)) {
                        continue;
                    }

                    $name = trim((string) ($item['name'] ?? ''));
                    if ($name === '') {
                        continue;
                    }

                    $price = $this->parsePrice($item['price'] ?? '');
                    $image = $item['image'] ?? null;
                    $link = $item['link'] ?? null;
                    $description = $item['description'] ?? null;

                    if (!$description) {
                        $description = $link
                            ? "Nguon tham khao: {$link}"
                            : 'San pham chinh hang tu CellphoneS.';
                    }

                    Product::updateOrCreate(
                        ['name' => $name],
                        [
                            'description' => $description,
                            'image' => $image,
                            'price' => $price,
                            'stock' => 50,
                            'view' => rand(50, 1200),
                            'is_active' => true,
                            'category_id' => $category->id,
                        ]
                    );
                }
            }

            return;
        }

        $categories = Category::all()->pluck('id', 'name');

        $products = [
            [
                "name" => "iPhone 16 Pro Max 256GB | Chính hãng",
                "price" => 34990000,
                "image" => "https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/iphone-16-pro-max_1.png",
                "description" => "Màn hình LTPO Super Retina XDR OLED, Chip A18 Pro mạnh mẽ bậc nhất.",
                "category" => "Điện thoại"
            ],
            [
                "name" => "Samsung Galaxy S24 Ultra 12GB 256GB",
                "price" => 29490000,
                "image" => "https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/s/s/ss-s24-ultra-xam-222.png",
                "description" => "Quyền năng Galaxy AI, Camera 200MP, khung viền Titan sang trọng.",
                "category" => "Điện thoại"
            ],
            [
                "name" => "Laptop ASUS Vivobook S 14 FLIP TP3402VA",
                "price" => 20690000,
                "image" => "https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/l/a/laptop_asus_vivobook_s_14_flip_tp3402va-lz632w_-_1.png",
                "description" => "Màn hình cảm ứng xoay gập 360 độ, hiệu năng mạnh mẽ cho mọi tác vụ.",
                "category" => "Laptop"
            ],
            [
                "name" => "iPad Pro M4 11 inch Wifi 256GB",
                "price" => 28190000,
                "image" => "https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/ipad-pro-m4-11-inch-5g_1__3.png",
                "description" => "Siêu mỏng, siêu mạnh với chip M4 và màn hình Tandem OLED đỉnh cao.",
                "category" => "Máy tính bảng"
            ],
            [
                "name" => "Sony WH-1000XM5 - Chống ồn đỉnh cao",
                "price" => 6490000,
                "image" => "https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/t/a/tai-nghe-chup-tai-sony-wh-1000xm5.png",
                "description" => "Chống ồn tốt nhất thế giới, chất lượng cuộc gọi vượt trội.",
                "category" => "Tai nghe & Loa"
            ],
            [
                "name" => "Apple AirPods 4 | Chính hãng",
                "price" => 3490000,
                "image" => "https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/a/p/apple-airpods-4_1.png",
                "description" => "Thiết kế mới, âm thanh sống động với chip H2 mạnh mẽ.",
                "category" => "Tai nghe & Loa"
            ],
            [
                "name" => "Huawei Watch Fit 3 - AMOLED",
                "price" => 2790000,
                "image" => "https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/_/n/_ng_h_th_ng_minh_huawei_watch_fit_3_-_1_2_1_1_1.png",
                "description" => "Kiểu dáng thời trang, theo dõi sức khỏe chuyên sâu, pin bền bỉ.",
                "category" => "Đồng hồ thông minh"
            ],
            [
                "name" => "Amazfit Active - GPS đa hệ",
                "price" => 2890000,
                "image" => "https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/_/n/_ng_h_th_ng_minh_amazfit_active_-_1_1_2.png",
                "description" => "Huấn luyện viên AI, GPS chính xác, hỗ trợ cuộc gọi Bluetooth.",
                "category" => "Đồng hồ thông minh"
            ],
            [
                "name" => "Bút cảm ứng Apple Pencil Pro",
                "price" => 3490000,
                "image" => "https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/a/p/apple-pencil-pro-1.png",
                "description" => "Tính năng bóp, xoay thân bút và phản hồi rung cực nhạy.",
                "category" => "Phụ kiện"
            ],
            [
                "name" => "Chuột Logitech MX Master 3S",
                "price" => 2190000,
                "image" => "https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/c/h/chuot-khong-day-logitech-mx-master-3s.png",
                "description" => "Cảm biến 8K DPI, cuộn MagSpeed siêu nhanh và yên tĩnh.",
                "category" => "Phụ kiện"
            ]
        ];

        foreach ($products as $p) {
            Product::create([
                'name'        => $p['name'],
                'description' => $p['description'],
                'image'       => $p['image'],
                'price'       => $p['price'],
                'stock'       => 50,
                'view'        => rand(100, 2000),
                'category_id' => $categories[$p['category']] ?? $categories->first(),
            ]);
        }
    }

    private function parsePrice(string $raw): int
    {
        $digits = preg_replace('/\D+/', '', $raw);
        return $digits === '' ? 0 : (int) $digits;
    }

    private function normalizeCategoryName(string $key): string
    {
        $clean = str_replace(['-', '_'], ' ', trim($key));
        return Str::title($clean);
    }
}
