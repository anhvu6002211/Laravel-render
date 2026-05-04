<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)
            ->with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('profile.index', compact('user', 'orders'));
    }

    public function showOrder($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->with('orderItems.product')
            ->findOrFail($id);
            
        return view('profile.orders.show', compact('order'));
    }
}
