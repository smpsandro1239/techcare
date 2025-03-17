<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultAttribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'attribute_value',
        ];
}
