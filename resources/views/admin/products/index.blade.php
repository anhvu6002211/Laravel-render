@extends('admin.layout')

@section('page_title', 'Danh sách sản phẩm')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-black text-white mb-2">Sản phẩm</h1>
            <p class="text-brand-muted font-medium">Quản lý kho hàng và thông tin hiển thị của bạn</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="bg-gradient-to-tr from-[#cfafed] to-[#f3a2c5] text-black font-extrabold px-8 py-4 rounded-2xl flex items-center gap-2 hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-brand-glow/10">
            <span class="material-symbols-outlined font-black">add_circle</span>
            Thêm sản phẩm
        </a>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-glass p-6 rounded-3xl border border-white/5 flex items-center gap-6">
            <div class="w-14 h-14 bg-brand-glow/10 rounded-2xl flex items-center justify-center text-brand-glow">
                <span class="material-symbols-outlined text-3xl">inventory_2</span>
            </div>
            <div>
                <p class="text-brand-muted text-xs uppercase font-black tracking-widest">Tổng sản phẩm</p>
                <p class="text-2xl font-black text-white">{{ $products->total() }}</p>
            </div>
        </div>
        <div class="bg-glass p-6 rounded-3xl border border-white/5 flex items-center gap-6">
            <div class="w-14 h-14 bg-[#f3a2c5]/10 rounded-2xl flex items-center justify-center text-[#f3a2c5]">
                <span class="material-symbols-outlined text-3xl">trending_up</span>
            </div>
            <div>
                <p class="text-brand-muted text-xs uppercase font-black tracking-widest">Lượt xem tổng</p>
                <p class="text-2xl font-black text-white">45.2K</p>
            </div>
        </div>
        <div class="bg-glass p-6 rounded-3xl border border-white/5 flex items-center gap-6">
            <div class="w-14 h-14 bg-green-400/10 rounded-2xl flex items-center justify-center text-green-400">
                <span class="material-symbols-outlined text-3xl">payments</span>
            </div>
            <div>
                <p class="text-brand-muted text-xs uppercase font-black tracking-widest">Giá trị kho</p>
                <p class="text-2xl font-black text-white">1.2B đ</p>
            </div>
        </div>
    </div>

    <!-- Product Table -->
    <div class="bg-glass rounded-[2rem] border border-white/5 overflow-hidden">
        <div class="p-6 border-b border-white/5 flex items-center justify-between">
            <form action="{{ route('admin.products.index') }}" method="GET" class="relative group">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-brand-muted group-focus-within:text-brand-glow transition-colors">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm tên sản phẩm..." class="bg-white/5 rounded-2xl py-3 pl-12 pr-6 text-sm text-white focus:outline-none focus:ring-2 focus:ring-brand-glow/20 w-80 border border-white/5 transition-all">
            </form>
            <div class="flex items-center gap-2">
                <button class="p-3 text-brand-muted hover:text-white transition-colors">
                    <span class="material-symbols-outlined">filter_list</span>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-brand-muted text-[10px] uppercase font-black tracking-widest bg-white/2">
                        <th class="px-8 py-6">Sản phẩm</th>
                        <th class="px-6 py-6">Danh mục</th>
                        <th class="px-6 py-6 text-right">Giá</th>
                        <th class="px-6 py-6 text-center">Số lượng</th>
                        <th class="px-8 py-6 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($products as $product)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center p-2 group-hover:scale-110 transition-transform">
                                        <img src="{{ $product->image }}" class="max-w-full max-h-full object-contain">
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-white group-hover:text-brand-glow transition-colors">{{ $product->name }}</p>
                                        <p class="text-[10px] text-brand-muted font-medium">ID: #PROD{{ $product->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-white/5 rounded-lg text-xs font-bold text-brand-muted">
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <p class="text-sm font-black text-white">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-2 h-2 rounded-full {{ $product->stock > 10 ? 'bg-green-400' : 'bg-orange-400' }}"></div>
                                    <p class="text-sm font-bold text-white">{{ $product->stock }}</p>
                                </div>
                            </td>
                            <td class="px-8 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="w-10 h-10 flex items-center justify-center bg-white/5 hover:bg-brand-glow/20 text-brand-muted hover:text-brand-glow rounded-xl transition-all">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="w-10 h-10 flex items-center justify-center bg-white/5 hover:bg-red-500/20 text-brand-muted hover:text-red-400 rounded-xl transition-all">
                                            <span class="material-symbols-outlined text-lg">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center gap-4 opacity-30">
                                    <span class="material-symbols-outlined text-6xl">inventory_2</span>
                                    <p class="font-bold">Không tìm thấy sản phẩm nào</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-6 bg-white/[0.01] border-t border-white/5">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
