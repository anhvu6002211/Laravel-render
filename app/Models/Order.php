<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'code',
        'status',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'zip',
        'note',
        'total_price',
    ];

    protected $casts = [
        'total_price' => 'decimal:0',
    ];

    /**
     * Tự động tạo mã đơn hàng khi tạo mới.
     */
    protected static function booted(): void
    {
        static::creating(function (Order $order) {
            if (empty($order->code)) {
                $order->code = 'ORD-' . strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Đơn hàng thuộc về một người dùng.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Một đơn hàng có nhiều sản phẩm (chi tiết đơn hàng).
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Tên đầy đủ của khách hàng.
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * Format tổng tiền VND.
     */
    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total_price, 0, ',', '.') . '₫';
    }
}
