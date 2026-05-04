@extends('layouts.app')

@section('title', $product->name . ' — Vuxshop')
@section('description', $product->description ?: 'San pham cong nghe chinh hang tai Vuxshop.')
@section('og_image', $product->image)
@section('canonical', route('products.show', $product->id))
@section('og_type', 'product')

@section('content')
@php
    $mainImage = $product->image ?: 'https://via.placeholder.com/800x800/ffffff/0b1220?text=' . urlencode($product->name);
    $gallery = [$mainImage, $mainImage, $mainImage, $mainImage];
@endphp
<div class="max-w-[1240px] mx-auto px-4">
    <div class="glass-panel rounded-2xl px-4 py-3 mb-6 flex flex-wrap items-center gap-2 text-[11px] text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-primary">Trang chủ</a>
        <span>/</span>
        <a href="{{ route('shop.index') }}" class="hover:text-primary">Cửa hàng</a>
        @if($product->category)
            <span>/</span>
            <a href="{{ route('shop.index', ['category' => $product->category_id]) }}" class="hover:text-primary">{{ $product->category->name }}</a>
        @endif
        <span>/</span>
        <span class="text-slate-700 font-semibold">{{ $product->name }}</span>
    </div>

    <div class="grid lg:grid-cols-[1.15fr,0.85fr] gap-6 items-start">
        <!-- Gallery -->
        <div class="space-y-6">
            <div class="glass-panel rounded-[28px] p-6">
                <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.3em] text-slate-500">Chi tiet san pham</p>
                        <h1 class="text-2xl md:text-3xl font-display font-black text-slate-900">{{ $product->name }}</h1>
                    </div>
                    <div class="flex gap-2">
                        <span class="glass-chip text-[10px] font-semibold px-3 py-1 rounded-full text-slate-600">Chinh hang</span>
                        <span class="glass-chip text-[10px] font-semibold px-3 py-1 rounded-full text-slate-600">Tra gop 0%</span>
                    </div>
                </div>
                <div class="relative rounded-3xl bg-white/80 border border-white/70 h-[360px] md:h-[420px] flex items-center justify-center overflow-hidden">
                    <img src="{{ $mainImage }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain p-6">
                    @if($product->stock <= 0)
                        <div class="absolute inset-0 bg-white/75 flex items-center justify-center text-xs font-bold text-slate-600">Het hang</div>
                    @endif
                </div>
                <div class="mt-4 grid grid-cols-4 gap-3">
                    @foreach($gallery as $image)
                        <div class="glass-chip rounded-2xl p-2 flex items-center justify-center h-20">
                            <img src="{{ $image }}" alt="{{ $product->name }}" class="max-h-full object-contain">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div class="glass-card rounded-2xl p-6">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2 mb-3">
                        <span class="material-symbols-outlined text-primary">description</span>
                        Mo ta
                    </h2>
                    <div class="text-[13px] text-slate-600 leading-relaxed space-y-3">
                        <p>{{ $product->description ?: 'San pham mang den trai nghiem cong nghe muc do cao, phu hop ca giai tri va cong viec.' }}</p>
                        <p>Cam nhan thiet ke tinh te, hieu nang ben bi va dich vu hau mai tan tam tu Vuxshop.</p>
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-6">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2 mb-3">
                        <span class="material-symbols-outlined text-primary">analytics</span>
                        Thong so ky thuat
                    </h2>
                    <table class="w-full text-[13px]">
                        <tr class="border-b border-white/70">
                            <td class="py-2.5 text-slate-400 w-1/3">Thuong hieu</td>
                            <td class="py-2.5 font-semibold text-slate-800">{{ $product->category->name ?? 'Apple' }}</td>
                        </tr>
                        <tr class="border-b border-white/70">
                            <td class="py-2.5 text-slate-400">Tinh trang</td>
                            <td class="py-2.5 font-semibold text-slate-800">Moi 100%</td>
                        </tr>
                        <tr class="border-b border-white/70">
                            <td class="py-2.5 text-slate-400">Bao hanh</td>
                            <td class="py-2.5 font-semibold text-slate-800">12 thang chinh hang</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 text-slate-400">Ton kho</td>
                            <td class="py-2.5 font-semibold text-slate-800">{{ $product->stock > 0 ? 'Con hang' : 'Tam het' }}</td>
                        </tr>
                    </table>
                    <button class="w-full mt-4 py-2 border border-primary text-primary text-[12px] font-bold rounded-xl hover:bg-primary hover:text-white transition-all">Xem cau hinh chi tiet</button>
                </div>
            </div>
        </div>

        <!-- Buy Side -->
        <div class="space-y-4">
            <div class="glass-panel rounded-3xl p-6">
                <div class="flex items-center gap-3 flex-wrap">
                    <div class="text-3xl font-black text-primary">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                    @if($product->price_old && $product->price_old > $product->price)
                        <div class="text-slate-400 line-through font-bold text-lg">{{ number_format($product->price_old, 0, ',', '.') }}đ</div>
                        <div class="glass-chip text-primary text-[12px] font-bold px-2 py-1 rounded-full">-{{ round((1 - $product->price / $product->price_old) * 100) }}%</div>
                    @endif
                </div>

                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="glass-chip text-[10px] font-semibold px-3 py-1 rounded-full text-slate-600">Giao nhanh 2h</span>
                    <span class="glass-chip text-[10px] font-semibold px-3 py-1 rounded-full text-slate-600">Ho tro 24/7</span>
                    <span class="glass-chip text-[10px] font-semibold px-3 py-1 rounded-full text-slate-600">Doi moi 30 ngay</span>
                </div>

                <div class="mt-5 border border-white/70 rounded-2xl overflow-hidden">
                    <div class="bg-white/70 px-4 py-2 flex items-center gap-2 text-primary">
                        <span class="material-symbols-outlined text-[20px]">auto_awesome</span>
                        <span class="text-[12px] font-bold uppercase">Uu dai hom nay</span>
                    </div>
                    <div class="p-4 space-y-3 text-[12px] text-slate-700">
                        <div class="flex gap-2">
                            <span class="glass-chip h-5 w-5 rounded-full flex items-center justify-center text-[10px]">1</span>
                            <span>Giam them toi 500k cho thanh vien Vuxshop.</span>
                        </div>
                        <div class="flex gap-2">
                            <span class="glass-chip h-5 w-5 rounded-full flex items-center justify-center text-[10px]">2</span>
                            <span>Tra gop 0% lai suat, ho so sieu nhanh.</span>
                        </div>
                        <div class="flex gap-2">
                            <span class="glass-chip h-5 w-5 rounded-full flex items-center justify-center text-[10px]">3</span>
                            <span>Thu cu doi moi tro gia toi 2 trieu.</span>
                        </div>
                    </div>
                </div>

                <div class="mt-5 grid gap-3">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="glass-button w-full py-4 rounded-2xl flex flex-col items-center justify-center transition-all {{ $product->stock <= 0 ? 'opacity-60 cursor-not-allowed' : '' }}" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            <span class="font-black text-lg uppercase leading-none">Mua ngay</span>
                            <span class="text-[11px] font-medium opacity-90">Giao nhanh tai nha hoac nhan tai cua hang</span>
                        </button>
                    </form>
                    <div class="grid grid-cols-2 gap-3">
                        <button class="glass-chip py-3 rounded-2xl text-slate-700 flex flex-col items-center justify-center hover:shadow-md transition-all">
                            <span class="font-bold text-[12px] uppercase leading-none">Tra gop 0%</span>
                            <span class="text-[10px] text-slate-500">Xet duyet 5 phut</span>
                        </button>
                        <button class="glass-chip py-3 rounded-2xl text-slate-700 flex flex-col items-center justify-center hover:shadow-md transition-all">
                            <span class="font-bold text-[12px] uppercase leading-none">Tra gop qua the</span>
                            <span class="text-[10px] text-slate-500">Visa, Mastercard, JCB</span>
                        </button>
                    </div>
                </div>

                <div class="mt-5 space-y-3 text-[12px] text-slate-600">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-emerald-500 text-[20px]">local_shipping</span>
                        <span>Mien phi van chuyen cho don tu 5.000.000d.</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-sky-500 text-[20px]">verified</span>
                        <span>San pham moi 100%, bao hanh chinh hang 12 thang.</span>
                    </div>
                </div>
            </div>

            <div class="glass-panel rounded-2xl p-5">
                <h4 class="font-bold text-[13px] text-slate-800 mb-3">Chon dia chi nhan hang</h4>
                <div class="flex items-center gap-2 glass-chip rounded-xl p-3 text-[12px] cursor-pointer hover:shadow-md transition-all">
                    <span class="material-symbols-outlined text-primary">location_on</span>
                    <span class="flex-1 font-semibold text-slate-700">Ha Noi</span>
                    <span class="material-symbols-outlined text-slate-400 text-[18px]">expand_more</span>
                </div>
                <div class="mt-3 glass-chip rounded-xl p-3 text-[11px] text-slate-600 flex items-start gap-2">
                    <span class="material-symbols-outlined text-emerald-500 text-[18px]">done</span>
                    <div>
                        <p class="font-bold text-slate-800">Con hang</p>
                        <p>123 Thai Ha, Dong Da, Ha Noi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($related->count())
        <div class="mt-16">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-black text-slate-800 uppercase flex items-center gap-2">
                    <span class="w-1.5 h-6 bg-primary rounded-full"></span>
                    San pham tuong tu
                </h2>
                <a href="{{ route('shop.index', ['category' => $product->category_id]) }}" class="text-xs font-bold text-primary hover:underline">Xem danh muc</a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($related as $p)
                    @include('partials.product-card-tw', ['product' => $p])
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
