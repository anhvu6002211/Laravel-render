<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price',
        'stock',
        'view',
        'is_active',
        'category_id',
    ];

    protected $casts = [
        'price'     => 'decimal:0',
        'stock'     => 'integer',
        'view'      => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Tự động tạo slug từ name khi tạo mới.
     */
    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Sản phẩm thuộc về một danh mục.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Một sản phẩm có nhiều dòng chi tiết đơn hàng.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Tăng lượt xem.
     */
    public function incrementView(): void
    {
        $this->increment('view');
    }

    /**
     * Format giá tiền VND.
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', '.') . '₫';
    }

    /**
     * Kiểm tra còn hàng không.
     */
    public function getInStockAttribute(): bool
    {
        return $this->stock > 0;
    }
}
