<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'description',
        'seller_id',
        'category_id',
        'subcategory_id',
        'regular_price',
        'slug',
    ];

    protected $casts = [
        'regular_price' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        // Gerar o slug automaticamente a partir do nome do produto
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $baseSlug = Str::slug($product->product_name);
                $slug = $baseSlug;
                $count = 1;

                // Garantir que o slug seja único
                while (Product::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }

                $product->slug = $slug;
            }
        });

        static::updating(function ($product) {
            if (empty($product->slug)) {
                $baseSlug = Str::slug($product->product_name);
                $slug = $baseSlug;
                $count = 1;

                // Garantir que o slug seja único
                while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }

                $product->slug = $slug;
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
