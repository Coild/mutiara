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
            <input type="text" wire:model="id_produk" id="myInput" class="form-control p-2">
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
                                        <th>Metal</th>
                                        <th>Carat</th>
                                        <th>Weight</th>
                                        <th>Grade</th>
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
                                                <td>{{ $product['weight'] . ' gram' }} </td>
                                                <td>{{ $product['grade'] }}</td>
                                                <td>{{ $product['price_discount'] }}</td>
                                                <td><input type="text" name="diskon{{ $key }}" wire:model="val.{{ $key }}.{{ 'discount' }}" value="val.{{ $key }}.{{ 'discount' }}"></td>
                                                <td><button type="button" class="btn btn-danger"
                                                        wire:click="addproduct({{ $key }})"
                                                        onclick="console.log('click')"><i
                                                            class="fas fa-trash"></i></button></td>
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
                                        <input type="number" wire:model="bayar" id="diterima" class="form-control"
                                            name="diterima">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kembali" class="col-lg-2 control-label">Kembali</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="kembali" name="kembali" class="form-control"
                                            value="{{ $kembali }}" readonly>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit"
                            class="btn btn-primary btn-sm btn-flat pull-right btn-simpan ml-3 mb-3"><i
                                class="fa fa-floppy-o"></i> Simpan Transaksi</button>
                                
                        <button type="button" class="btn btn-success btn-sm btn-flat pull-right btn-simpan ml-2  mb-3" wire:click="get_diskon"
                            onclick="console.log('click')">Hitung diskon</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
