# Mô tả Bài toán: Hệ thống Quản lý Bán hàng Trực tuyến (E-commerce)

## 1. Giới thiệu tổng quan
Dự án nhằm xây dựng một website bán hàng trực tuyến hiện đại, cho phép người dùng tìm kiếm, xem và mua các sản phẩm từ cửa hàng. Đồng thời, hệ thống cung cấp công cụ quản trị giúp chủ cửa hàng quản lý danh mục, sản phẩm và đơn hàng một cách hiệu quả.

## 2. Đối tượng sử dụng
*   **Khách hàng (Khách vãng lai & Thành viên):** Người xem sản phẩm, quản lý giỏ hàng và đặt hàng.
*   **Quản trị viên (Admin):** Người quản lý toàn bộ dữ liệu hệ thống (sản phẩm, đơn hàng, người dùng).

## 3. Các chức năng chính

### A. Phân hệ Khách hàng (Storefront)
1.  **Trang chủ & Danh mục:**
    *   Hiển thị các sản phẩm nổi bật, mới nhất.
    *   Phân loại sản phẩm theo danh mục (Category).
2.  **Tìm kiếm sản phẩm:**
    *   Tìm kiếm theo tên hoặc từ khóa liên quan.
3.  **Chi tiết sản phẩm:**
    *   Hiển thị thông tin chi tiết: hình ảnh, giá, mô tả, thông số kỹ thuật.
4.  **Giỏ hàng (Shopping Cart):**
    *   Thêm sản phẩm vào giỏ.
    *   Cập nhật số lượng hoặc xóa sản phẩm khỏi giỏ.
5.  **Đặt hàng & Thanh toán (Checkout):**
    *   Xác nhận thông tin giao hàng.
    *   Gửi đơn hàng vào hệ thống.
6.  **Tài khoản người dùng:**
    *   Đăng ký, đăng nhập.
    *   Xem lịch sử mua hàng (đang phát triển).

### B. Phân hệ Quản trị (Admin Dashboard)
1.  **Quản lý Sản phẩm:**
    *   Thêm mới, chỉnh sửa, xóa sản phẩm.
    *   Quản lý hình ảnh và giá cả.
2.  **Quản lý Danh mục:**
    *   Phân loại sản phẩm theo các nhóm hàng.
3.  **Quản lý Đơn hàng:**
    *   Theo dõi danh sách các đơn hàng đã đặt.
    *   Cập nhật trạng thái đơn hàng (đã thanh toán, đang giao, hoàn thành).

### C. Các trang thông tin bổ trợ
*   Giới thiệu (About us).
*   Liên hệ (Contact).
*   Chính sách bảo hành, đổi trả, giao hàng.

## 4. Cấu trúc dữ liệu chính (Database Schema)
Hệ thống sử dụng cơ sở dữ liệu quan hệ (SQLite) với các bảng chính:
*   `users`: Lưu trữ thông tin tài khoản (tên, email, mật khẩu, vai trò).
*   `categories`: Lưu trữ các danh mục sản phẩm.
*   `products`: Thông tin sản phẩm (tên, giá, mô tả, số lượng tồn kho, category_id).
*   `orders`: Thông tin đơn hàng (thông tin khách hàng, tổng tiền, trạng thái).
*   `order_details`: Chi tiết từng mặt hàng trong đơn hàng (sản phẩm, số lượng, đơn giá tại thời điểm mua).

## 5. Công nghệ sử dụng
*   **Backend:** Laravel Framework (PHP).
*   **Frontend:** Blade Template, TailwindCSS/Vanilla CSS, Vite.
*   **Database:** SQLite.
