<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email'    => 'admin@eshop.vn'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // Demo customer
        User::firstOrCreate(
            ['email'    => 'khach@eshop.vn'],
            [
                'name'     => 'Khách hàng',
                'password' => Hash::make('password'),
                'role'     => 'customer',
            ]
        );

        // Categories (slug tự động tạo từ Model)
        $categories = [
            ['name' => 'Điện thoại'],
            ['name' => 'Laptop'],
            ['name' => 'Máy tính bảng'],
            ['name' => 'Tai nghe & Loa'],
            ['name' => 'Đồng hồ thông minh'],
            ['name' => 'Phụ kiện'],
        ];

        $catIds = [];
        foreach ($categories as $cat) {
            $created = Category::firstOrCreate(['name' => $cat['name']], $cat);
            $catIds[$cat['name']] = $created->id;
        }

        // Products (slug tự động tạo từ Model)
        $products = [
            // Điện thoại
            ['name' => 'iPhone 15 Pro Max', 'description' => 'Chip A17 Pro mạnh mẽ, camera 48MP, màn hình Super Retina XDR 6.7 inch. Thiết kế titan sang trọng.', 'price' => 29990000, 'stock' => 50, 'view' => 1200, 'category' => 'Điện thoại', 'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&q=80'],
            ['name' => 'Samsung Galaxy S24 Ultra', 'description' => 'Màn hình Dynamic AMOLED 2X 6.8 inch, chip Snapdragon 8 Gen 3, bút S Pen tích hợp.', 'price' => 26990000, 'stock' => 40, 'view' => 980, 'category' => 'Điện thoại', 'image' => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=600&q=80'],
            ['name' => 'Xiaomi 14 Pro', 'description' => 'Camera Leica chuyên nghiệp, chip Snapdragon 8 Gen 3, sạc siêu nhanh 120W.', 'price' => 19990000, 'stock' => 35, 'view' => 750, 'category' => 'Điện thoại', 'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&q=80'],

            // Laptop
            ['name' => 'MacBook Pro 16 M3 Max', 'description' => 'Chip M3 Max đột phá, màn hình Liquid Retina XDR, thời lượng pin 22 giờ, RAM 36GB.', 'price' => 89990000, 'stock' => 20, 'view' => 2100, 'category' => 'Laptop', 'image' => 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=600&q=80'],
            ['name' => 'Dell XPS 15', 'description' => 'Màn hình OLED 3.5K, Intel Core i9, GPU NVIDIA RTX 4070, thiết kế siêu mỏng premium.', 'price' => 52990000, 'stock' => 15, 'view' => 890, 'category' => 'Laptop', 'image' => 'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=600&q=80'],
            ['name' => 'ASUS ROG Zephyrus G14', 'description' => 'Laptop gaming AMD Ryzen 9, RTX 4060, màn hình 165Hz, tản nhiệt vượt trội.', 'price' => 34990000, 'stock' => 25, 'view' => 650, 'category' => 'Laptop', 'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=600&q=80'],

            // Máy tính bảng
            ['name' => 'iPad Pro M4 13"', 'description' => 'Màn hình Ultra Retina XDR OLED siêu mỏng, chip M4, hỗ trợ Apple Pencil Pro và Magic Keyboard.', 'price' => 38990000, 'stock' => 30, 'view' => 820, 'category' => 'Máy tính bảng', 'image' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=600&q=80'],
            ['name' => 'Samsung Galaxy Tab S9+', 'description' => 'Màn hình Super AMOLED 12.4 inch, chip Snapdragon 8 Gen 2, kháng nước IP68, kèm S Pen.', 'price' => 22990000, 'stock' => 20, 'view' => 560, 'category' => 'Máy tính bảng', 'image' => 'https://images.unsplash.com/photo-1561154464-82e9adf32764?w=600&q=80'],

            // Tai nghe & Loa
            ['name' => 'Sony WH-1000XM5', 'description' => 'Tai nghe chống ồn chủ động hàng đầu thế giới, âm thanh Hi-Res, 30 giờ phát nhạc.', 'price' => 8490000, 'stock' => 60, 'view' => 1500, 'category' => 'Tai nghe & Loa', 'image' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=600&q=80'],
            ['name' => 'AirPods Pro 2', 'description' => 'Chống ồn ANC thế hệ 2, chip H2, âm thanh không gian, chống nước IPX4.', 'price' => 6490000, 'stock' => 100, 'view' => 2200, 'category' => 'Tai nghe & Loa', 'image' => 'https://images.unsplash.com/photo-1606841837239-c5a1a4a07af7?w=600&q=80'],

            // Đồng hồ thông minh
            ['name' => 'Apple Watch Series 9', 'description' => 'Màn hình Always-On Retina sáng hơn, chip S9, cử chỉ Double Tap mới, đo oxy máu.', 'price' => 10990000, 'stock' => 45, 'view' => 1100, 'category' => 'Đồng hồ thông minh', 'image' => 'https://images.unsplash.com/photo-1434493789847-2f02dc6ca35d?w=600&q=80'],
            ['name' => 'Samsung Galaxy Watch 6 Classic', 'description' => 'Vòng bezel xoay cơ học lịch lãm, màn hình AMOLED, theo dõi sức khỏe toàn diện.', 'price' => 8990000, 'stock' => 35, 'view' => 780, 'category' => 'Đồng hồ thông minh', 'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&q=80'],

            // Phụ kiện
            ['name' => 'Sạc nhanh GaN 100W', 'description' => 'Công nghệ GaN thế hệ mới, sạc 4 thiết bị cùng lúc, tương thích USB-C PD và USB-A QC.', 'price' => 890000, 'stock' => 200, 'view' => 450, 'category' => 'Phụ kiện', 'image' => 'https://images.unsplash.com/photo-1591370874773-6702e8f12fd8?w=600&q=80'],
            ['name' => 'Bàn phím cơ Keychron K8 Pro', 'description' => 'Switch Gateron G Pro, hot-swap, đèn RGB, kết nối Bluetooth 5.1 hoặc USB-C.', 'price' => 2290000, 'stock' => 80, 'view' => 320, 'category' => 'Phụ kiện', 'image' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600&q=80'],
        ];

        foreach ($products as $p) {
            Product::firstOrCreate(
                ['name' => $p['name']],
                [
                    'description' => $p['description'],
                    'image'       => $p['image'],
                    'price'       => $p['price'],
                    'stock'       => $p['stock'],
                    'view'        => $p['view'],
                    'category_id' => $catIds[$p['category']],
                ]
            );
        }

        // Gọi các seeder bổ sung
        $this->call([
            ExtraProductsSeeder::class,
            SampleOrdersSeeder::class,
        ]);
    }
}
