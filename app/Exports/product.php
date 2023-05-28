<?php

namespace App\Exports;

use App\Models\Product as data;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class product implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       return  data::select('type',
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
        'barcode')->get();
    }

    public function headings(): array
    {
        // Define the column headings for the Excel file
        return [
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
            'barcode'
        ];
    }
}
