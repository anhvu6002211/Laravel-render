<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class CartPanel extends Component
{
    public array $items = [];
    public array $quantities = [];
    public string $note = '';

    public function mount(): void
    {
        $this->loadCart();
    }

    public function render()
    {
        return view('livewire.cart-panel', [
            'total'     => $this->total,
            'itemCount' => $this->itemCount,
        ]);
    }

    public function getTotalProperty(): int
    {
        $total = 0;

        foreach ($this->items as $item) {
            $qty = $this->quantities[$item['id']] ?? 0;
            $total += $item['price'] * $qty;
        }

        return $total;
    }

    public function getItemCountProperty(): int
    {
        return count($this->items);
    }

    public function increase(int $productId): void
    {
        $current = $this->quantities[$productId] ?? 0;
        $this->setQuantity($productId, $current + 1);
    }

    public function decrease(int $productId): void
    {
        $current = $this->quantities[$productId] ?? 0;
        $this->setQuantity($productId, $current - 1);
    }

    public function remove(int $productId): void
    {
        unset($this->items[$productId]);
        unset($this->quantities[$productId]);

        $cart = session('cart', []);
        unset($cart[$productId]);
        session(['cart' => $cart]);
    }

    public function updatedQuantities($value, $key): void
    {
        $productId = (int) $key;
        $quantity = (int) $value;

        $this->setQuantity($productId, $quantity);
    }

    private function setQuantity(int $productId, int $quantity): void
    {
        if (!isset($this->items[$productId])) {
            return;
        }

        if ($quantity <= 0) {
            $this->remove($productId);
            return;
        }

        $quantity = min($quantity, 99);
        $stock = $this->items[$productId]['stock'] ?? null;
        if (is_int($stock) && $stock > 0) {
            $quantity = min($quantity, $stock);
        }

        $this->quantities[$productId] = $quantity;

        $cart = session('cart', []);
        $cart[$productId] = ['quantity' => $quantity];
        session(['cart' => $cart]);
    }

    private function loadCart(): void
    {
        $cart = session('cart', []);
        $productIds = array_keys($cart);

        if (empty($productIds)) {
            $this->items = [];
            $this->quantities = [];
            return;
        }

        $products = Product::with('category')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $items = [];
        $cleanCart = [];
        foreach ($cart as $id => $item) {
            $product = $products->get($id);
            if (!$product) {
                continue;
            }

            $quantity = (int) ($item['quantity'] ?? 1);
            $items[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (int) $product->price,
                'price_old' => $product->price_old,
                'image' => $product->image,
                'category' => $product->category?->name,
                'stock' => (int) $product->stock,
            ];

            $this->quantities[$product->id] = $quantity;
            $cleanCart[$product->id] = ['quantity' => $quantity];
        }

        $this->items = $items;
        session(['cart' => $cleanCart]);
    }
}
