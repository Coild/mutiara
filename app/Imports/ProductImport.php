<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $string = uniqid(rand());
        $randomString = substr($string, 0, 8);
        return new Product([
            'type' => $row['type'],
            'metal' => $row['metal'],
            'carat' => $row['carat'],
            'weight1' => $row['weight1'],
            'pearls' => $row['pearls'],
            'color' => $row['color'],
            'shape' => $row['shape'],
            'grade' => $row['grade'],
            'weight2' => $row['weight2'],
            'size' => $row['size'],
            'price' => $row['price'],
            'price_sell' => $row['price_sell'],
            'price_discount' => $row['price_sell'],
            'barcode' => $randomString,
            'discount' => 0,
            'status' => 0
        ]);
    }
}
