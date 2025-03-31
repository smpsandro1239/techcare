<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // Defina a relação entre Report e Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
