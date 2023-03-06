<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $with = 'product';

    protected $fillable = [
        'name', 'phone', 'payment', 'date', 'total', 'uang', 'kembalian'
    ];
    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
