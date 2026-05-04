@extends('layouts.app')

@section('title', 'Giới thiệu về Vuxshop')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-20 space-y-24">
    <!-- Hero Section -->
    <div class="text-center space-y-6">
        <div class="inline-flex items-center gap-3 px-4 py-2 bg-brand-glow/10 border border-brand-glow/20 rounded-full mb-4">
            <span class="material-symbols-outlined text-brand-glow text-sm">stars</span>
            <span class="text-brand-glow text-xs font-black uppercase tracking-[0.2em]">Our Story</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-black text-white leading-tight">Mang công nghệ vươn tầm <span class="text-gradient">đẳng cấp</span>.</h1>
        <p class="text-xl text-brand-muted max-w-2xl mx-auto leading-relaxed">Vuxshop được ra đời với sứ mệnh mang đến những thiết bị công nghệ tiên tiến nhất, giúp nâng tầm trải nghiệm cuộc sống của người Việt.</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-glass p-8 rounded-[2rem] border border-white/5 text-center space-y-2">
            <p class="text-4xl font-black text-white">50k+</p>
            <p class="text-brand-muted text-sm font-bold uppercase tracking-widest">Khách hàng</p>
        </div>
        <div class="bg-glass p-8 rounded-[2rem] border border-white/5 text-center space-y-2">
            <p class="text-4xl font-black text-white">12+</p>
            <p class="text-brand-muted text-sm font-bold uppercase tracking-widest">Cửa hàng</p>
        </div>
        <div class="bg-glass p-8 rounded-[2rem] border border-white/5 text-center space-y-2">
            <p class="text-4xl font-black text-white">100%</p>
            <p class="text-brand-muted text-sm font-bold uppercase tracking-widest">Chính hãng</p>
        </div>
    </div>

    <!-- Mission -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div class="space-y-8">
            <h2 class="text-4xl font-black text-white leading-tight">Cam kết của <span class="text-brand-glow font-display italic">Vuxshop</span></h2>
            <div class="space-y-6">
                <div class="flex gap-6">
                    <div class="w-12 h-12 shrink-0 bg-brand-glow/20 rounded-2xl flex items-center justify-center text-brand-glow">
                        <span class="material-symbols-outlined font-black">verified</span>
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-lg mb-1">Chất lượng hàng đầu</h4>
                        <p class="text-brand-muted leading-relaxed">Chúng tôi chỉ cung cấp những sản phẩm chính hãng, được kiểm định nghiêm ngặt về chất lượng và độ bền.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="w-12 h-12 shrink-0 bg-[#f3a2c5]/20 rounded-2xl flex items-center justify-center text-[#f3a2c5]">
                        <span class="material-symbols-outlined font-black">support_agent</span>
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-lg mb-1">Hỗ trợ tận tâm</h4>
                        <p class="text-brand-muted leading-relaxed">Đội ngũ kỹ thuật viên giàu kinh nghiệm sẵn sàng giải đáp mọi thắc mắc và hỗ trợ khách hàng 24/7.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-glass rounded-[3rem] p-4 border border-white/5 rotate-3 hover:rotate-0 transition-transform">
            <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&q=80&w=1200" class="rounded-[2.5rem] w-full shadow-2xl">
        </div>
    </div>
</div>
@endsection
