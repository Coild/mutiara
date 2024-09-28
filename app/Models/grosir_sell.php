<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class grosir_sell extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'order_id',
        'grosir_id',
        'diskon',
        'jumlah',
        'total'
       
    ];

    public function product()
    {
        return $this->hasMany(grosir::class, 'id', 'grosir_id');
    }

}
