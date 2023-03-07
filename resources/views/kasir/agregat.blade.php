<x-layout>
    <x-item.pageheader>
        <x-slot name="name"> Agregat </x-slot>    
    </x-item.pageheader>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-5">
                <form action="{{route('riwayat.filter')}}" method="post">
                    <div class="row">
                        @csrf
                        <input type="hidden" name="filter" value="1">
                        <div class="col-md-5">
                            <input type="date" name="start_date" class="form-control" value="{{date('Y-m-d')}}" required/>
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="end_date" class="form-control" value="{{date('Y-m-d')}}" required/>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="totalrp" class="col-lg-2 control-label">Pendapatan</label>
                    <div class="col-lg-8">
                        <input type="text" value="{{$total}}" class="form-control" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="totalrp" class="col-lg-2 control-label">Modal</label>
                    <div class="col-lg-8">
                        <input type="text" value="{{$modal}}" class="form-control" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="totalrp" class="col-lg-2 control-label">Untung</label>
                    <div class="col-lg-8">
                        <input type="text" value="{{$total-$modal}}" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pembeli</th>
                    <th>Total</th>
                    {{-- <th>Received Amount</th> --}}
                    {{-- <th>Status</th> --}}
                    {{-- <th>To Pay</th> --}}
                    <th>Tanggal Transaksi</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total=0;
                @endphp
                @foreach ($order as $item)
                <tr>
                    @php
                        $total+=$item['total'];
                    @endphp
                    <td>{{$loop->index+1}}</td>
                    <td>{{$item['name']}}</td>
                    <td>{{ 'Rp' }} {{$item['total']}}</td>
                    <td>{{$item['date']}}</td>
                    <td>
                        {{-- /order/invoice/{id_order} --}}
                        <button class="btn btn-success" onclick="window.location.href='{{ route('detil.transaksi') }}?id={{$item['id']}}'"><i class="fa fa-eye">Lihat</i></button>
                        <button class="btn btn-primary" onclick="window.location.href='{{ '/order/invoice/'.$item['id']}}'"><i class="fa fa-book">Cetak</i></button>
                    </td>
                </tr>
                @endforeach
                
                
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th>{{ 'Rp' }} {{ $total }}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        {{-- {{ $orders->render() }} --}}
    </div>
</div>    
</x-layout>