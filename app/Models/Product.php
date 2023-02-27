<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';

    protected $fillable = [
        'id',
        'type',
        'metal',
        'carat',
        'weight',
        'pearls',
        'color',
        'shape',
        'grade',
        'size',
        'price',
        'price_sell',
    ];
}
