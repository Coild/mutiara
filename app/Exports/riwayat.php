<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\order_grosir;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class riwayat implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $start;
    protected $end;
    protected $params;

    public function __construct($start, $end, $params)
    {
        $this->start = $start;
        $this->end = $end;
        $this->params = $params;
    }

    public function collection()
    {
        if ($this->params == 1) {
            return Order::whereBetween('date', [$this->start, $this->end])
            ->select('name', 'phone', 'address', 'payment', 'bill_code', 'date', 'total', 'uang', 'kembalian')
            ->get();;
        } else {
            return order_grosir::whereBetween('date', [$this->start, $this->end])
            ->select('name', 'phone', 'address', 'payment', 'bill_code', 'date', 'total', 'uang', 'kembalian')
            ->get();;
        }
        
    }

    public function headings(): array
    {
        // Define the column headings for the Excel file
        return [
            'name', 'phone', 'address', 'payment', 'bill_code', 'date', 'total', 'uang', 'kembalian'
        ];
    }
}
