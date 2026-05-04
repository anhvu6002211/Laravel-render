<div class="max-w-[1100px] mx-auto px-4 py-6 space-y-6">
    <div class="flex items-center gap-2 text-xs text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-primary">Trang chu</a>
        <span>/</span>
        <span class="text-slate-700 font-semibold">Gio hang</span>
    </div>

    @if($itemCount)
        <div class="grid lg:grid-cols-[1fr,320px] gap-6">
            <div class="space-y-4">
                <div class="glass-panel rounded-2xl p-4 flex items-center justify-between">
                    <h2 class="text-sm font-bold text-slate-800">San pham trong gio</h2>
                    <span class="text-xs text-slate-500">{{ $itemCount }} san pham</span>
                </div>

                <div class="glass-panel rounded-2xl overflow-hidden divide-y divide-white/70">
                    @foreach($items as $item)
                        <div class="p-4 flex gap-4">
                            <a href="{{ route('products.show', $item['id']) }}" class="h-20 w-20 glass-chip rounded-2xl flex items-center justify-center">
                                <img src="{{ $item['image'] ?: 'https://via.placeholder.com/100?text=Vuxshop' }}"
                                     alt="{{ $item['name'] }}"
                                     class="max-h-full object-contain p-2">
                            </a>

                            <div class="flex-1 flex flex-col gap-2">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <a href="{{ route('products.show', $item['id']) }}" class="text-sm font-bold text-slate-800 hover:text-primary">
                                            {{ $item['name'] }}
                                        </a>
                                        <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">
                                            {{ $item['category'] ?? 'San pham' }}
                                        </p>
                                    </div>
                                    <button type="button" wire:click="remove({{ $item['id'] }})" class="text-slate-400 hover:text-primary">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </div>

                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <div>
                                        <span class="text-sm font-bold text-primary">
                                            {{ number_format($item['price'], 0, ',', '.') }}d
                                        </span>
                                        @if($item['price_old'] && $item['price_old'] > $item['price'])
                                            <span class="text-[10px] text-slate-400 line-through ml-1">
                                                {{ number_format($item['price_old'], 0, ',', '.') }}d
                                            </span>
                                        @endif
                                        <p class="text-[10px] text-slate-400">Tam tinh: {{ number_format($item['price'] * ($quantities[$item['id']] ?? 0), 0, ',', '.') }}d</p>
                                    </div>

                                    <div class="glass-chip rounded-xl p-1 flex items-center">
                                        <button type="button" class="w-7 h-7 flex items-center justify-center text-slate-500" wire:click="decrease({{ $item['id'] }})">-</button>
                                        <input type="number" min="1" max="99"
                                               class="w-10 bg-transparent text-center text-xs font-bold text-slate-800 focus:outline-none"
                                               wire:model.lazy="quantities.{{ $item['id'] }}">
                                        <button type="button" class="w-7 h-7 flex items-center justify-center text-slate-500" wire:click="increase({{ $item['id'] }})">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="glass-card rounded-2xl p-5">
                    <h3 class="text-sm font-bold text-slate-800 mb-2">Ghi chu don hang</h3>
                    <textarea rows="3" wire:model.defer="note"
                              class="glass-input w-full rounded-xl px-4 py-3 text-xs"
                              placeholder="Vi du: giao hang trong gio hanh chinh..."></textarea>
                    <p class="text-[11px] text-slate-400 mt-2">Ghi chu se duoc luu cho buoc thanh toan.</p>
                </div>

                <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 text-primary font-bold text-xs hover:underline">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Tiep tuc mua hang
                </a>
            </div>

            <div class="space-y-4">
                <div class="glass-panel rounded-2xl p-5 sticky top-24">
                    <h3 class="text-sm font-bold text-slate-800">Tong cong</h3>
                    <div class="mt-4 space-y-3 text-sm text-slate-600">
                        <div class="flex justify-between">
                            <span>Tam tinh</span>
                            <span class="font-bold text-slate-800">{{ number_format($total, 0, ',', '.') }}d</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Phi van chuyen</span>
                            <span class="font-bold text-emerald-500">Mien phi</span>
                        </div>
                        <div class="pt-3 border-t border-white/70 flex justify-between items-end">
                            <span class="font-bold text-slate-800">Tong tien</span>
                            <span class="text-xl font-black text-primary">{{ number_format($total, 0, ',', '.') }}d</span>
                        </div>
                    </div>

                    <div class="pt-5">
                        <a href="{{ route('checkout.index') }}" class="glass-button w-full py-3 rounded-2xl text-sm font-bold flex flex-col items-center justify-center">
                            <span>Thanh toan</span>
                            <span class="text-[10px] font-medium opacity-90">Giao hang tan noi hoac nhan tai cua hang</span>
                        </a>
                    </div>

                    <div class="mt-5 grid grid-cols-3 gap-3 text-[9px] text-slate-400">
                        <div class="glass-chip rounded-xl p-2 flex flex-col items-center gap-1">
                            <span class="material-symbols-outlined text-base">verified_user</span>
                            Bao mat
                        </div>
                        <div class="glass-chip rounded-xl p-2 flex flex-col items-center gap-1">
                            <span class="material-symbols-outlined text-base">local_shipping</span>
                            Nhanh
                        </div>
                        <div class="glass-chip rounded-xl p-2 flex flex-col items-center gap-1">
                            <span class="material-symbols-outlined text-base">workspace_premium</span>
                            Chinh hang
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="glass-panel rounded-3xl p-12 text-center">
            <div class="w-20 h-20 glass-chip rounded-full flex items-center justify-center mx-auto">
                <span class="material-symbols-outlined text-4xl text-slate-300">shopping_cart</span>
            </div>
            <h3 class="mt-4 text-xl font-bold text-slate-800">Gio hang dang trong</h3>
            <p class="text-slate-500">Quay lai cua hang de chon san pham yeu thich.</p>
            <div class="pt-6">
                <a href="{{ route('shop.index') }}" class="glass-button inline-flex items-center justify-center px-8 py-3 rounded-2xl text-sm font-bold">
                    Bat dau mua sam
                </a>
            </div>
        </div>
    @endif
</div>
