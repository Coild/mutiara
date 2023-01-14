<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product')->insert([
            'name'	=> 'antam',
            'barcode'	=> '112212',
            'size'	=> '17'.'mm',
            'price' => 12000
        ]);
    }
}
