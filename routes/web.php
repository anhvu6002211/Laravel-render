<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SitemapController;

// ─── Public Routes ───────────────────────────────────────────────────────────

Route::get('/', [HomeController::class, 'index'])->name('home');

// ─── Static Informational Pages ──────────────────────────────────────────────
Route::get('/gioi-thieu', [\App\Http\Controllers\PageController::class, 'about'])->name('pages.about');
Route::get('/lien-he', [\App\Http\Controllers\PageController::class, 'contact'])->name('pages.contact');
Route::get('/chinh-sach-bao-hanh', [\App\Http\Controllers\PageController::class, 'warranty'])->name('pages.warranty');
Route::get('/chinh-sach-doi-tra', [\App\Http\Controllers\PageController::class, 'returns'])->name('pages.returns');
Route::get('/chinh-sach-giao-hang', [\App\Http\Controllers\PageController::class, 'shipping'])->name('pages.shipping');

// Shop (danh mục)
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// Tìm kiếm
Route::get('/search', [ShopController::class, 'search'])->name('shop.search');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Chi tiết sản phẩm
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── Protected Routes ─────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/orders/{id}', [\App\Http\Controllers\ProfileController::class, 'showOrder'])->name('profile.orders.show');
});

// ─── Admin Routes (Handled by Filament) ──────────────────────────────────
// Filament tự động quản lý tất cả routes /admin/*
// Đăng nhập admin: http://localhost:8001/admin/login
// Tài khoản: admin@eshop.vn / password
