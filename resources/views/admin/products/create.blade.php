@extends('admin.layout')

@section('page_title', 'Thêm sản phẩm mới')

@section('content')
<div class="max-w-4xl">
    <div class="flex items-center gap-6 mb-12">
        <a href="{{ route('admin.products.index') }}" class="w-12 h-12 flex items-center justify-center bg-glass rounded-2xl text-brand-muted hover:text-white border border-white/5 transition-all">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="text-4xl font-black text-white mb-2">Tạo sản phẩm</h1>
            <p class="text-brand-muted font-medium">Bắt đầu giới thiệu một tuyệt tác công nghệ mới</p>
        </div>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Info -->
            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="text-xs uppercase font-black tracking-widest text-brand-muted block px-2">Tên sản phẩm</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="VD: iPhone 16 Pro Max" class="w-full bg-glass border border-white/5 rounded-2xl py-4 px-6 text-white focus:outline-none focus:ring-2 focus:ring-brand-glow/20 transition-all">
                    @error('name') <p class="text-red-400 text-xs px-2">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-xs uppercase font-black tracking-widest text-brand-muted block px-2">Giá bán (đ)</label>
                        <input type="number" name="price" value="{{ old('price') }}" placeholder="30000000" class="w-full bg-glass border border-white/5 rounded-2xl py-4 px-6 text-white focus:outline-none focus:ring-2 focus:ring-brand-glow/20 transition-all">
                        @error('price') <p class="text-red-400 text-xs px-2">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs uppercase font-black tracking-widest text-brand-muted block px-2">Số lượng</label>
                        <input type="number" name="stock" value="{{ old('stock', 50) }}" class="w-full bg-glass border border-white/5 rounded-2xl py-4 px-6 text-white focus:outline-none focus:ring-2 focus:ring-brand-glow/20 transition-all">
                        @error('stock') <p class="text-red-400 text-xs px-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs uppercase font-black tracking-widest text-brand-muted block px-2">Danh mục</label>
                    <select name="category_id" class="w-full bg-glass border border-white/5 rounded-2xl py-4 px-6 text-white focus:outline-none focus:ring-2 focus:ring-brand-glow/20 transition-all appearance-none">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-400 text-xs px-2">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Right Info -->
            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="text-xs uppercase font-black tracking-widest text-brand-muted block px-2">URL Hình ảnh</label>
                    <input type="url" name="image" value="{{ old('image') }}" placeholder="https://..." class="w-full bg-glass border border-white/5 rounded-2xl py-4 px-6 text-white focus:outline-none focus:ring-2 focus:ring-brand-glow/20 transition-all">
                    @error('image') <p class="text-red-400 text-xs px-2">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-xs uppercase font-black tracking-widest text-brand-muted block px-2">Mô tả sản phẩm</label>
                    <textarea name="description" rows="5" placeholder="Nhập chi tiết về thông số kỹ thuật, tính năng nổi bật..." class="w-full bg-glass border border-white/5 rounded-2xl py-4 px-6 text-white focus:outline-none focus:ring-2 focus:ring-brand-glow/20 transition-all resize-none">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-400 text-xs px-2">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="pt-8 flex justify-end gap-4">
            <a href="{{ route('admin.products.index') }}" class="px-8 py-4 bg-white/5 text-white font-bold rounded-2xl hover:bg-white/10 transition-all">Hủy bỏ</a>
            <button type="submit" class="bg-gradient-to-tr from-[#cfafed] to-[#f3a2c5] text-black font-extrabold px-12 py-4 rounded-2xl hover:scale-[1.05] transition-all shadow-xl shadow-brand-glow/20">
                Xác nhận tạo
            </button>
        </div>
    </form>
</div>
@endsection
