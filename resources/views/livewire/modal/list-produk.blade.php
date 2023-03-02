<div class="card">
    {{-- <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th>Karat</th>
                    <th>Weight</th>
                    <th>Grade</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $product)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->type }}</td>
                        <td>{{ $product->size }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ $count . ' gr' }}</td>
                        <td>{{ $product->grade }}</td>
                        <td>{{ 'Rp.' . $product->price }}</td>

                        <td>

                            <button class="btn btn-success" wire:click="addproduct({{ $product['id'] }})"
                                onclick="console.log('click')"><i class="fas fa-plus"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Size</th>
                    <th>Karat</th>
                    <th>Weight</th>
                    <th>Grade</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>
    </div> --}}

    <div class="row">
        <div class="col-lg-12">
            <input type="text" wire:model="id_produk" id="myInput">
            <form action="{{ route('beli') }}" class="form-penjualan" method="post">
                <div class="box">
                    <div class="box-body">
                        <div class="row p-3">
                            <div class="col-lg-12">
                                <table class="table table-stiped table-bordered table-penjualan">
                                    <thead>
                                        <th width="5%">No</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>Diskon</th>
                                        <th>Aksi</th>
                                        {{-- <th width="15%"><i class="fa fa-cog"></i></th> --}}
                                    </thead>
                                    <tbody>
                                        @foreach ($cek as $key => $product)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $product['type'] }}</td>
                                                <td>{{ '100' }}</td>
                                                <td>{{ '100' }}</td>
                                                <td><input type="text" name="diskon{{ $loop->index + 1 }}"></td>
                                                <td><button class="btn btn-danger" wire:click="addproduct({{ $key }})"
                                                    onclick="console.log('click')"><i class="fas fa-trash"></i></button></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-8">
                                @csrf
                                <div class="form-group row">
                                    <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="totalrp" class="form-control" wire:model="total"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kode_member" class="col-lg-2 control-label">Member</label>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="kode_member" name="nama"
                                                value="{{ '-' }}">

                                        </div>
                                    </div>
                                </div>
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

                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit"
                            class="btn btn-primary btn-sm btn-flat pull-right btn-simpan ml-5 mb-3"><i
                                class="fa fa-floppy-o"></i> Simpan Transaksi</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
