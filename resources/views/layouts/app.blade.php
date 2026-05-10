<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="no-referrer">
    <title>@yield('title', 'Vuxshop — Điện thoại, laptop, phụ kiện chính hãng')</title>
    @php
        $pageTitle = trim($__env->yieldContent('title', 'Vuxshop - Dien thoai, laptop, phu kien chinh hang'));
        $pageDescription = trim($__env->yieldContent(
            'description',
            'Vuxshop cung cap dien thoai, laptop, phu kien chinh hang va dich vu hau mai tan tam.'
        ));
        $pageUrl = trim($__env->yieldContent('canonical', request()->url()));
        $pageType = trim($__env->yieldContent('og_type', 'website'));
        $ogImage = trim($__env->yieldContent('og_image'));
    @endphp
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ $pageUrl }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $pageUrl }}">
    <meta property="og:type" content="{{ $pageType }}">
    <meta property="og:site_name" content="Vuxshop">
    <meta name="twitter:card" content="summary_large_image">
    @if($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
        <meta name="twitter:image" content="{{ $ogImage }}">
    @endif
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;700;800&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Google Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Space Grotesk', 'sans-serif'],
                        display: ['Fraunces', 'serif'],
                    },
                    colors: {
                        primary: '#ff5f2e',
                        'primary-dark': '#e54a20',
                        secondary: '#eef2f6',
                        ink: '#0b1220',
                    },
                }
            }
        }
    </script>
    <style>
        :root {
            --brand: #ff5f2e;
            --brand-dark: #e54a20;
            --ink: #0b1220;
            --glass: rgba(255, 255, 255, 0.7);
            --glass-strong: rgba(255, 255, 255, 0.85);
            --glass-border: rgba(255, 255, 255, 0.65);
            --shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
            --shadow-soft: 0 12px 30px rgba(15, 23, 42, 0.12);
            --glow: 0 0 40px rgba(255, 95, 46, 0.25);
        }

        body {
            background:
                radial-gradient(1100px circle at 8% -8%, #fff1e6 0%, transparent 55%),
                radial-gradient(900px circle at 95% 8%, #e7f4ff 0%, transparent 50%),
                linear-gradient(180deg, #f9fbff 0%, #f2fbf7 100%);
            color: var(--ink);
            font-family: 'Space Grotesk', sans-serif;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(15, 23, 42, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(15, 23, 42, 0.05) 1px, transparent 1px);
            background-size: 44px 44px;
            opacity: 0.35;
            pointer-events: none;
            z-index: -1;
        }

        .header-shell {
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-glass {
            background: rgba(255, 255, 255, 0.78);
            border: 1px solid var(--glass-border);
            box-shadow: var(--shadow-soft);
            backdrop-filter: blur(18px);
        }

        .brand-mark {
            font-family: 'Fraunces', serif;
            letter-spacing: -0.02em;
        }

        .glass-panel {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            box-shadow: var(--shadow);
            backdrop-filter: blur(18px);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.78);
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: var(--shadow-soft);
            backdrop-filter: blur(14px);
        }

        .glass-chip {
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(255, 255, 255, 0.65);
        }

        .glass-input {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.8);
            color: var(--ink);
        }

        .glass-input::placeholder {
            color: #6b7280;
        }

        .glass-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 95, 46, 0.18);
        }

        .glass-button {
            background: var(--brand);
            color: white;
            box-shadow: var(--glow);
        }

        .glass-button:hover {
            background: var(--brand-dark);
        }

        .product-card {
            position: relative;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.82);
            border: 1px solid rgba(255, 255, 255, 0.72);
            box-shadow: var(--shadow-soft);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 60px rgba(15, 23, 42, 0.16);
        }

        .orb {
            position: absolute;
            border-radius: 9999px;
            opacity: 0.7;
        }

        .orb.one {
            width: 180px;
            height: 180px;
            background: #ffc7a4;
            top: -60px;
            right: -40px;
        }

        .orb.two {
            width: 140px;
            height: 140px;
            background: #a7ddff;
            bottom: -50px;
            right: 20%;
        }

        .orb.three {
            width: 120px;
            height: 120px;
            background: #b7f3d4;
            top: 30%;
            left: -40px;
        }

        .reveal {
            opacity: 0;
            transform: translateY(16px);
            animation: fade-up 0.8s ease forwards;
            animation-delay: var(--delay, 0s);
        }

        .float-slow {
            animation: float 7s ease-in-out infinite;
        }

        @keyframes fade-up {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }

        @keyframes bounce-in {
            0% { transform: translateY(-20px); opacity: 0; }
            60% { transform: translateY(5px); opacity: 1; }
            100% { transform: translateY(0); }
        }

        .animate-bounce-in { animation: bounce-in 0.5s ease-out forwards; }
    </style>
    @livewireStyles
