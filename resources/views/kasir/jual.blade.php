<x-layout title="Riwayat Transakasi">
    <x-item.pageheader>
        <x-slot name="name"> Riwayat </x-slot>
    </x-item.pageheader>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-7"></div>
                <div class="col-md-5">
                    <form action="{{ route('riwayat.filter') }}" method="post">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="filter" value="1">
                            <div class="col-md-5">
                                <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}"
                                    required />
                            </div>
                            <div class="col-md-5">
                                <input type="date" name="end_date" class="form-control" value="{{ date('Y-m-d') }}"
                                    required />
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
                        <th>Kode</th>
                        <th>Kode Tagihan</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        {{-- <th>Received Amount</th> --}}
                        {{-- <th>Status</th> --}}
                        {{-- <th>To Pay</th> --}}
                        <th>Tanggal Transaksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($data as $item)
                        <tr>
                            @php
                                $total += $item['total'];
                            @endphp
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['code'] }}</td>
                            <td>{{ $item['bill_code'] }}</td>
                            <td>{{ 'Rp' }} {{ number_format($item['total'], 0, ',', '.') }}</td>
                            <td>{{ $item['payment'] }}</td>
                            <td>{{ $item['date'] }}</td>
                            <td>
                                {{-- /order/invoice/{id_order} --}}
                                <button class="btn btn-success"
                                    onclick="window.location.href='{{ route('detil.transaksi') }}?id={{ $item['id'] }}'"><i
                                        class="fa fa-eye">Lihat</i></button>
                                <button class="btn btn-primary"
                                    onclick="window.location.href='{{ '/order/invoice/' . $item['id'] }}'"><i
                                        class="fa fa-book">Cetak</i></button>
                                <button class="btn btn-warning" onclick='isi_id(@json($item))'
                                    data-toggle="modal" data-target="#tambah"><i class="fa fa-pen">Edit</i></button>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>{{ 'Rp' }} {{ number_format($total, 0, ',', '.') }}</th>
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

    <div class="modal fade" id="tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit metode bayar</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('edit_payment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="isi_id">


                        <div class="form-group row">
                            <label for="totalrp" class="col-lg-2 control-label">Nama</label>
                            <div class="col-lg-10">
                                <input type="text" id="isi_nama" class="form-control" wire:model="total_s" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="totalrp" class="col-lg-2 control-label">Kode Tagihan</label>
                            <div class="col-lg-10">
                                <input type="text" id="isi_kode" class="form-control" wire:model="total_s" readonly>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="totalrp" class="col-lg-2 control-label">Payment Method</label>
                            <div class="col-lg-10">
                                <select name="metode" class="form-control" id="isi_bayar">
                                    <option value="Cash">Cash</option>
                                    <option value="Qris">Qris</option>
                                    <option value="Transfer">Transfer</option>
                                    <option value="Card">Card</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary float-right">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</x-layout>
