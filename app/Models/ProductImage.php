<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'img_path',
        'product_id',
        'is_primary',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
        
    }

}
