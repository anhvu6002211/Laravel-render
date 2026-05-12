# Vuxshop - E-commerce System (Laravel & MySQL)

Vuxshop là một hệ thống thương mại điện tử hiện đại, được xây dựng trên nền tảng Laravel, tập trung vào việc tối ưu hóa hiệu suất và quản lý dữ liệu lớn từ các nguồn bên ngoài (CellphoneS).

## 🚀 Bài toán & Mục tiêu
Dự án được thiết kế để giải quyết các vấn đề:
- **Di chuyển dữ liệu (Migration)**: Chuyển đổi hệ thống từ SQLite (Legacy) sang MySQL/TiDB Cloud để tăng khả năng mở rộng và độ tin cậy.
- **Tự động hóa dữ liệu**: Phát triển công cụ nạp dữ liệu (Scraping) từ các trang bán lẻ lớn như CellphoneS trực tiếp vào database.
- **Triển khai Cloud**: Vận hành ổn định trên nền tảng Render với cấu hình SSL bảo mật cho cơ sở dữ liệu đám mây.

## 🛠 Công nghệ sử dụng
- **Backend**: Laravel 11.x
- **Admin Panel**: Filament PHP (Quản lý sản phẩm, đơn hàng, người dùng chuyên nghiệp).
- **Database**: 
  - Local: MySQL (XAMPP).
  - Production: TiDB Cloud (Cơ sở dữ liệu phân tán tương thích hoàn toàn với MySQL).
- **Deployment**: Render (Web Service).
- **Media**: Spatie Media Library (Quản lý ảnh và tài liệu).

## 📂 Cấu trúc dự án
```text
vuxshop/
├── app/
│   ├── Console/Commands/      <-- Công cụ nạp dữ liệu (ImportScrapedData.php)
│   ├── Models/                <-- Thực thể (Product, Category, Order, User)
│   └── Providers/             <-- Cấu hình hệ thống (Force HTTPS)
├── config/
│   └── database.php           <-- Cấu hình kết nối MySQL & SSL cho TiDB
├── database/
│   ├── migrations/            <-- Lịch sử phiên bản database
│   └── seeders/               <-- Dữ liệu khởi tạo & Dữ liệu mẫu
├── resources/
│   └── views/                 <-- Giao diện người dùng (Blade templates)
├── routes/
│   └── web.php                <-- Quản lý đường dẫn (URL)
└── .env                       <-- Cấu hình biến môi trường
```

## ⚙️ Cài đặt & Chạy dự án
1. **Clone dự án**: `git clone <repo-url>`
2. **Cấu hình môi trường**: Sao chép `.env.example` thành `.env` và điền thông số kết nối TiDB Cloud.
3. **Cài đặt thư viện**: `composer install` & `npm install`
4. **Khởi tạo Database**:
   ```bash
   php artisan migrate --seed --force
   ```
5. **Nạp dữ liệu CellphoneS**:
   ```bash
   php artisan import:scraped-data "/path/to/cellphones_full_data.json"
   ```

## 🌐 Thông tin vận hành
- **Website**: [https://vuxshop.onrender.com/](https://vuxshop.onrender.com/)
- **Admin Dashboard**: [https://vuxshop.onrender.com/admin](https://vuxshop.onrender.com/admin)
- **Tài khoản Admin mẫu**: `admin@eshop.vn` / `password`
mk:your_password_here
admin@eshop.vn
password
