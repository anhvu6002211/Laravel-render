<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = ['name', 'slug', 'image', 'is_active'];
    
    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Tự động tạo slug từ name khi tạo mới.
     */
    protected static function booted(): void
    {
        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Một danh mục có nhiều sản phẩm.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
