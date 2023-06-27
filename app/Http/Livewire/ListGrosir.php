<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\grosir;
use Illuminate\Support\Facades\Session;

class ListGrosir extends Component
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
            $count = grosir::where('barcode', $this->id_produk)->count();
            // dd($count);
            if ($count != 0) {
                $isi = grosir::where('barcode', $this->id_produk)->first();
                $isi['jumlah'] = 1;
                $isi['total'] = $isi['jumlah'] * $isi['price_sell'];
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

                    Session::put('total_grosir', $this->total);
                    Session::put('data_grosir',  $this->val);
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
            $this->kembali = $this->bayar_i - $this->total;
            // Format the input number with dots every three digits
            $this->bayar = number_format($this->bayar_i, 0, ',', '.');
 
            
            $this->kembali_s = number_format($this->kembali, 0, '.', ',');
        }
    }


    // public function cek_insert()
    // {
    //     $count = grosir::where('id', $this->id_produk )->count();
    //     // dd($count);
    //     if ($count != 0) {
    //         $isi = grosir::find($this->id_produk)->get();
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

        $this->total -= $this->val[$key]['total'];
        $this->total_s = number_format($this->total, 0, ',', '.');
        unset($this->val[$key]);

        // array_push($data, $isi);

        Session::put('data_grosir', $this->val);
        Session::put('total_grosir', $this->total);
    }

    public function get_diskon()
    {
        $this->total = 0;
        foreach ($this->val as $key => $item) {
            if($this->val[$key]['jumlah'] > $this->val[$key]['stok']) {
                $this->val[$key]['jumlah'] = $this->val[$key]['stok'];
            }
            $this->val[$key]['total'] = $this->val[$key]['jumlah'] * $this->val[$key]['price_sell'];
            $this->val[$key]['total'] = intval($this->val[$key]['total'] - (($this->val[$key]['discount'] / 100) * $this->val[$key]['total']));
            $this->total += $this->val[$key]['total'];
            $this->total_s = number_format($this->total, 0, ',', '.');
        }
        Session::put('data_grosir', $this->val);
        // dd($this->val);
        $this->render();
    }

    public function mount()
    {
        $this->count = 0;
        $this->kembali = 0;
        $this->kembali_s = number_format($this->kembali, 0, ',', '.');
        $this->bayar = 0;
        $this->total = Session::get('total_grosir') ?? 0;
        $this->total_s = number_format($this->total, 0, ',', '.');
        $this->val = Session::get('data_grosir') ?? [];

        // $this->content = $post->content;
    }
    public function render()
    {
        $data = $this->val;
        return view('livewire.list-grosir',compact('data'));
    }
}
