<a href="{{ route('products.show', $product->id) }}" class="product-card group p-4 flex flex-col h-full">
    <div class="flex items-center justify-between">
        <span class="glass-chip text-[10px] font-semibold px-2 py-1 rounded-full text-slate-600">
            {{ $product->category?->name ?? 'Sản phẩm' }}
        </span>
        @if($product->price_old && $product->price_old > $product->price)
            <span class="glass-chip text-[10px] font-bold px-2 py-1 rounded-full text-primary">
                Giảm {{ round((1 - $product->price / $product->price_old) * 100) }}%
            </span>
        @endif
    </div>

    <div class="relative aspect-square rounded-2xl overflow-hidden bg-white/80 mt-3 mb-4 flex items-center justify-center">
        <img alt="{{ $product->name }}" class="w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-500" 
             src="{{ $product->image ?? 'https://via.placeholder.com/400x400.png?text=' . urlencode($product->name) }}" />
        @if($product->stock <= 0)
            <div class="absolute inset-0 bg-white/75 flex items-center justify-center text-xs font-bold text-slate-500">Hết hàng</div>
        @endif
    </div>

    <div class="flex flex-col flex-grow">
        <h3 class="text-sm font-semibold text-slate-800 line-clamp-2 mb-2 leading-tight h-[40px] group-hover:text-primary transition-colors">{{ $product->name }}</h3>
        
        <div class="mt-auto space-y-2">
            <div class="flex items-baseline gap-2 flex-wrap">
                <p class="text-base font-bold text-primary">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                @if($product->price_old && $product->price_old > $product->price)
                    <p class="text-xs text-slate-400 line-through">{{ number_format($product->price_old, 0, ',', '.') }}đ</p>
                @endif
            </div>
            
            <div class="flex items-center justify-between text-[10px] text-slate-500">
                <div class="flex items-center gap-1 text-yellow-500">
                    @for($i = 0; $i < 5; $i++)
                        <span class="material-symbols-outlined text-[12px]" style="font-variation-settings: 'FILL' {{ $i < 4 ? 1 : 0 }}">star</span>
                    @endfor
                    <span class="text-slate-400">(25)</span>
                </div>
                <span>{{ $product->stock > 0 ? 'Còn hàng' : 'Tạm hết' }}</span>
            </div>
        </div>
    </div>
</a>
