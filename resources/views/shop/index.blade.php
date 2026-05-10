@extends('layouts.app')

@section('title', ($selectedCategory ? $selectedCategory->name . ' — ' : '') . 'Danh mục — Vuxshop')
@section('description', $selectedCategory ? ('Danh sach san pham ' . $selectedCategory->name . ' tai Vuxshop.') : 'Danh sach san pham tai Vuxshop.')

@section('content')
@php
    $baseFilters = request()->except('category', 'page');
    $hasFilters = request()->filled('category')
        || request()->filled('price_min')
        || request()->filled('price_max')
        || request()->boolean('in_stock')
        || request()->get('sort', 'latest') !== 'latest';
    $sortLabels = [
        'latest' => 'Mới nhất',
        'popular' => 'Phổ biến',
        'price_asc' => 'Giá tăng dần',
        'price_desc' => 'Giá giảm dần',
    ];
@endphp
<div class="max-w-[1240px] mx-auto px-4">
    <div class="grid lg:grid-cols-[280px,1fr] gap-6">
        <!-- Sidebar -->
        <aside class="space-y-4">
            <div class="glass-panel rounded-2xl p-5 space-y-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-800 uppercase">Bộ lọc</h3>
                    @if($hasFilters)
                        <a href="{{ route('shop.index') }}" class="text-[11px] text-slate-500 hover:text-primary">Xóa lọc</a>
                    @endif
                </div>

                <form method="GET" action="{{ route('shop.index') }}" class="space-y-4">
                    @if($selectedCategory)
                        <input type="hidden" name="category" value="{{ $selectedCategory->slug }}">
                    @endif

                    <div>
                        <p class="text-xs font-semibold text-slate-600 uppercase mb-2">Khoảng giá</p>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" min="0" name="price_min" value="{{ request('price_min') }}" placeholder="Từ" class="glass-input w-full rounded-xl px-3 py-2 text-xs">
                            <input type="number" min="0" name="price_max" value="{{ request('price_max') }}" placeholder="Đến" class="glass-input w-full rounded-xl px-3 py-2 text-xs">
                        </div>
                    </div>

                    <label class="flex items-center gap-2 text-xs text-slate-600">
                        <input type="checkbox" name="in_stock" value="1" class="accent-[--brand]" {{ request()->boolean('in_stock') ? 'checked' : '' }}>
                        Chỉ hiển thị còn hàng
                    </label>

                    <div>
                        <p class="text-xs font-semibold text-slate-600 uppercase mb-2">Sắp xếp</p>
                        <select name="sort" class="glass-input w-full rounded-xl px-3 py-2 text-xs">
                            <option value="latest" {{ $sort=='latest' ? 'selected':'' }}>Mới nhất</option>
                            <option value="popular" {{ $sort=='popular' ? 'selected':'' }}>Phổ biến nhất</option>
                            <option value="price_asc" {{ $sort=='price_asc' ? 'selected':'' }}>Giá thấp đến cao</option>
                            <option value="price_desc" {{ $sort=='price_desc' ? 'selected':'' }}>Giá cao đến thấp</option>
                        </select>
                    </div>

                    <button type="submit" class="glass-button w-full rounded-xl px-4 py-2 text-xs font-bold">
                        Áp dụng bộ lọc
                    </button>
                </form>
            </div>

            <div class="glass-panel rounded-2xl p-5">
                <h3 class="text-sm font-bold text-slate-800 uppercase mb-3">Danh mục</h3>
                <div class="space-y-2">
                    <a href="{{ route('shop.index', $baseFilters) }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs transition-all {{ !$selectedCategory ? 'bg-white/70 text-primary font-bold' : 'text-slate-600 hover:bg-white/60' }}">
                        <span>Tất cả</span>
                        <span class="text-[10px] bg-white/70 text-slate-400 px-1.5 py-0.5 rounded-full">{{ $categories->sum('products_count') }}</span>
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('shop.index', array_merge($baseFilters, ['category' => $cat->slug])) }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs transition-all {{ $selectedCategory?->id == $cat->id ? 'bg-white/70 text-primary font-bold' : 'text-slate-600 hover:bg-white/60' }}">
                            <span>{{ $cat->name }}</span>
                            <span class="text-[10px] bg-white/70 text-slate-400 px-1.5 py-0.5 rounded-full">{{ $cat->products_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

        <!-- Main Product Grid -->
        <div class="space-y-4">
            <div class="glass-panel rounded-2xl px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h1 class="text-lg font-bold text-slate-800">
                        @if($selectedCategory)
                            {{ $selectedCategory->name }}
                        @else
                            Tất cả sản phẩm
                        @endif
                        <span class="text-sm font-normal text-slate-400 ml-2">({{ $products->total() }} sản phẩm)</span>
                    </h1>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @if($selectedCategory)
                            <span class="glass-chip px-2.5 py-1 rounded-full text-[10px] font-semibold text-slate-600">{{ $selectedCategory->name }}</span>
                        @endif
                        @if(request()->filled('price_min') || request()->filled('price_max'))
                            <span class="glass-chip px-2.5 py-1 rounded-full text-[10px] font-semibold text-slate-600">
                                {{ request('price_min') ? number_format((int) request('price_min'), 0, ',', '.') . 'đ' : '0đ' }}
                                -
                                {{ request('price_max') ? number_format((int) request('price_max'), 0, ',', '.') . 'đ' : '∞' }}
                            </span>
                        @endif
                        @if(request()->boolean('in_stock'))
                            <span class="glass-chip px-2.5 py-1 rounded-full text-[10px] font-semibold text-slate-600">Còn hàng</span>
                        @endif
                        @if($sort !== 'latest')
                            <span class="glass-chip px-2.5 py-1 rounded-full text-[10px] font-semibold text-slate-600">{{ $sortLabels[$sort] ?? 'Mới nhất' }}</span>
                        @endif
                    </div>
                </div>

                <form method="GET" action="{{ route('shop.index') }}" class="flex items-center gap-2">
                    @foreach(request()->except('sort', 'page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <label class="text-xs text-slate-500">Sắp xếp:</label>
                    <select name="sort" class="glass-input rounded-xl px-3 py-2 text-xs" onchange="this.form.submit()">
                        <option value="latest" {{ $sort=='latest' ? 'selected':'' }}>Mới nhất</option>
                        <option value="popular" {{ $sort=='popular' ? 'selected':'' }}>Phổ biến nhất</option>
                        <option value="price_asc" {{ $sort=='price_asc' ? 'selected':'' }}>Giá thấp đến cao</option>
                        <option value="price_desc" {{ $sort=='price_desc' ? 'selected':'' }}>Giá cao đến thấp</option>
                    </select>
                </form>
            </div>

            @if($products->count())
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($products as $product)
                        @include('partials.product-card-tw', ['product' => $product])
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($products->lastPage() > 1)
                    @php
                        $start = max(1, $products->currentPage() - 2);
                        $end = min($products->lastPage(), $products->currentPage() + 2);
                    @endphp
                    <div class="flex flex-wrap justify-center items-center gap-2 pt-8">
                        @if(!$products->onFirstPage())
                            <a href="{{ $products->previousPageUrl() }}" class="glass-chip w-9 h-9 rounded-xl flex items-center justify-center text-slate-600 hover:text-primary transition-all">&lsaquo;</a>
                        @endif

                        @if($start > 1)
                            <a href="{{ $products->url(1) }}" class="glass-chip w-9 h-9 rounded-xl flex items-center justify-center text-xs font-semibold text-slate-600">1</a>
                            @if($start > 2)
                                <span class="text-slate-400 text-xs">...</span>
                            @endif
                        @endif

                        @foreach(range($start, $end) as $page)
                            <a href="{{ $products->url($page) }}" class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-semibold transition-all {{ $page == $products->currentPage() ? 'glass-button' : 'glass-chip text-slate-600 hover:text-primary' }}">
                                {{ $page }}
                            </a>
                        @endforeach

                        @if($end < $products->lastPage())
                            @if($end < $products->lastPage() - 1)
                                <span class="text-slate-400 text-xs">...</span>
                            @endif
                            <a href="{{ $products->url($products->lastPage()) }}" class="glass-chip w-9 h-9 rounded-xl flex items-center justify-center text-xs font-semibold text-slate-600">{{ $products->lastPage() }}</a>
                        @endif

                        @if($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}" class="glass-chip w-9 h-9 rounded-xl flex items-center justify-center text-slate-600 hover:text-primary transition-all">&rsaquo;</a>
                        @endif
                    </div>
                @endif
            @else
                <div class="glass-panel rounded-3xl p-16 text-center border border-dashed border-white/70">
                    <span class="material-symbols-outlined text-6xl text-slate-300 mb-4">inventory_2</span>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Không tìm thấy sản phẩm</h3>
                    <p class="text-slate-500 mb-8">Xin lỗi, chúng tôi không tìm thấy sản phẩm nào theo bộ lọc này.</p>
                    <a href="{{ route('shop.index') }}" class="glass-button inline-flex items-center justify-center px-8 py-3 rounded-2xl text-sm font-bold">
                        Quay lại cửa hàng
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
