<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'quantity',
        'price',
        'order_id',
        'product_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price'   => 'decimal:0',
    ];

    /**
     * Chi tiết đơn hàng thuộc về một đơn hàng.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Chi tiết đơn hàng gắn với một sản phẩm.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Thành tiền = quantity * price.
     */
    public function getSubtotalAttribute(): float
    {
        return $this->quantity * $this->price;
    }
}
