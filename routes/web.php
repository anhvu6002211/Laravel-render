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

// Route kiểm tra kết nối Database
Route::get('/db-test', function () {
    try {
        \DB::connection()->getPdo();
        $driver = config('database.default');
        if ($driver === 'sqlite') {
            $tables = \DB::select("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
            $tableNames = array_column($tables, 'name');
        } else {
            $tableNames = ['non-sqlite driver: ' . $driver];
        }
        return response()->json([
            'status' => 'success',
            'database' => \DB::connection()->getDatabaseName(),
            'driver' => $driver,
            'tables' => $tableNames,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
        ]);
    }
})->withoutMiddleware([\Illuminate\Session\Middleware\StartSession::class]);

// Debug route - TẠM THỜI - xóa sau khi fix xong
Route::get('/debug-env', function () {
    try {
        $info = [
            'app_env'       => config('app.env'),
            'app_debug'     => config('app.debug'),
            'db_connection' => config('database.default'),
            'db_database'   => config('database.connections.' . config('database.default') . '.database'),
            'session_driver'=> config('session.driver'),
            'cache_store'   => config('cache.default'),
            'php_version'   => PHP_VERSION,
            'extensions'    => [
                'pdo_sqlite' => extension_loaded('pdo_sqlite'),
                'sqlite3'    => extension_loaded('sqlite3'),
            ],
        ];

        // Test DB connection
        try {
            \DB::connection()->getPdo();
            $info['db_status'] = 'connected';
        } catch (\Exception $e) {
            $info['db_status'] = 'error: ' . $e->getMessage();
        }

        // Test homepage render
        try {
            $response = app()->handle(\Illuminate\Http\Request::create('/', 'GET'));
            $info['homepage_status'] = $response->getStatusCode();
        } catch (\Throwable $e) {
            $info['homepage_error'] = $e->getMessage();
            $info['homepage_file']  = $e->getFile() . ':' . $e->getLine();
        }

        return response()->json($info, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    } catch (\Throwable $e) {
        return response()->json(['fatal' => $e->getMessage(), 'at' => $e->getFile() . ':' . $e->getLine()]);
    }
})->withoutMiddleware([\Illuminate\Session\Middleware\StartSession::class]);
