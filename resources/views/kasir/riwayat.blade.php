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
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-body">

                    <form class="form-produk">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-5">
                                <div class="input-group">
                                        <button onclick="tampilProduk()" class="btn btn-info btn-flat" type="button"><i
                                                class="fa fa-plus mr-3"></i> Tambah Produk</button>
                            
                                </div>
                            </div>
                        </div>
                    </form>

                    <table class="table table-stiped table-bordered table-penjualan">
                        <thead>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th>Subtotal</th>
                            {{-- <th width="15%"><i class="fa fa-cog"></i></th> --}}
                        </thead>
                        <tbody>
                            @foreach ($cek as $product)
                                <tr>
                                    <td>{{ $loop->index+1}}</td>
                                    <td>{{ "100" }}</td>
                                    <td>{{ "100" }}</td>
                                    <td>{{ "100" }}</td>
                                    <td>{{ "100" }}</td>
                                    <td>{{ "100" . ' gr' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="tampil-bayar bg-primary"></div>
                            <div class="tampil-terbilang"></div>
                        </div>
                        <div class="col-lg-4">
                            <form action="{{ '#' }}" class="form-penjualan" method="post">
                                @csrf
                                <input type="hidden" name="id_penjualan" value="{{ '$id_penjualan' }}">
                                <input type="hidden" name="total" id="total">
                                <input type="hidden" name="total_item" id="total_item">
                                <input type="hidden" name="bayar" id="bayar">
                                <input type="hidden" name="id_member" id="id_member"
                                    value="{{ '$memberSelected->id_member' }}">

                                <div class="form-group row">
                                    <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="totalrp" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kode_member" class="col-lg-2 control-label">Member</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="kode_member"
                                                value="{{ '$memberSelected->kode_member' }}">
                                            <span class="input-group-btn">
                                                <button onclick="tampilMember()" class="btn btn-info btn-flat"
                                                    type="button"><i class="fa fa-arrow-right"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <label for="diskon" class="col-lg-2 control-label">Diskon</label>
                                    <div class="col-lg-8">
                                        <input type="number" name="diskon" id="diskon" class="form-control"
                                            value="{{ !empty($memberSelected->id_member) ? '$diskon' : 0 }}" readonly>
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group row">
                                    <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="bayarrp" class="form-control" readonly>
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <label for="diterima" class="col-lg-2 control-label">Diterima</label>
                                    <div class="col-lg-8">
                                        <input type="number" id="diterima" class="form-control" name="diterima"
                                            value="{{ $penjualan->diterima ?? 0 }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kembali" class="col-lg-2 control-label">Kembali</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="kembali" name="kembali" class="form-control"
                                            value="0" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i
                            class="fa fa-floppy-o"></i> Simpan Transaksi</button>
                </div>
            </div>
        </div>
    </div>
    <x-item.tabel_produk> </x-item.tabel_produk>
    
</x-layout>
