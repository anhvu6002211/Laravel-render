@extends('layouts.app')

@section('description', 'Vuxshop - cua hang dien thoai, laptop va phu kien chinh hang voi trai nghiem mua sam hien dai.')

@section('content')
<div class="max-w-[1240px] mx-auto px-4 space-y-10">
    <section class="grid lg:grid-cols-[1.15fr,0.85fr] gap-6 items-stretch">
        <div class="glass-panel rounded-[28px] p-8 md:p-10 relative overflow-hidden reveal" style="--delay: 0.05s;">
            <div class="orb one float-slow"></div>
            <div class="orb two float-slow" style="animation-delay: -2s;"></div>
            <div class="orb three float-slow" style="animation-delay: -4s;"></div>

            <p class="text-[11px] uppercase tracking-[0.35em] text-slate-500">Vuxshop 2026</p>
            <h1 class="mt-4 text-3xl md:text-5xl font-display font-black text-slate-900 leading-tight">
                Chạm vào thế giới công nghệ được tuyển chọn tinh tế
            </h1>
            <p class="mt-4 text-sm md:text-base text-slate-600 max-w-xl">
                Bộ sưu tập điện thoại, laptop, phụ kiện chính hãng với trải nghiệm mua sắm mượt mà và chính sách
                hậu mãi an tâm.
            </p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('shop.index') }}" class="glass-button px-5 py-3 rounded-2xl text-sm font-bold">Khám phá ngay</a>
                <a href="{{ route('shop.index') }}" class="glass-chip px-5 py-3 rounded-2xl text-sm font-semibold text-slate-700 hover:shadow-md transition-all">Xem danh mục</a>
            </div>
            <div class="mt-6 grid sm:grid-cols-3 gap-3">
                <div class="glass-chip rounded-2xl px-4 py-3">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Giao nhanh</p>
                    <p class="text-sm font-bold text-slate-800">2h nội thành</p>
                </div>
                <div class="glass-chip rounded-2xl px-4 py-3">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Trả góp</p>
                    <p class="text-sm font-bold text-slate-800">0% đến 12 tháng</p>
                </div>
                <div class="glass-chip rounded-2xl px-4 py-3">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Đổi mới</p>
                    <p class="text-sm font-bold text-slate-800">30 ngày an tâm</p>
                </div>
            </div>
        </div>

        <div class="grid gap-4">
            <div class="glass-card rounded-2xl p-6 reveal" style="--delay: 0.15s;">
                <h3 class="text-xs uppercase tracking-[0.3em] text-slate-500">Dịch vụ nổi bật</h3>
                <div class="mt-4 space-y-3 text-sm text-slate-700">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary">local_shipping</span>
                        <div>
                            <p class="font-semibold text-slate-800">Giao siêu tốc</p>
                            <p class="text-xs text-slate-500">Hà Nội, HCM nhận hàng trong 2 giờ.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary">verified</span>
                        <div>
                            <p class="font-semibold text-slate-800">Hàng chính hãng</p>
                            <p class="text-xs text-slate-500">Bảo hành rõ ràng, hỗ trợ tận tâm.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary">support_agent</span>
                        <div>
                            <p class="font-semibold text-slate-800">Hỗ trợ 24/7</p>
                            <p class="text-xs text-slate-500">Tư vấn chọn máy đúng nhu cầu.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-6 reveal" style="--delay: 0.25s;">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-800 uppercase">Hot picks</h3>
                    <span class="text-[11px] text-slate-500">Cập nhật mỗi ngày</span>
                </div>
                <div class="mt-4 space-y-3">
                    @forelse($featuredProducts->take(2) as $product)
                        <a href="{{ route('products.show', $product->slug) }}" class="flex items-center gap-3 group">
                            <div class="h-16 w-16 rounded-xl bg-white/80 border border-white/60 p-2 flex items-center justify-center">
                                <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}" class="max-h-full object-contain group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-slate-800 group-hover:text-primary transition-colors truncate">{{ $product->name }}</p>
                                <p class="text-xs text-slate-500">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-slate-500">Chưa có sản phẩm nổi bật.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <section class="glass-panel rounded-3xl p-6 md:p-8 reveal" style="--delay: 0.2s;">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <h2 class="text-lg font-black text-slate-800 uppercase flex items-center gap-2">
                <span class="w-2 h-2 bg-primary rounded-full"></span>
                Danh mục nổi bật
            </h2>
            <a href="{{ route('shop.index') }}" class="text-xs font-bold text-primary hover:underline">Xem tất cả</a>
        </div>
        <div class="mt-5 flex flex-wrap gap-3">
            @foreach($categories as $category)
                <a href="{{ route('shop.index', ['category' => $category->id]) }}" class="glass-chip px-4 py-2 rounded-full text-sm font-semibold text-slate-700 flex items-center gap-2 hover:shadow-md transition-all">
                    <span class="material-symbols-outlined text-[18px] text-primary">
                        @if(Str::contains(Str::lower($category->name), 'điện thoại')) smartphone
                        @elseif(Str::contains(Str::lower($category->name), 'laptop')) laptop_mac
                        @elseif(Str::contains(Str::lower($category->name), 'tai nghe')) headphones
                        @elseif(Str::contains(Str::lower($category->name), 'đồng hồ')) watch
                        @else ink_highlighter
                        @endif
                    </span>
                    <span class="text-[12px] font-semibold">{{ $category->name }}</span>
                </a>
            @endforeach
        </div>
    </section>

    <section class="space-y-6">
        <div class="flex justify-between items-center glass-panel p-5 rounded-2xl reveal" style="--delay: 0.25s;">
            <h2 class="text-lg font-black text-slate-800 uppercase flex items-center gap-2">
                <span class="w-1.5 h-6 bg-primary rounded-full"></span>
                Sản phẩm nổi bật
            </h2>
            <a href="{{ route('shop.index') }}" class="text-xs font-bold text-primary hover:underline">Xem tất cả</a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 reveal" style="--delay: 0.3s;">
            @foreach($featuredProducts as $product)
                <div class="product-card flex flex-col p-4 group">
                    <div class="flex items-center justify-between">
                        <span class="glass-chip text-[10px] font-bold px-2 py-1 rounded-full text-primary">Giảm 15%</span>
                        <span class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Hot</span>
                    </div>
                    
                    <a href="{{ route('products.show', $product->slug) }}" class="block my-4 h-[160px] relative">
                        <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                    </a>
                    
                    <div class="flex-1 flex flex-col">
                        <h3 class="font-bold text-[13px] text-slate-800 line-clamp-2 mb-2 group-hover:text-primary transition-colors">{{ $product->name }}</h3>
                        
                        <div class="mt-auto">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold text-[14px] text-primary">{{ number_format($product->price * 0.85, 0, ',', '.') }}đ</span>
                                <span class="text-[11px] text-slate-400 line-through">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                            </div>
                            
                            <div class="glass-chip text-[10px] text-slate-600 px-2 py-1 rounded mb-3 inline-block">
                                Member nhận thêm ưu đãi
                            </div>

                            <div class="flex items-center gap-1 text-[10px] text-yellow-500 mb-4">
                                <div class="flex">
                                    @for($i=0; $i<5; $i++)
                                        <span class="material-symbols-outlined text-[12px] fill-current">star</span>
                                    @endfor
                                </div>
                                <span class="text-slate-400">(45 đánh giá)</span>
                            </div>
                            
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button class="glass-button w-full text-white font-bold text-[11px] py-2 rounded-xl transition-all flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-sm">shopping_cart</span>
                                    Mua ngay
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="glass-panel p-8 rounded-3xl reveal" style="--delay: 0.35s;">
        <h3 class="text-center font-bold text-slate-500 uppercase tracking-widest text-[12px]">Thương hiệu đồng hành</h3>
        <div class="mt-8 flex flex-wrap justify-center items-center gap-x-12 gap-y-6 text-slate-400">
            <span class="text-xl font-black italic">APPLE</span>
            <span class="text-xl font-black">SAMSUNG</span>
            <span class="text-xl font-serif tracking-widest">SONY</span>
            <span class="text-2xl font-black italic">BOSE</span>
            <span class="text-xl font-bold uppercase">Microsoft</span>
        </div>
    </section>
</div>
@endsection
