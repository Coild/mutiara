<x-layout>
    <x-item.pageheader> </x-item.pageheader>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-5">
                <form action="{{'#'}}">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="date" name="start_date" class="form-control" value="{{'12-12-2022'}}" />
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="end_date" class="form-control" value="{{'12-12-2021'}}" />
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
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
                @foreach ($data as $item)
                <tr>
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
                    <th>{{ '$' }} {{ '100000' }}</th>
                    <th>{{ '$' }} {{ '120000' }}</th>
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