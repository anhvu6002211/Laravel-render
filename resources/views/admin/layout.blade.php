<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="no-referrer">
    <title>Admin Dashboard — Vuxshop</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Google Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            glow: '#d5b3f7',
                            muted: 'rgba(255, 255, 255, 0.4)',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #0f1014;
            color: white;
            font-family: 'Inter', sans-serif;
        }
        .bg-glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .text-gradient {
            background: linear-gradient(135deg, #cfafed 0%, #f3a2c5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #d5b3f7;
            padding-left: 12px;
        }
    </style>
</head>
<body class="min-h-screen flex overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-72 bg-glass border-r border-white/5 h-screen flex flex-col p-8 gap-12 z-20">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-tr from-[#cfafed] to-[#f3a2c5] rounded-xl flex items-center justify-center rotate-12 shadow-lg shadow-brand-glow/20">
                <span class="material-symbols-outlined text-black font-black">bolt</span>
            </div>
            <span class="text-2xl font-black font-display tracking-tighter text-white">Vux<span class="text-gradient">shop</span></span>
        </a>

        <nav class="flex-1 space-y-2">
            <p class="text-[10px] uppercase tracking-widest font-black text-brand-muted mb-4 px-2">Quản lý chính</p>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 text-white hover:bg-white/5 p-3 rounded-2xl transition-all group {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="material-symbols-outlined text-brand-muted group-hover:text-brand-glow">dashboard</span>
                <span class="font-bold text-sm">Dashboard</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-4 text-white hover:bg-white/5 p-3 rounded-2xl transition-all group {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <span class="material-symbols-outlined text-brand-muted group-hover:text-brand-glow">inventory_2</span>
                <span class="font-bold text-sm">Sản phẩm</span>
            </a>
            <a href="#" class="flex items-center gap-4 text-white hover:bg-white/5 p-3 rounded-2xl transition-all group opacity-50 cursor-not-allowed">
                <span class="material-symbols-outlined text-brand-muted">shopping_cart</span>
                <span class="font-bold text-sm">Đơn hàng</span>
            </a>
            <a href="#" class="flex items-center gap-4 text-white hover:bg-white/5 p-3 rounded-2xl transition-all group opacity-50 cursor-not-allowed">
                <span class="material-symbols-outlined text-brand-muted">group</span>
                <span class="font-bold text-sm">Người dùng</span>
            </a>
        </nav>

        <div class="pt-8 border-t border-white/5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full flex items-center gap-4 text-red-400/80 hover:text-red-400 transition-colors p-3">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="font-bold text-sm">Đăng xuất</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 h-screen overflow-y-auto relative bg-[#0f1014]">
        <!-- Decorative Glow -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-glow/5 blur-[120px] -z-10 rounded-full"></div>
        <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-[#f3a2c5]/5 blur-[100px] -z-10 rounded-full"></div>

        <header class="h-24 sticky top-0 bg-transparent backdrop-blur-md flex items-center justify-between px-12 z-10 border-b border-white/5">
            <div>
                <h2 class="text-xl font-extrabold text-white">@yield('page_title')</h2>
            </div>
            <div class="flex items-center gap-6">
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-brand-muted text-lg">search</span>
                    <input type="text" placeholder="Tìm nhanh..." class="bg-glass rounded-2xl py-2 pl-10 pr-4 text-sm text-white focus:outline-none focus:border-brand-glow/30 w-64 border border-transparent transition-all">
                </div>
                <div class="w-10 h-10 rounded-2xl overflow-hidden border border-white/10 ring-2 ring-brand-glow/20">
                    <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->email) . '&background=d5b3f7&color=000' }}" class="w-full h-full object-cover">
                </div>
            </div>
        </header>

        <div class="p-12">
            @if(session('success'))
                <div class="mb-8 p-4 bg-green-500/10 border border-green-500/20 text-green-400 rounded-2xl flex items-center gap-3 animate-pulse">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>
</html>
