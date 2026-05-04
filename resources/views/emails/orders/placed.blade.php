<x-mail::message>
# Xác nhận đơn hàng **{{ $order->code }}**

Cảm ơn bạn đã mua sắm tại Vuxshop! Đơn hàng của bạn đã được ghi nhận.

**Chi tiết thanh toán:**
- **Thanh toán:** {{ number_format($order->total_price, 0, ',', '.') }}đ
- **Tên:** {{ $order->first_name }} {{ $order->last_name }}
- **Địa chỉ:** {{ $order->address }}, {{ $order->city }}

**Chi tiết đơn hàng:**
@component('mail::table')
| Sản phẩm       | SL           | Thành tiền  |
| ------------- |:-------------:| --------:|
@foreach ($order->orderItems as $item)
| {{ $item->product->name }} | {{ $item->quantity }} | {{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ |
@endforeach
@endcomponent

<x-mail::button :url="url('/profile/orders/'.$order->id)">
Theo dõi đơn hàng
</x-mail::button>

Cảm ơn,<br>
{{ config('app.name') }}
</x-mail::message>
