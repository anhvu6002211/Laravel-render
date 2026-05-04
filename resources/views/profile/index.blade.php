@extends('layouts.app')
@section('title', 'Tài khoản của tôi — Vuxshop')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        
        <!-- Sidebar -->
        <div class="md:col-span-1 space-y-4">
            <div class="bg-glass rounded-3xl border border-white/10 p-6 shadow-2xl">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-tr from-brand-glow to-brand-glow2 rounded-full flex items-center justify-center text-black font-extrabold text-xl shadow-lg">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-white font-bold">{{ $user->name }}</h2>
                        <p class="text-brand-muted text-xs">{{ $user->email }}</p>
                    </div>
                </div>
                
                <nav class="space-y-2">
                    <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-4 py-3 bg-white/10 border border-white/10 text-brand-glow rounded-xl font-medium transition-all">
                        <span class="material-symbols-outlined text-sm">inventory_2</span> 
                        Lịch sử đơn hàng
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-white/5 rounded-xl font-medium transition-all">
                            <span class="material-symbols-outlined text-sm">logout</span> 
                            Đăng xuất
                        </button>
                    </form>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="md:col-span-3">
            <div class="bg-glass rounded-3xl border border-white/10 p-8 shadow-2xl min-h-[500px]">
                <h1 class="text-2xl font-black text-white mb-6 flex items-center gap-3">
                    📦 <span class="text-gradient">Đơn hàng của bạn</span>
                </h1>

                @if($orders->count() > 0)
                    <div class="space-y-4">
                        @foreach($orders as $order)
                            <div class="bg-black/30 border border-white/5 rounded-2xl p-6 hover:border-white/20 transition-all">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4 pb-4 border-b border-white/5">
                                    <div>
                                        <h3 class="font-bold text-white text-lg hover:text-brand-glow transition-colors">
                                            <a href="{{ route('profile.orders.show', $order->id) }}">#{{ $order->code }}</a>
                                        </h3>
                                        <p class="text-brand-muted text-xs">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div class="text-left sm:text-right">
                                        <p class="text-brand-glow font-black text-xl">{{ number_format($order->total_price, 0, ',', '.') }}đ</p>
                                        <p class="text-xs uppercase font-extrabold mt-1
                                            {{ $order->status == 'pending' ? 'text-yellow-400' : '' }}
                                            {{ $order->status == 'processing' ? 'text-blue-400' : '' }}
                                            {{ $order->status == 'completed' ? 'text-green-400' : '' }}
                                            {{ $order->status == 'cancelled' ? 'text-red-400' : '' }}">
                                            @if($order->status == 'pending') Đang chờ xử lý
                                            @elseif($order->status == 'processing') Đang xử lý
                                            @elseif($order->status == 'completed') Hoàn thành
                                            @elseif($order->status == 'cancelled') Đã huỷ
                                            @else {{ $order->status }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-brand-muted">
                                        Gồm {{ $order->orderItems->sum('quantity') }} sản phẩm
                                    </p>
                                    <a href="{{ route('profile.orders.show', $order->id) }}" class="text-xs font-bold text-brand-glow hover:text-white transition-colors flex items-center gap-1 uppercase tracking-wider">
                                        Chi tiết <span class="material-symbols-outlined text-xs">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-8">
                        {{ $orders->links('pagination::tailwind') }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <span class="material-symbols-outlined text-6xl text-brand-muted/30 mb-4">remove_shopping_cart</span>
                        <p class="text-brand-muted font-medium mb-6">Bạn chưa có đơn hàng nào.</p>
                        <a href="{{ route('shop.index') }}" class="inline-flex glass-button items-center">
                            Tiếp tục mua sắm
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
    </div>
</div>
@endsection
