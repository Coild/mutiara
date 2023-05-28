<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class riwayat implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        return Order::whereBetween('date', [$this->start, $this->end])
            ->select('name', 'phone', 'address', 'payment', 'bill_code', 'date', 'total', 'uang', 'kembalian')
            ->get();;
    }

    public function headings(): array
    {
        // Define the column headings for the Excel file
        return [
            'name', 'phone', 'address', 'payment', 'bill_code', 'date', 'total', 'uang', 'kembalian'
        ];
    }
}
