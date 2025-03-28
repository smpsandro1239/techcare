<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',  // Definindo corretamente uma vez
        'img_path',
        'is_primary',
    ];

    // Relacionamento com o modelo Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
