<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grosir extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'type',
        'metal',
        'carat',
        'weight1',
        'pearls',
        'color',
        'shape',
        'grade',
        'weight2',
        'size',
        'price',
        'price_sell',
        'price_discount',
        'barcode',
        'discount',
        'stok',
    ];
}
