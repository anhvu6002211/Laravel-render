<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add(Request $request)
    {
        $id       = $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);
        if (!$id) {
            return redirect()->back()->with('error', 'San pham khong hop le.');
        }

        $product  = Product::findOrFail($id);

        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = ['quantity' => $quantity];
        }

        session(['cart' => $cart]);

        return redirect()->back()->with('success', "Đã thêm \"{$product->name}\" vào giỏ hàng!");
    }

    public function update(Request $request)
    {
        $cart = session('cart', []);
        $id   = $request->input('product_id');
        $qty  = (int) $request->input('quantity', 1);

        if ($qty <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id]['quantity'] = $qty;
        }

        session(['cart' => $cart]);
        return redirect()->route('cart.index')->with('success', 'Cập nhật giỏ hàng thành công!');
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function count()
    {
        return count(session('cart', []));
    }
}
