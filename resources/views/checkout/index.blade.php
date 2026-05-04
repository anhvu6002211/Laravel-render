@extends('layouts.app')
@section('title', 'Thanh toán — Vuxshop')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-brand-muted mb-12">
        <a href="{{ route('cart.index') }}" class="hover:text-white transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">shopping_cart</span> Giỏ hàng
        </a>
        <span class="material-symbols-outlined text-xs">chevron_right</span>
        <span class="text-white font-medium">Thanh toán</span>
    </nav>

    <h1 class="text-4xl font-extrabold text-white mb-12">
        💳 <span class="text-gradient">Thanh toán</span> đơn hàng
    </h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
            
            <!-- Left: Shipping & Payment Info -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Shipping Form -->
                <div class="bg-glass rounded-[2rem] border border-white/10 p-10 space-y-8 shadow-2xl">
                    <h2 class="text-xl font-bold text-white flex items-center gap-3 border-b border-white/5 pb-4">
                        <span class="material-symbols-outlined text-brand-glow">local_shipping</span>
                        Thông tin giao hàng
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-brand-muted ml-1">Họ *</label>
                            <input type="text" name="last_name" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder:text-gray-600 focus:outline-none focus:border-brand-glow focus:ring-1 focus:ring-brand-glow transition-all {{ $errors->has('last_name') ? 'border-red-500/50 ring-1 ring-red-500/50' : '' }}"
                                   placeholder="Nguyễn" value="{{ old('last_name') }}" required>
                            @error('last_name')<p class="text-red-400 text-xs font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-brand-muted ml-1">Tên *</label>
                            <input type="text" name="first_name" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder:text-gray-600 focus:outline-none focus:border-brand-glow focus:ring-1 focus:ring-brand-glow transition-all {{ $errors->has('first_name') ? 'border-red-500/50 ring-1 ring-red-500/50' : '' }}"
                                   placeholder="Văn An" value="{{ old('first_name') }}" required>
                            @error('first_name')<p class="text-red-400 text-xs font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-brand-muted ml-1">Email *</label>
                            <input type="email" name="email" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder:text-gray-600 focus:outline-none focus:border-brand-glow focus:ring-1 focus:ring-brand-glow transition-all {{ $errors->has('email') ? 'border-red-500/50 ring-1 ring-red-500/50' : '' }}"
                                   placeholder="email@example.com" value="{{ old('email', $user?->email) }}" required>
                            @error('email')<p class="text-red-400 text-xs font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-brand-muted ml-1">Số điện thoại *</label>
                            <input type="tel" name="phone" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder:text-gray-600 focus:outline-none focus:border-brand-glow focus:ring-1 focus:ring-brand-glow transition-all {{ $errors->has('phone') ? 'border-red-500/50 ring-1 ring-red-500/50' : '' }}"
                                   placeholder="0912 345 678" value="{{ old('phone') }}" required>
                            @error('phone')<p class="text-red-400 text-xs font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-brand-muted ml-1">Địa chỉ giao hàng *</label>
                        <input type="text" name="address" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder:text-gray-600 focus:outline-none focus:border-brand-glow focus:ring-1 focus:ring-brand-glow transition-all {{ $errors->has('address') ? 'border-red-500/50 ring-1 ring-red-500/50' : '' }}"
                               placeholder="Số nhà, tên đường, phường/xã..." value="{{ old('address') }}" required>
                        @error('address')<p class="text-red-400 text-xs font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-brand-muted ml-1">Thành phố *</label>
                            <input type="text" name="city" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder:text-gray-600 focus:outline-none focus:border-brand-glow focus:ring-1 focus:ring-brand-glow transition-all {{ $errors->has('city') ? 'border-red-500/50 ring-1 ring-red-500/50' : '' }}"
                                   placeholder="Hà Nội" value="{{ old('city') }}" required>
                            @error('city')<p class="text-red-400 text-xs font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-brand-muted ml-1">Mã bưu chính</label>
                            <input type="text" name="zip" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 text-white placeholder:text-gray-600 focus:outline-none focus:border-brand-glow focus:ring-1 focus:ring-brand-glow transition-all" 
                                   placeholder="100000" value="{{ old('zip') }}">
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="bg-glass rounded-[2rem] border border-white/10 p-10 space-y-8 shadow-2xl">
                    <h2 class="text-xl font-bold text-white flex items-center gap-3 border-b border-white/5 pb-4">
                        <span class="material-symbols-outlined text-brand-glow">payments</span>
                        Phương thức thanh toán
                    </h2>

                    <div class="grid grid-cols-1 gap-4">
                        @foreach([
                            ['cod', '💵', 'Thanh toán khi nhận hàng (COD)', 'Nhận hàng rồi mới thanh toán tiền mặt.'],
                            ['bank', '🏦', 'Chuyển khoản ngân hàng', 'Quét mã QR hoặc chuyển khoản qua ứng dụng ngân hàng.'],
                            ['momo', '📱', 'Ví MoMo', 'Thanh toán nhanh chóng qua ví điện tử MoMo.']
                        ] as [$val, $icon, $label, $desc])
                        <label class="relative flex items-center gap-6 bg-black/30 border border-white/10 rounded-3xl p-6 cursor-pointer hover:border-brand-glow/50 transition-all group">
                            <input type="radio" name="payment_method" value="{{ $val }}" {{ $val=='cod'?'checked':'' }} class="w-5 h-5 accent-brand-glow">
                            <div class="w-14 h-14 bg-white/5 rounded-2xl flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
                                {{ $icon }}
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-bold">{{ $label }}</p>
                                <p class="text-brand-muted text-xs font-medium">{{ $desc }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="lg:sticky lg:top-[120px] space-y-6">
                <div class="bg-glass rounded-[2rem] border border-white/10 overflow-hidden shadow-2xl relative">
                    <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-brand-glow/10 blur-[60px] rounded-full"></div>
                    
                    <div class="bg-gradient-to-r from-brand-glow/20 to-brand-glow2/20 px-8 py-6 border-b border-white/10">
                        <h2 class="text-white font-extrabold text-lg flex items-center gap-3">
                            <span class="material-symbols-outlined">inventory_2</span>
                            Đơn hàng
                        </h2>
                    </div>

                    <div class="p-8 space-y-6 relative">
                        <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($cartItems as $item)
                                <div class="flex gap-4 items-center">
                                    <div class="w-14 h-14 bg-white/5 rounded-xl border border-white/5 p-1 flex-shrink-0">
                                        <img src="{{ $item['product']->image }}" alt="{{ $item['product']->name }}"
                                             class="w-full h-full object-contain"
                                             onerror="this.src='https://via.placeholder.com/56/1e1e2e/7c3aed?text=📦'">
                                    </div>
                                    <div class="flex-1 min-width-0">
                                        <p class="text-white font-bold text-xs truncate">{{ $item['product']->name }}</p>
                                        <p class="text-brand-muted text-[10px] font-bold uppercase tracking-wider">× {{ $item['quantity'] }}</p>
                                    </div>
                                    <p class="text-white font-bold text-xs">{{ number_format($item['subtotal'], 0, ',', '.') }}đ</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="pt-6 border-t border-white/5 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-brand-muted font-medium">Tạm tính</span>
                                <span class="text-white font-bold">{{ number_format($total, 0, ',', '.') }}đ</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-brand-muted font-medium">Vận chuyển</span>
                                <span class="text-green-400 font-bold uppercase tracking-tighter">Miễn phí</span>
                            </div>
                            
                            <div class="pt-6 flex justify-between items-end border-t border-white/5 mt-4">
                                <span class="text-white font-extrabold">Tổng cộng</span>
                                <div class="text-2xl font-black text-gradient">{{ number_format($total, 0, ',', '.') }}đ</div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-[#cfafed] to-[#f3a2c5] text-black font-extrabold py-5 rounded-2xl flex items-center justify-center gap-3 hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-brand-glow/20 mt-4">
                            ✅ Hoàn tất đặt hàng
                        </button>
                        
                        <div class="text-center space-y-1">
                            <p class="text-[10px] font-bold text-brand-muted uppercase tracking-widest">
                                <span class="material-symbols-outlined text-[10px] align-middle">lock</span> 
                                Bảo mật mã hóa SSL
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Guarantee -->
                <div class="bg-white/5 rounded-2xl p-6 border border-white/5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-500/10 flex items-center justify-center text-green-400">
                        <span class="material-symbols-outlined">verified</span>
                    </div>
                    <div>
                        <p class="text-white font-bold text-sm">Cam kết chính hãng</p>
                        <p class="text-brand-muted text-xs">Đổi trả trong vòng 7 ngày nếu lỗi</p>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
</style>
@endsection
