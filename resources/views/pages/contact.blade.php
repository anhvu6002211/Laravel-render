@extends('layouts.app')

@section('title', 'Liên hệ với Vuxshop')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-20">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-20">
        <!-- Info Column -->
        <div class="space-y-12">
            <div class="space-y-6">
                <h1 class="text-6xl font-black text-white leading-tight">Gửi lời nhắn<br/>đến <span class="text-gradient">Vuxshop</span>.</h1>
                <p class="text-xl text-brand-muted leading-relaxed">Chúng tôi luôn lắng nghe và sẵn sàng hỗ trợ bạn mọi lúc mọi nơi. Đừng ngần ngại liên hệ!</p>
            </div>

            <div class="space-y-8">
                <div class="flex items-center gap-6 p-6 bg-glass border border-white/5 rounded-3xl group hover:bg-white/[0.05] transition-all">
                    <div class="w-14 h-14 bg-brand-glow/20 rounded-2xl flex items-center justify-center text-brand-glow group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-2xl font-black">call</span>
                    </div>
                    <div>
                        <p class="text-brand-muted text-xs font-black uppercase tracking-widest">Hotline 24/7</p>
                        <p class="text-xl font-bold text-white">1900 6868</p>
                    </div>
                </div>

                <div class="flex items-center gap-6 p-6 bg-glass border border-white/5 rounded-3xl group hover:bg-white/[0.05] transition-all">
                    <div class="w-14 h-14 bg-[#f3a2c5]/20 rounded-2xl flex items-center justify-center text-[#f3a2c5] group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-2xl font-black">mail</span>
                    </div>
                    <div>
                        <p class="text-brand-muted text-xs font-black uppercase tracking-widest">Email hỗ trợ</p>
                        <p class="text-xl font-bold text-white">support@vuxshop.vn</p>
                    </div>
                </div>

                <div class="flex items-center gap-6 p-6 bg-glass border border-white/5 rounded-3xl group hover:bg-white/[0.05] transition-all">
                    <div class="w-14 h-14 bg-blue-400/20 rounded-2xl flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-2xl font-black">location_on</span>
                    </div>
                    <div>
                        <p class="text-brand-muted text-xs font-black uppercase tracking-widest">Trụ sở chính</p>
                        <p class="text-lg font-bold text-white">70 Lữ Gia, Phường 15, Quận 11, TP. HCM</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Column -->
        <div class="bg-glass p-12 rounded-[3rem] border border-white/5 relative shadow-2xl">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-glow/5 to-transparent rounded-[3rem]"></div>
            <form action="#" class="relative z-10 space-y-8">
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black uppercase tracking-widest text-brand-muted ml-2">Họ và tên</label>
                            <input type="text" placeholder="Nguyễn Văn A" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white focus:outline-none focus:ring-2 focus:ring-brand-glow/20 transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black uppercase tracking-widest text-brand-muted ml-2">Email</label>
                            <input type="email" placeholder="example@mail.com" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white focus:outline-none focus:ring-2 focus:ring-brand-glow/20 transition-all">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-brand-muted ml-2">Chủ đề</label>
                        <select class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white focus:outline-none focus:ring-2 focus:ring-brand-glow/20 transition-all appearance-none">
                            <option>Hỗ trợ kỹ thuật</option>
                            <option>Tư vấn mua hàng</option>
                            <option>Bảo hành & Sửa chữa</option>
                            <option>Hợp tác kinh doanh</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase tracking-widest text-brand-muted ml-2">Nội dung</label>
                        <textarea rows="5" placeholder="Bạn cần hỗ trợ gì?" class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white focus:outline-none focus:ring-2 focus:ring-brand-glow/20 transition-all resize-none"></textarea>
                    </div>
                </div>
                <button type="button" class="w-full bg-gradient-to-r from-[#cfafed] to-[#f3a2c5] text-black font-extrabold py-5 rounded-[1.5rem] hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-brand-glow/20">
                    Gửi yêu cầu ngay
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
