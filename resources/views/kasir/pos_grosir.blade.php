<x-layout title="POS">
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
    <x-item.pageheader>
        <x-slot name="name"> Penjualan </x-slot>    
    </x-item.pageheader>
    @livewire('list-grosir')

    @section('js')
        <script>
            $(document).ready(function() {

                const input = document.getElementById("myInput");

                input.addEventListener("keydown", function(event) {
                    if (event.key === "Enter") {
                        event.preventDefault();
                    }
                });

            });
        </script>
    @endsection

</x-layout>
