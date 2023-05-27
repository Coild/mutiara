<div class="card">
    <div class="row">
        <form action="{{ route('beli') }}" class="form-penjualan" method="post">
            <div class="box">
                <div class="box-body">
                    <div class="row ml-3">
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <label for="search" class="col-lg-1 control-label">Barcode</label>
                                <div class="col-lg-11">
                                    <input type="text" wire:model="id_produk" id="myInput" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                {{-- @if (session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                @endif --}}
                            </div>
                            <table class="table table-stiped table-bordered table-penjualan">
                                <thead>
                                    <th width="5%">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Metal</th>
                                    <th>Carat</th>
                                    <th>Weight</th>
                                    <th>Grade</th>
                                    <th>Weight</th>
                                    <th>Harga</th>
                                    <th>Diskon</th>
                                    <th>Aksi</th>
                                    {{-- <th width="15%"><i class="fa fa-cog"></i></th> --}}
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $product)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $product['barcode'] }}</td>
                                            <td>{{ $product['type'] }}</td>
                                            <td>{{ $product['metal'] }}</td>
                                            <td>{{ $product['carat'] }}</td>
                                            <td>{{ $product['weight1'] . ' gram' }} </td>
                                            <td>{{ $product['grade'] }}</td>
                                            <td>{{ $product['weight2'] . ' gram' }} </td>
                                            <td>{{ number_format($product['price_discount'], 0, ',', '.') }}</td>
                                            <td><input type="text" name="diskon{{ $key }}"
                                                    wire:model="val.{{ $key }}.{{ 'discount' }}"
                                                    value="val.{{ $key }}.{{ 'discount' }}"></td>
                                            <td><button type="button" class="btn btn-danger"
                                                    wire:click="addproduct({{ $key }})"
                                                    onclick="console.log('click')"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control" wire:model="total_s"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-2 control-label">Payment Method</label>
                                <div class="col-lg-8">
                                    <select name="metode" id="metode" class="form-control">
                                        <option value="Cash">Cash</option>
                                        <option value="Qris">Qris</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="Card">Card</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diterima" class="col-lg-2 control-label">Diterima</label>
                                <div class="col-lg-8">
                                    <input type="text" wire:model="bayar" id="diterima" class="form-control"
                                        name="diterima">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kembali" class="col-lg-2 control-label">Kembali</label>
                                <div class="col-lg-8">
                                    <input type="text" id="kembali" name="kembali" class="form-control"
                                        wire:model="kembali_s" readonly>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            @csrf
                            <div class="form-group row">
                                <label for="kode_member" class="col-lg-2 control-label">Member</label>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="kode_member" name="nama"
                                            value="{{ '-' }}" required>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diterima" class="col-lg-2 control-label">Phone</label>
                                <div class="col-lg-8">
                                    <input type="text" id="nohp" class="form-control" name="nohp" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kembali" class="col-lg-2 control-label">Address</label>
                                <div class="col-lg-8">
                                    <input type="text" id="alamat" name="alamat" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kembali" class="col-lg-2 control-label">Code</label>
                                <div class="col-lg-8">
                                    <input type="text" id="code" name="code" class="form-control" required>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan ml-3 mb-3"><i
                            class="fa fa-floppy-o"></i> Simpan Transaksi</button>

                    <button type="button" class="btn btn-success btn-sm btn-flat pull-right btn-simpan ml-2  mb-3"
                        wire:click="get_diskon">Hitung diskon</button>
                </div>

            </div>
        </form>
    </div>
</div>
</div>
@section('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        window.addEventListener('swal:success', event => {
            swal({
                title: event.detail.title,
                text: event.detail.text,
                icon: 'warning',
            });
        });
    </script>
   @if (session()->has('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                swal({
                    title: 'Message',
                    text: "{{ session('message') }}",
                    icon: 'info'
                });
            });
        </script>
    @endif
@endsection
