<?php

namespace App\Http\Livewire\Modal;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Peroduk;

class ListProduk extends Component
{
    // public $data;
    public $count;
    public $cart;
    
    protected $listeners = ['resetCount' => 'add'];

    public function increment()
    {
        $this->count++;
        $this->emit('resetCount');
    }

    public function add()
    {
        $this->count ;
    }


    public function addproduct($product)
    {
        $isi = Product::find($product)->get();
        // dd();
        

        array_push($this->cart, $product);
        Session::put('data', $this->cart);

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
