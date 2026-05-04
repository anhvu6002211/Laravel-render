@extends('layouts.app')
@section('title', 'Chi tiết đơn hàng #' . $order->code . ' — Vuxshop')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-brand-muted mb-8">
        <a href="{{ route('profile.index') }}" class="hover:text-white transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">person</span> Tài khoản
        </a>
        <span class="material-symbols-outlined text-xs">chevron_right</span>
        <span class="text-white font-medium">Đơn hàng #{{ $order->code }}</span>
    </nav>

    <div class="bg-glass rounded-[2rem] border border-white/10 overflow-hidden shadow-2xl relative">
        <div class="absolute -top-32 -right-32 w-64 h-64 bg-brand-glow/20 blur-[80px] rounded-full pointer-events-none"></div>
        
        <!-- Header -->
        <div class="p-8 md:p-10 border-b border-white/10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
            <div>
                <h1 class="text-2xl font-black text-white mb-2 uppercase tracking-wide cursor-text">Đơn hàng <span class="text-gradient">#{{ $order->code }}</span></h1>
                <p class="text-brand-muted text-sm font-medium">Đặt lúc: {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            
            <div class="px-6 py-2 rounded-full border border-white/10 font-bold uppercase tracking-wider text-xs 
                {{ $order->status == 'pending' ? 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' : '' }}
                {{ $order->status == 'processing' ? 'bg-blue-500/10 text-blue-400 border-blue-500/20' : '' }}
                {{ $order->status == 'completed' ? 'bg-green-500/10 text-green-400 border-green-500/20' : '' }}
                {{ $order->status == 'cancelled' ? 'bg-red-500/10 text-red-400 border-red-500/20' : '' }}">
                @if($order->status == 'pending') Đang chờ xử lý
                @elseif($order->status == 'processing') Đang xử lý
                @elseif($order->status == 'completed') Hoàn thành
                @elseif($order->status == 'cancelled') Đã huỷ
                @else {{ $order->status }}
                @endif
            </div>
        </div>

        <div class="p-8 md:p-10 grid grid-cols-1 md:grid-cols-2 gap-12 relative z-10">
            <!-- Customer Info -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-white flex items-center gap-2 border-b border-white/5 pb-3">
                    <span class="material-symbols-outlined text-brand-glow">account_circle</span>
                    Thông tin nhận hàng
                </h3>
                <div class="space-y-4 text-sm bg-black/20 p-6 rounded-2xl border border-white/5">
                    <div class="flex justify-between"><span class="text-brand-muted">Họ tên:</span> <span class="text-white font-medium">{{ $order->first_name }} {{ $order->last_name }}</span></div>
                    <div class="flex justify-between"><span class="text-brand-muted">Số điện thoại:</span> <span class="text-white font-medium">{{ $order->phone }}</span></div>
                    <div class="flex justify-between"><span class="text-brand-muted">Email:</span> <span class="text-white font-medium">{{ $order->email }}</span></div>
                    <div class="flex flex-col gap-1 mt-2">
                        <span class="text-brand-muted">Địa chỉ giao hàng:</span> 
                        <span class="text-white font-medium leading-relaxed">{{ $order->address }}, {{ $order->city }} {{ $order->zip ? '- '.$order->zip : '' }}</span>
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div class="space-y-6">
                <h3 class="text-lg font-bold text-white flex items-center gap-2 border-b border-white/5 pb-3">
                    <span class="material-symbols-outlined text-brand-glow">inventory_2</span>
                    Sản phẩm
                </h3>
                
                <div class="space-y-4">
                    @foreach($order->orderItems as $item)
                        <div class="flex items-center gap-4 bg-black/20 p-4 rounded-2xl border border-white/5">
                            <div class="w-16 h-16 bg-white/5 rounded-xl p-1 flex-shrink-0">
                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-full h-full object-contain" onerror="this.src='https://via.placeholder.com/64'">
                            </div>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('products.show', $item->product->id) }}" class="text-white font-bold text-sm hover:text-brand-glow transition-colors line-clamp-2">
                                    {{ $item->product->name }}
                                </a>
                                <p class="text-brand-muted text-xs mt-1">{{ number_format($item->price, 0, ',', '.') }}đ × {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-white font-bold text-sm">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-black/40 border-t border-white/10 p-8 md:p-10 flex flex-col items-end gap-2 relative z-10">
            <div class="flex justify-between w-full md:w-1/2 text-sm text-brand-muted mb-2">
                <span>Trạng thái thanh toán:</span>
                <span class="text-white font-medium uppercase">{{ $order->status == 'pending' ? 'Chưa thanh toán' : 'Đã thanh toán' }}</span>
            </div>
            <div class="flex justify-between w-full md:w-1/2 items-end mt-2 pt-4 border-t border-white/5">
                <span class="text-white font-bold text-lg">Tổng cộng:</span>
                <span class="text-2xl md:text-3xl font-black text-gradient">{{ number_format($order->total_price, 0, ',', '.') }}đ</span>
            </div>
        </div>
    </div>
</div>
@endsection
