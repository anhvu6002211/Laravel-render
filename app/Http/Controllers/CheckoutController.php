<?php

namespace App\Http\Controllers;

use App\Mail\OrderPlaced;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $cartItems = [];
        $total = 0;
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product'  => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
                ];
                $total += $product->price * $item['quantity'];
            }
        }

        $user = auth()->user();
        return view('checkout.index', compact('cartItems', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|string|max:20',
            'address'    => 'required|string',
            'city'       => 'required|string|max:255',
            'zip'        => 'nullable|string|max:20',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        try {
            $order = DB::transaction(function () use ($cart, $request) {
                $productIds = array_keys($cart);
                $products = Product::whereIn('id', $productIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                $total = 0;
                $items = [];

                foreach ($cart as $id => $item) {
                    $product = $products->get($id);
                    if (!$product) {
                        throw new \RuntimeException('Sản phẩm không còn tồn tại trong hệ thống.');
                    }

                    $quantity = max(1, (int) $item['quantity']);
                    if ($product->stock < $quantity) {
                        throw new \RuntimeException("Sản phẩm \"{$product->name}\" không đủ tồn kho.");
                    }

                    $items[] = [
                        'product'  => $product,
                        'quantity' => $quantity,
                        'price'    => $product->price,
                    ];
                    $total += $product->price * $quantity;
                }

                $order = Order::create([
                    'code'        => 'ORD-' . strtoupper(Str::random(8)),
                    'status'      => 'pending',
                    'user_id'     => auth()->id(),
                    'first_name'  => $request->first_name,
                    'last_name'   => $request->last_name,
                    'email'       => $request->email,
                    'phone'       => $request->phone,
                    'address'     => $request->address,
                    'city'        => $request->city,
                    'zip'         => $request->zip,
                    'total_price' => $total,
                ]);

                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $item['product']->id,
                        'quantity'   => $item['quantity'],
                        'price'      => $item['price'],
                    ]);

                    // Trừ tồn kho
                    $item['product']->decrement('stock', $item['quantity']);
                }

                return $order;
            });
        } catch (\RuntimeException $exception) {
            return redirect()->route('cart.index')->with('error', $exception->getMessage());
        } catch (\Throwable $exception) {
            report($exception);
            return redirect()->route('cart.index')->with('error', 'Không thể tạo đơn hàng, vui lòng thử lại.');
        }

        // Gửi email xác nhận
        Mail::to($request->email)->send(new OrderPlaced($order));

        session()->forget('cart');

        return redirect()->route('home')->with('success', "Đặt hàng thành công! Mã đơn hàng: {$order->code}");
    }
}
