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
        'discounted_price',
        'tax_rate',
        'stock_quantity',
        'stock_status',
        'slug',
        'visibility',
        'meta_title',
        'meta_description',
        'status',
    ];

    protected $casts = [
        'regular_price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'stock_quantity' => 'integer',
        'visibility' => 'boolean',
        'status' => 'boolean',
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

    // Escopo para produtos visíveis
    public function scopeVisible($query)
    {
        return $query->where('visibility', true);
    }

    // Escopo para produtos em estoque
    public function scopeInStock($query)
    {
        return $query->where('stock_status', 'in_stock')->where('stock_quantity', '>', 0);
    }

    // Escopo para produtos ativos
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
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

    // Escopo para produtos visíveis
    public function scopeVisible($query)
    {
        return $query->where('visibility', true);
    }

    // Escopo para produtos em estoque
    public function scopeInStock($query)
    {
        return $query->where('stock_status', 'in_stock')->where('stock_quantity', '>', 0);
    }

    // Escopo para produtos ativos
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}