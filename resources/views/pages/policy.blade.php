@extends('layouts.app')

@section('title', $title . ' — Vuxshop')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-16">
    <div class="flex flex-col lg:flex-row gap-16">
        <!-- Sidebar Navigation -->
        <aside class="lg:w-1/4">
            <div class="sticky top-[100px] space-y-8">
                <div class="space-y-2">
                    <h2 class="text-sm font-black text-brand-muted uppercase tracking-[0.2em] ml-2">Thông tin chính sách</h2>
                    <div class="space-y-2">
                        <a href="{{ route('pages.warranty') }}" class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ $type === 'warranty' ? 'bg-brand-glow text-black font-extrabold' : 'bg-glass text-white hover:bg-white/10' }}">
                            <span class="material-symbols-outlined">verified_user</span>
                            Chính sách bảo hành
                        </a>
                        <a href="{{ route('pages.returns') }}" class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ $type === 'returns' ? 'bg-brand-glow text-black font-extrabold' : 'bg-glass text-white hover:bg-white/10' }}">
                            <span class="material-symbols-outlined">restart_alt</span>
                            Chính sách đổi trả
                        </a>
                        <a href="{{ route('pages.shipping') }}" class="flex items-center gap-4 p-4 rounded-2xl transition-all {{ $type === 'shipping' ? 'bg-brand-glow text-black font-extrabold' : 'bg-glass text-white hover:bg-white/10' }}">
                            <span class="material-symbols-outlined">local_shipping</span>
                            Chính sách vận chuyển
                        </a>
                    </div>
                </div>

                <div class="bg-glass p-6 rounded-3xl border border-white/5 space-y-4">
                    <h4 class="text-white font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-brand-glow">headset_mic</span>
                        Cần hỗ trợ?
                    </h4>
                    <p class="text-xs text-brand-muted leading-relaxed">Nếu bạn có bất kỳ thắc mắc nào về chính sách của chúng tôi, vui lòng liên hệ hotline: <strong class="text-white">1900 6868</strong></p>
                    <a href="{{ route('pages.contact') }}" class="block text-center py-3 bg-white/5 rounded-xl text-xs font-bold text-white hover:bg-white/10 transition-all border border-white/10 italic">Liên hệ bộ phận CSKH</a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="lg:w-3/4 space-y-12">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 bg-brand-glow/20 rounded-3xl flex items-center justify-center text-brand-glow">
                    <span class="material-symbols-outlined text-3xl font-black">{{ $icon }}</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-white italic tracking-tighter uppercase">{{ $title }}</h1>
            </div>

            <div class="bg-glass border border-white/5 rounded-[2.5rem] p-8 md:p-12 space-y-12 backdrop-blur-3xl shadow-2xl overflow-hidden relative">
                <div class="absolute top-0 right-0 w-64 h-64 bg-brand-glow/5 blur-[100px] -mr-32 -mt-32"></div>

                <article class="prose prose-invert max-w-none prose-headings:text-white prose-headings:font-black prose-p:text-brand-muted prose-p:leading-relaxed prose-strong:text-white prose-ul:text-brand-muted">
                    @if($type === 'warranty')
                        <h2>1. Thời hạn bảo hành</h2>
                        <p>Tất cả sản phẩm chính hãng mua tại Vuxshop được bảo hành 12 tháng kể từ ngày kích hoạt sản phẩm hoặc ngày mua hàng (tùy điều kiện nào đến trước).</p>
                        
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 my-8">
                            <h4 class="m-0 text-brand-glow font-black uppercase text-sm mb-4">Danh mục đặc biệt</h4>
                            <ul class="m-0 space-y-2">
                                <li><strong>Phụ kiện Apple:</strong> Bảo hành 1 đổi 1 trong 12 tháng.</li>
                                <li><strong>Pin điện thoại:</strong> Bảo hành 1 đổi 1 nếu chai trên 20% trong 6 tháng.</li>
                                <li><strong>Thiết bị đeo:</strong> Bảo hành 12 tháng tại các trung tâm ủy quyền.</li>
                            </ul>
                        </div>

                        <h2>2. Trường hợp không được bảo hành</h2>
                        <ul>
                            <li>Sản phẩm đã hết thời hạn bảo hành.</li>
                            <li>Sản phẩm có dấu hiệu tự ý tháo dỡ, sửa chữa bởi các bên không thuộc hệ thống Vuxshop.</li>
                            <li>Sản phẩm bị hư hỏng do tác động ngoại lực (rơi vỡ, cấn móp, ngấm nước).</li>
                            <li>Hư hỏng do sử dụng phụ kiện không chính hãng hoặc không đúng quy cách.</li>
                        </ul>
                    @endif

                    @if($type === 'returns')
                        <h2>1. Chính sách đổi mới trong 30 ngày</h2>
                        <p>Vuxshop áp dụng chính sách <strong>1 ĐỔI 1 TRONG 30 NGÀY</strong> đầu tiên nếu sản phẩm phát sinh lỗi từ phía nhà sản xuất.</p>

                        <table class="w-full text-sm border-collapse">
                            <thead>
                                <tr class="bg-white/5">
                                    <th class="p-4 text-left font-black text-white border border-white/10">Tình trạng</th>
                                    <th class="p-4 text-left font-black text-white border border-white/10">Giải pháp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-4 border border-white/10">Lỗi phần cứng NSX</td>
                                    <td class="p-4 border border-white/10">Đổi máy mới tương đương</td>
                                </tr>
                                <tr>
                                    <td class="p-4 border border-white/10">Sản phẩm không lỗi</td>
                                    <td class="p-4 border border-white/10">Thu lại giá 80% (trong 15 ngày đầu)</td>
                                </tr>
                            </tbody>
                        </table>

                        <h2>2. Điều kiện đổi trả</h2>
                        <ul>
                            <li>Sản phẩm còn đầy đủ hộp (box) và phụ kiện đi kèm.</li>
                            <li>Sản phẩm không bị trầy xước, móp méo, hoặc có dấu hiệu va đập.</li>
                            <li>Quà tặng đi kèm (nếu có) phải còn nguyên vẹn hoặc quy đổi thành tiền mặt.</li>
                        </ul>
                    @endif

                    @if($type === 'shipping')
                        <h2>1. Phương thức vận chuyển</h2>
                        <p>Vuxshop hợp tác với các đơn vị vận chuyển uy tín (Giao Hàng Nhanh, Viettel Post) để đảm bảo hàng hóa đến tay khách hàng an toàn và nhanh chóng nhất.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
                            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                                <h4 class="text-brand-glow font-black text-lg mb-2">Giao hàng hỏa tốc</h4>
                                <p class="text-sm m-0">Nhận hàng trong 2 giờ tại nội thành TP. HCM và Hà Nội. Phí ship linh hoạt.</p>
                            </div>
                            <div class="bg-white/5 border border-white/10 rounded-2xl p-6">
                                <h4 class="text-white font-black text-lg mb-2">Giao hàng tiêu chuẩn</h4>
                                <p class="text-sm m-0">Nhận hàng sau 2-4 ngày trên toàn quốc. <strong>MIỄN PHÍ</strong> đơn hàng từ 1.000.000đ.</p>
                            </div>
                        </div>

                        <h2>2. Kiểm tra hàng hóa</h2>
                        <p>Khách hàng được quyền <strong>MỞ HỘP KIỂM TRA</strong> hàng trước khi thanh toán cho nhân viên giao hàng. Vui lòng quay clip khi mở hộp để được hỗ trợ tốt nhất nếu có khiếu nại.</p>
                    @endif
                </article>
            </div>
        </main>
    </div>
</div>
@endsection
