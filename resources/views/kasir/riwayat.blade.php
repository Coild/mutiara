<x-layout>
   
        <style>
            .tampil-bayar {
                font-size: 5em;
                text-align: center;
                height: 100px;
            }

            .tampil-terbilang {
                padding: 10px;
                background: #f0f0f0;
            }

            .table-pembelian tbody tr:last-child {
                display: none;
            }

            @media(max-width: 768px) {
                .tampil-bayar {
                    font-size: 3em;
                    height: 70px;
                    padding-top: 5px;
                }
            }
        </style>
    <x-item.pageheader> </x-item.pageheader>
    @livewire('modal.list-produk')  
    
</x-layout>
