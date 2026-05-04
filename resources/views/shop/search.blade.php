@extends('layouts.app')

@section('title', $keyword ? "Tim kiem: $keyword — Vuxshop" : 'Tim kiem — Vuxshop')
@section('description', $keyword ? "Ket qua tim kiem cho $keyword tai Vuxshop." : 'Tim kiem san pham cong nghe tai Vuxshop.')
@section('canonical', $keyword ? route('shop.search', ['q' => $keyword]) : route('shop.search'))

@section('content')
<div class="max-w-[1240px] mx-auto px-4 space-y-8">
    <section class="glass-panel rounded-3xl p-6 md:p-10 text-center">
        <p class="text-[11px] uppercase tracking-[0.35em] text-slate-500">Tim kiem nhanh</p>
        <h1 class="mt-3 text-3xl md:text-4xl font-display font-black text-slate-900">
            Tim kiem san pham cong nghe
        </h1>
        <p class="mt-3 text-sm text-slate-600">Nhap tu khoa de tim smartphone, laptop hoac phu kien ban can.</p>

        <form action="{{ route('shop.search') }}" method="GET" class="max-w-3xl mx-auto mt-6">
            <div class="glass-chip rounded-2xl p-2 flex items-center gap-3">
                <span class="material-symbols-outlined text-slate-400">search</span>
                <input type="text" name="q" id="search-input"
                       placeholder="Nhap ten san pham, thuong hieu..."
                       class="flex-1 glass-input rounded-xl px-4 py-3 text-sm"
                       value="{{ $keyword }}" autofocus>
                <button type="submit" class="glass-button px-5 py-3 rounded-xl text-sm font-bold">Tim kiem</button>
            </div>
        </form>

        <div class="flex flex-wrap justify-center gap-2 mt-5">
            <span class="text-[11px] uppercase tracking-[0.2em] text-slate-400">Goi y</span>
            @foreach(['iPhone', 'Samsung', 'MacBook', 'Sony', 'AirPods', 'iPad'] as $tag)
                <a href="{{ route('shop.search', ['q' => $tag]) }}" 
                   class="glass-chip px-4 py-2 rounded-full text-[11px] font-semibold text-slate-600 hover:text-primary transition-all">
                    {{ $tag }}
                </a>
            @endforeach
        </div>
    </section>

    <section class="space-y-4">
        @if($keyword)
            <div class="glass-panel rounded-2xl px-5 py-4 flex flex-wrap items-center justify-between gap-2 text-sm text-slate-600">
                @if($products->count())
                    <span>Tim thay <strong class="text-slate-900">{{ $products->total() }}</strong> san pham cho tu khoa
                        "<strong class="text-primary">{{ $keyword }}</strong>"</span>
                @else
                    <span>Khong tim thay san pham nao cho "<strong class="text-primary">{{ $keyword }}</strong>"</span>
                @endif
            </div>
        @else
            <div class="glass-panel rounded-3xl p-12 text-center">
                <span class="material-symbols-outlined text-6xl text-slate-300">search</span>
                <h3 class="mt-4 text-xl font-bold text-slate-800">Nhap tu khoa de bat dau</h3>
                <p class="text-slate-500">Vuxshop luon co san nhieu san pham moi nhat.</p>
            </div>
        @endif

        @if($products->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($products as $product)
                    @include('partials.product-card-tw', ['product' => $product])
                @endforeach
            </div>

            @if($products->lastPage() > 1)
                @php
                    $start = max(1, $products->currentPage() - 2);
                    $end = min($products->lastPage(), $products->currentPage() + 2);
                @endphp
                <div class="flex flex-wrap justify-center items-center gap-2 pt-10">
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
        @elseif($keyword)
            <div class="glass-panel rounded-3xl p-12 text-center">
                <span class="material-symbols-outlined text-6xl text-slate-300">sentiment_dissatisfied</span>
                <h3 class="mt-4 text-xl font-bold text-slate-800">Khong co ket qua</h3>
                <p class="text-slate-500">Thu tim bang tu khoa khac hoac quay lai cua hang.</p>
                <div class="pt-6">
                    <a href="{{ route('shop.index') }}" class="glass-button inline-flex items-center justify-center px-8 py-3 rounded-2xl text-sm font-bold">Xem tat ca san pham</a>
                </div>
            </div>
        @endif
    </section>
</div>
@endsection
