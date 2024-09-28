<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_grosir extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','name', 'phone', 'address', 'payment', 'bill_code', 'date', 'total', 'uang', 'kembalian'
    ];
    public function grosir_sells()
    {
        return $this->hasMany(grosir_sell::class, 'id','order_id');
    }
}
