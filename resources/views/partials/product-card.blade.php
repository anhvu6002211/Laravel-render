<div class="product-card">
    <a href="{{ route('products.show', $product->id) }}">
        <img src="{{ $product->image ?: 'https://via.placeholder.com/400x400/1e1e2e/7c3aed?text=No+Image' }}"
             alt="{{ $product->name }}" class="product-card-img"
             onerror="this.src='https://via.placeholder.com/400x400/1e1e2e/7c3aed?text=Vuxshop'">
    </a>
    <div class="product-card-body">
        <div class="product-card-cat">{{ $product->category->name ?? '' }}</div>
        <a href="{{ route('products.show', $product->id) }}">
            <div class="product-card-name">{{ $product->name }}</div>
        </a>
        <div class="product-card-price">{{ number_format($product->price, 0, ',', '.') }}đ</div>
        <div class="product-card-actions">
            <form action="{{ route('cart.add') }}" method="POST" style="flex:1;display:flex;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-primary" style="flex:1;justify-content:center;">🛒 Thêm</button>
            </form>
            <a href="{{ route('products.show', $product->id) }}" class="btn-outline">👁️</a>
        </div>
    </div>
</div>
