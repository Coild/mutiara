<?php

namespace App\Http\Livewire\Modal;

use App\Models\Product;
use App\Models\produk;
use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Peroduk;

class ListProduk extends Component
{
    public $val;
    public $count;
    public $cart;
    public $id_produk;
    public $total;
    public $total_s;
    public $kembali;
    public $kembali_s;
    public $bayar;
    public $bayar_i;
    public $pesan;


    // public $id_produk;

    protected $listeners = [
        'resetCount' => 'add',
        'insert' => 'store'
    ];

    public function updated($propertyName)
    {
        // This code will execute whenever the $count property is updated
        if ($propertyName === 'id_produk') {
            $count = Product::where('barcode', $this->id_produk)->count();
            // dd($count);
            if ($count != 0) {
                $isi = Product::where('barcode', $this->id_produk)->first();
                // dd($isi);
                // $data = $this->val ?? [];
                $key_to_check = 2;

                $key_exists = false;
                foreach ($this->val as $item) {
                    // dd($item);
                    if ($item['barcode'] == $this->id_produk) {
                        $key_exists = true;
                        break;
                    }
                }
                if (!$key_exists) {
                    array_push($this->val, $isi);

                    $this->total += $isi['price_sell'];
                    $this->total_s = number_format($this->total, 0, ',', '.');

                    Session::put('total', $this->total);
                    Session::put('data',  $this->val);
                    $this->id_produk = '';
                } else {
                    $this->dispatchBrowserEvent('swal:success', [
                        'title' => 'Warning!',
                        'text' => 'Item Telah Di Scan.',
                    ]);
                    $this->id_produk = '';
                }
            } else {
                $this->id_produk;
            }
        }

        if ($propertyName === 'bayar') {
            // Convert the formatted number back to an integer
            $this->bayar_i = intval(str_replace('.', '', $this->bayar));
            $this->kembali = intval($this->bayar_i) - intval($this->total);
            // Format the input number with dots every three digits
            $this->bayar = number_format($this->bayar_i, 0, ',', '.');

            
            $this->kembali_s = number_format($this->kembali, 0, '.', ',');
        }
    }


    // public function cek_insert()
    // {
    //     $count = Product::where('id', $this->id_produk )->count();
    //     // dd($count);
    //     if ($count != 0) {
    //         $isi = Product::find($this->id_produk)->get();
    //         // dd($isi);
    //         $data = Session::get('data') ?? [];
    //         array_push($data, $isi);

    //         Session::put('data', $data);
    //         $this->id_produk = '';
    //     } else {
    //         $this->id_produk;
    //     }
    // }

    public function store()
    {
        $this->id_produk;
    }


    public function addproduct($key)
    {

        $this->total -= $this->val[$key]['price_discount'];
        $this->total_s = number_format($this->total, 0, ',', '.');
        unset($this->val[$key]);

        // array_push($data, $isi);

        Session::put('data', $this->val);
        Session::put('total', $this->total);
    }

    public function get_diskon()
    {
        $this->total = 0;
        foreach ($this->val as $key => $item) {
            $this->val[$key]['price_discount'] = intval($this->val[$key]['price_sell'] - (($this->val[$key]['discount'] / 100) * $this->val[$key]['price_sell']));
            $this->total += $this->val[$key]['price_discount'];
            $this->total_s = number_format($this->total, 0, ',', '.');
        }
        Session::put('data', $this->val);
        // dd($this->val);
        $this->render();
    }

    public function mount()
    {
        $this->count = 0;
        $this->kembali = 0;
        $this->kembali_s = number_format($this->kembali, 0, ',', '.');
        $this->bayar = 0;
        $this->total = Session::get('total') ?? 0;
        $this->total_s = number_format($this->total, 0, ',', '.');
        $this->val = Session::get('data') ?? [];

        // $this->content = $post->content;
    }

    public function render()
    {
        $data = $this->val;
        // Session::flush();
        // $kan
        // dd($cek);
        return view('livewire.modal.list-produk', compact('data'));
    }
}