</head>
<body class="antialiased min-h-screen relative font-sans">
    
    <!-- Glass Header -->
    <header class="header-shell">
        <div class="max-w-[1240px] mx-auto px-4 pt-4 pb-3">
            <div class="header-glass rounded-2xl px-4 py-3 flex items-center gap-4 md:gap-6">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 shrink-0">
                    <span class="text-2xl md:text-3xl font-black brand-mark text-slate-900">Vuxshop</span>
                    <span class="text-[10px] font-semibold uppercase tracking-[0.28em] text-slate-500 hidden lg:block">Chính hãng</span>
                </a>

                <!-- Categories Button & Mega Menu -->
                <div class="relative group hidden lg:block shrink-0">
                    <div class="glass-chip flex items-center gap-2 px-3 py-2 rounded-xl cursor-pointer hover:shadow-md transition-all">
                        <span class="material-symbols-outlined text-[20px] text-primary">menu</span>
                        <span class="text-[11px] font-bold uppercase text-slate-700">Danh mục</span>
                    </div>
                    
                    <!-- Mega Menu Dropdown -->
                    <div class="absolute top-full left-0 pt-3 hidden group-hover:block z-[1000]">
                        <div class="w-[820px] grid grid-cols-4 gap-4 p-6 rounded-2xl glass-panel text-slate-700 border border-white/60">
                            <div class="space-y-4">
                            <h4 class="font-bold text-sm border-b pb-2 flex items-center gap-2 text-primary border-white/60">
                                <span class="material-symbols-outlined text-sm">smartphone</span> Điện thoại
                            </h4>
                            <ul class="space-y-2 text-xs font-medium text-slate-600">
                                <li><a href="#" class="hover:text-primary transition-colors">iPhone 15 Series</a></li>
                                <li><a href="#" class="hover:text-primary transition-colors">Samsung Galaxy S24</a></li>
                                <li><a href="#" class="hover:text-primary transition-colors">Xiaomi Redmi Note 13</a></li>
                                <li><a href="#" class="hover:text-primary transition-colors">OPPO Reno Series</a></li>
                            </ul>
                        </div>
                        <div class="space-y-4 border-l border-white/60 pl-6">
                            <h4 class="font-bold text-sm border-b pb-2 flex items-center gap-2 text-primary border-white/60">
                                <span class="material-symbols-outlined text-sm">laptop</span> Laptop
                            </h4>
                            <ul class="space-y-2 text-xs font-medium text-slate-600">
                                <li><a href="#" class="hover:text-primary transition-colors">MacBook Pro M3</a></li>
                                <li><a href="#" class="hover:text-primary transition-colors">ASUS ROG Gaming</a></li>
                                <li><a href="#" class="hover:text-primary transition-colors">Dell XPS Series</a></li>
                                <li><a href="#" class="hover:text-primary transition-colors">HP Pavilion</a></li>
                            </ul>
                        </div>
                        <div class="space-y-4 border-l border-white/60 pl-6">
                            <h4 class="font-bold text-sm border-b pb-2 flex items-center gap-2 text-primary border-white/60">
                                <span class="material-symbols-outlined text-sm">headphones</span> Phụ kiện
                            </h4>
                            <ul class="space-y-2 text-xs font-medium text-slate-600">
                                <li><a href="#" class="hover:text-primary transition-colors">Tai nghe Bluetooth</a></li>
                                <li><a href="#" class="hover:text-primary transition-colors">Sạc dự phòng</a></li>
                                <li><a href="#" class="hover:text-primary transition-colors">Cáp sạc, Củ sạc</a></li>
                                <li><a href="#" class="hover:text-primary transition-colors">Ốp lưng, Dán màn hình</a></li>
                            </ul>
                        </div>
                        <div class="space-y-4 border-l border-white/60 pl-6">
                            <h4 class="font-bold text-sm border-b pb-2 flex items-center gap-2 text-primary border-white/60">
                                <span class="material-symbols-outlined text-sm">watch</span> Đồng hồ
                            </h4>
                            <ul class="space-y-2 text-xs font-medium text-slate-600">
                                <li><a href="#" class="hover:text-primary transition-colors">Apple Watch Ultra 2</a></li>
                                <li><a href="#" class="hover:text-primary transition-colors">Garmin Forerunner</a></li>
                                <li><a href="#" class="hover:text-primary transition-colors">Amazfit Series</a></li>
                                <li><a href="#" class="hover:text-primary transition-colors">Đồng hồ trẻ em</a></li>
                            </ul>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 min-w-0 max-w-[420px]">
                    <form action="{{ route('shop.search') }}" method="GET" class="relative">
                        <input type="text" name="q" placeholder="Bạn cần tìm gì?" class="glass-input w-full rounded-xl py-2.5 px-4 pl-10 text-[13px]">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
                    </form>
                </div>

                <!-- Header Actions -->
                <div class="flex items-center gap-2 md:gap-5">
                    <div class="hidden xl:flex flex-col items-start leading-none cursor-pointer text-slate-600">
                        <span class="text-[10px] font-medium">Cửa hàng gần bạn</span>
                        <span class="text-[12px] font-bold text-slate-800">Hà Nội</span>
                    </div>

                    <a href="{{ route('cart.index') }}" class="flex flex-col items-center gap-0.5 relative px-2 py-1 rounded-xl hover:bg-white/60 transition-all text-slate-700">
                        <span class="material-symbols-outlined text-[24px] text-primary">shopping_cart</span>
                        <span class="text-[10px] font-semibold">Giỏ hàng</span>
                        @php $cartCount = count(session('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="absolute top-0 right-1 bg-primary text-white text-[10px] font-black h-4 w-4 rounded-full flex items-center justify-center border-2 border-white shadow-sm">{{ $cartCount }}</span>
                        @endif
                    </a>

                    @guest
                        <a href="{{ route('login') }}" class="flex flex-col items-center gap-0.5 px-2 py-1 rounded-xl hover:bg-white/60 transition-all text-slate-700">
                            <span class="material-symbols-outlined text-[24px] text-slate-500">account_circle</span>
                            <span class="text-[10px] font-semibold">Đăng nhập</span>
                        </a>
                    @endguest

                    @auth
                        <div class="group relative">
                            <button class="flex flex-col items-center gap-0.5 px-2 py-1 rounded-xl hover:bg-white/60 transition-all text-slate-700">
                                <span class="material-symbols-outlined text-[24px] text-slate-600">person</span>
                                <span class="text-[10px] font-semibold truncate max-w-[60px]">{{ explode(' ', auth()->user()->name)[0] }}</span>
                            </button>
                            <div class="absolute right-0 top-full pt-2 w-48 hidden group-hover:block transition-all z-[110]">
                                <div class="glass-panel border border-white/60 rounded-2xl p-2 text-slate-700">
                                    <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-white/70 text-xs font-bold transition-all">
                                        <span class="material-symbols-outlined text-sm">inventory_2</span> Quản lý đơn hàng
                                    </a>
                                    <div class="h-px bg-white/70 my-1"></div>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-red-50 text-xs font-bold text-red-600 transition-all">
                                            <span class="material-symbols-outlined text-sm">logout</span> Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    <div class="fixed top-24 left-0 right-0 z-[90] px-6 flex flex-col items-center gap-3 pointer-events-none">
        @if(session('success'))
            <div class="glass-card border-l-4 border-emerald-500 text-slate-800 px-6 py-3 rounded-r-2xl flex items-center gap-3 pointer-events-auto animate-bounce-in">
                <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                <span class="text-sm font-bold">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="glass-card border-l-4 border-red-500 text-slate-800 px-6 py-3 rounded-r-2xl flex items-center gap-3 pointer-events-auto animate-bounce-in">
                <span class="material-symbols-outlined text-red-500">error</span>
                <span class="text-sm font-bold">{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="py-10 min-h-[60vh] relative">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-16 pb-12">
        <div class="max-w-[1240px] mx-auto px-4">
            <div class="glass-panel rounded-3xl px-6 py-10 md:px-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-slate-600">
                    <!-- Col 1: Support -->
                    <div class="space-y-4">
                        <h4 class="font-bold text-[14px] uppercase mb-4 text-slate-800">Tổng đài hỗ trợ</h4>
                        <div class="space-y-2 text-[12px]">
                            <p class="flex justify-between"><span>Gọi mua hàng:</span> <span class="font-bold text-primary">1800.2097</span></p>
                            <p class="flex justify-between"><span>Khiếu nại:</span> <span class="font-bold text-primary">1800.2063</span></p>
                            <p class="flex justify-between"><span>Bảo hành:</span> <span class="font-bold text-primary">1800.2064</span></p>
                        </div>
                        <h4 class="font-bold text-[14px] uppercase mt-6 mb-4 text-slate-800">Phương thức thanh toán</h4>
                        <div class="flex flex-wrap gap-2">
                            <span class="glass-chip px-2 py-1 rounded text-[10px] font-bold">VISA</span>
                            <span class="glass-chip px-2 py-1 rounded text-[10px] font-bold">MOMO</span>
                            <span class="glass-chip px-2 py-1 rounded text-[10px] font-bold">VNPAY</span>
                            <span class="glass-chip px-2 py-1 rounded text-[10px] font-bold">ZALOPAY</span>
                        </div>
                    </div>

                    <!-- Col 2: Services -->
                    <div>
                        <h4 class="font-bold text-[14px] uppercase mb-4 text-slate-800">Thông tin và chính sách</h4>
                        <ul class="space-y-2 text-[12px]">
                            <li><a href="#" class="hover:text-primary transition-colors">Mua hàng và thanh toán Online</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Mua hàng trả góp Online</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Chính sách giao hàng</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Tra thông tin bảo hành</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Tra cứu hóa đơn điện tử</a></li>
                        </ul>
                    </div>

                    <!-- Col 3: Links -->
                    <div>
                        <h4 class="font-bold text-[14px] uppercase mb-4 text-slate-800">Dịch vụ và thông tin khác</h4>
                        <ul class="space-y-2 text-[12px]">
                            <li><a href="#" class="hover:text-primary transition-colors">Khách hàng doanh nghiệp (B2B)</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Ưu đãi thanh toán</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Quy chế hoạt động</a></li>
                            <li><a href="#" class="hover:text-primary transition-colors">Chính sách bảo mật</a></li>
                        </ul>
                    </div>

                    <!-- Col 4: Newsletter/Connect -->
                    <div class="space-y-4">
                        <h4 class="font-bold text-[14px] uppercase mb-4 text-slate-800">Kết nối với Vuxshop</h4>
                        <div class="flex gap-3">
                            <a href="#" class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center hover:opacity-80 transition-opacity"><span class="material-symbols-outlined text-sm">facebook</span></a>
                            <a href="#" class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center hover:opacity-80 transition-opacity"><span class="material-symbols-outlined text-sm">play_circle</span></a>
                            <a href="#" class="w-8 h-8 rounded-full bg-pink-600 text-white flex items-center justify-center hover:opacity-80 transition-opacity"><span class="material-symbols-outlined text-sm">camera_alt</span></a>
                        </div>
                        <div class="mt-8 pt-4 border-t border-white/70">
                            <p class="text-[10px] text-slate-500">© 2026 Công ty TNHH Vuxshop. Địa chỉ: 123 Đường Công Nghệ, Hà Nội. Giấy phép kinh doanh số: 0123456789.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @livewireScripts
</body>
</html>
