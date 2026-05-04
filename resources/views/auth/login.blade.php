@extends('layouts.app')
@section('title', 'Đăng nhập — Vuxshop')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-6 py-20 relative">
    <!-- Abstract Background Shapers -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-glow/10 blur-[120px] rounded-full pointer-events-none"></div>
    
    <div class="w-full max-w-md relative">
        <div class="bg-glass rounded-[2.5rem] border border-white/10 p-10 md:p-12 shadow-2xl relative overflow-hidden backdrop-blur-3xl">
            <!-- Decorative line -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-brand-glow to-transparent opacity-50"></div>

            <div class="text-center space-y-2 mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/5 border border-white/10 mb-4 group hover:rotate-12 transition-transform">
                    <span class="material-symbols-outlined text-3xl text-brand-glow group-hover:scale-110 transition-transform">bolt</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Chào mừng <span class="text-gradient">trở lại!</span></h1>
                <p class="text-brand-muted font-medium">Đăng nhập vào tài khoản Vuxshop của bạn</p>
            </div>

            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-brand-muted ml-1" for="email">Email</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-glow transition-colors text-xl">mail</span>
                        <input id="email" type="email" name="email" 
                               class="w-full bg-black/40 border border-white/10 rounded-2xl pl-12 pr-6 py-4 text-white placeholder:text-gray-600 focus:outline-none focus:border-brand-glow focus:ring-1 focus:ring-brand-glow transition-all {{ $errors->has('email') ? 'border-red-500/50 ring-1 ring-red-500/50' : '' }}"
                               placeholder="you@example.com" value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email')<p class="text-red-400 text-xs font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-xs font-bold uppercase tracking-widest text-brand-muted" for="password">Mật khẩu</label>
                        <a href="#" class="text-[10px] font-bold text-brand-glow uppercase tracking-tighter hover:underline">Quên mật khẩu?</a>
                    </div>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-glow transition-colors text-xl">lock</span>
                        <input id="password" type="password" name="password" 
                               class="w-full bg-black/40 border border-white/10 rounded-2xl pl-12 pr-6 py-4 text-white placeholder:text-gray-600 focus:outline-none focus:border-brand-glow focus:ring-1 focus:ring-brand-glow transition-all {{ $errors->has('password') ? 'border-red-500/50 ring-1 ring-red-500/50' : '' }}"
                               placeholder="••••••••" required>
                    </div>
                    @error('password')<p class="text-red-400 text-xs font-medium mt-1 ml-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center gap-3 px-1">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-white/10 bg-black/40 text-brand-glow focus:ring-brand-glow cursor-pointer">
                    <label for="remember" class="text-xs font-bold text-brand-muted cursor-pointer hover:text-white transition-colors">Ghi nhớ đăng nhập</label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-[#cfafed] to-[#f3a2c5] text-black font-extrabold py-4 rounded-2xl flex items-center justify-center gap-3 hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-brand-glow/20 mt-4">
                    Đăng nhập ngay
                    <span class="material-symbols-outlined font-bold">trending_flat</span>
                </button>
            </form>

            <div class="mt-10 pt-8 border-t border-white/5 text-center space-y-6">
                <p class="text-brand-muted text-sm font-medium">
                    Chưa có tài khoản? 
                    <a href="{{ route('register') }}" class="text-brand-glow font-bold hover:underline">Đăng ký mới</a>
                </p>
                
                <div class="bg-white/5 rounded-2xl p-4 border border-white/5 space-y-1">
                    <p class="text-[10px] font-bold text-brand-muted uppercase tracking-widest flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-xs">info</span> Tài khoản Demo
                    </p>
                    <div class="text-xs font-medium space-x-2">
                        <span class="text-white">admin@vuxshop.vn</span>
                        <span class="text-brand-muted">/</span>
                        <span class="text-white">password</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Decoration -->
        <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-brand-glow/30 blur-[40px] rounded-full -z-10 animate-pulse"></div>
    </div>
</div>
@endsection
