<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_grosir extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'phone', 'address', 'payment', 'bill_code', 'date', 'total', 'uang', 'kembalian'
    ];
}
