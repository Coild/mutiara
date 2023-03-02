<?php

namespace App\Http\Livewire\Modal;

use App\Models\Product;
use App\Models\produk;
use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Peroduk;

class ListProduk extends Component
{
    // public $data;
    public $count;
    public $cart;
    public $id_produk;

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
                $isi = Product::where('barcode', $this->id_produk)->get();
                // dd($isi);
                $data = Session::get('data') ?? [];
                array_push($data, $isi);

                Session::put('data', $data);
                $this->id_produk = '';
            } else {
                $this->id_produk;
            }
        }
    }

    public function increment()
    {
        $this->count++;
        $this->emit('resetCount');
    }

    public function add()
    {
        $this->count;
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


    public function addproduct($product)
    {
        $isi = Product::find($product)->get();
        // dd(100);
        $data = Session::get('data') ?? [];


        array_push($data, $isi);

        Session::put('data', $data);
        // dd($this->cart);
        // $this->data = $data;
    }

    public function mount()
    {
        $this->count = 0;
        $this->cart = [];
        // $this->content = $post->content;
    }

    public function render()
    {
        $data = Product::all();
        // Session::flush();
        $cek = Session::get('data') ?? [];
        // dd($cek);
        return view('livewire.modal.list-produk', compact('data', 'cek'));
    }
}