@extends('layouts.app')
@section('title', 'Đăng ký — Vuxshop')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-6 py-20 relative">
    <!-- Abstract Background Shapers -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-glow2/10 blur-[120px] rounded-full pointer-events-none"></div>
    
    <div class="w-full max-w-md relative">
        <div class="bg-glass rounded-[2.5rem] border border-white/10 p-10 md:p-12 shadow-2xl relative overflow-hidden backdrop-blur-3xl">
            <!-- Decorative line -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-brand-glow2 to-transparent opacity-50"></div>

            <div class="text-center space-y-2 mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/5 border border-white/10 mb-4 group hover:rotate-12 transition-transform">
                    <span class="material-symbols-outlined text-3xl text-brand-glow group-hover:scale-110 transition-transform">rocket_launch</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Tạo <span class="text-gradient">tài khoản</span></h1>
                <p class="text-brand-muted font-medium">Tham gia cộng đồng công nghệ Vuxshop</p>
            </div>

            <!-- Perks -->
            <div class="grid grid-cols-2 gap-3 mb-8">
                @foreach([
                    ['🎁', 'Voucher 10%'],
                    ['🚚', 'Freeship'],
                    ['🔔', 'Ưu đãi hời'],
                    ['🛡️', 'Bảo hành+']
                ] as [$icon, $label])
                <div class="bg-white/5 border border-white/5 rounded-xl p-3 flex items-center gap-3">
                    <span class="text-lg">{{ $icon }}</span>
                    <span class="text-[10px] font-bold text-white/70 uppercase tracking-tight">{{ $label }}</span>
                </div>
                @endforeach
            </div>

            <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-brand-muted ml-1" for="reg-email">Email *</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-glow transition-colors text-xl">mail</span>
                        <input id="reg-email" type="email" name="email" 
                               class="w-full bg-black/40 border border-white/10 rounded-2xl pl-12 pr-6 py-4 text-white placeholder:text-gray-600 focus:outline-none focus:border-brand-glow focus:ring-1 focus:ring-brand-glow transition-all {{ $errors->has('email') ? 'border-red-500/50 ring-1 ring-red-500/50' : '' }}"
                               placeholder="you@example.com" value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email')<p class="text-red-400 text-xs font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-brand-muted ml-1" for="reg-password">Mật khẩu *</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-glow transition-colors text-xl">lock_open</span>
                        <input id="reg-password" type="password" name="password" 
                               class="w-full bg-black/40 border border-white/10 rounded-2xl pl-12 pr-6 py-4 text-white placeholder:text-gray-600 focus:outline-none focus:border-brand-glow focus:ring-1 focus:ring-brand-glow transition-all {{ $errors->has('password') ? 'border-red-500/50 ring-1 ring-red-500/50' : '' }}"
                               placeholder="Tối thiểu 6 ký tự" required>
                    </div>
                    @error('password')<p class="text-red-400 text-xs font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-brand-muted ml-1" for="reg-password-confirm">Xác nhận mật khẩu *</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-glow transition-colors text-xl">lock</span>
                        <input id="reg-password-confirm" type="password" name="password_confirmation" 
                               class="w-full bg-black/40 border border-white/10 rounded-2xl pl-12 pr-6 py-4 text-white placeholder:text-gray-600 focus:outline-none focus:border-brand-glow focus:ring-1 focus:ring-brand-glow transition-all"
                               placeholder="Nhập lại mật khẩu" required>
                    </div>
                </div>

                <div class="flex items-start gap-3 px-1">
                    <input type="checkbox" id="terms" required class="mt-1 w-4 h-4 rounded border-white/10 bg-black/40 text-brand-glow focus:ring-brand-glow cursor-pointer">
                    <label for="terms" class="text-[11px] font-bold text-brand-muted leading-relaxed cursor-pointer hover:text-white transition-colors">
                        Tôi đồng ý với <a href="#" class="text-brand-glow hover:underline">Điều khoản dịch vụ</a> và <a href="#" class="text-brand-glow hover:underline">Chính sách bảo mật</a>
                    </label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-[#cfafed] to-[#f3a2c5] text-black font-extrabold py-4 rounded-2xl flex items-center justify-center gap-3 hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-brand-glow/20 mt-4">
                    Tạo tài khoản ngay
                    <span class="material-symbols-outlined font-bold">rocket_launch</span>
                </button>
            </form>

            <div class="mt-10 pt-8 border-t border-white/5 text-center">
                <p class="text-brand-muted text-sm font-medium">
                    Đã có tài khoản? 
                    <a href="{{ route('login') }}" class="text-brand-glow font-bold hover:underline">Đăng nhập</a>
                </p>
            </div>
        </div>
        
        <!-- Decoration -->
        <div class="absolute -bottom-6 -left-6 w-24 h-24 bg-brand-glow2/30 blur-[40px] rounded-full -z-10 animate-pulse"></div>
    </div>
</div>
@endsection
