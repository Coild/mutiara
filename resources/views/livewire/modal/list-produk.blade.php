<div class="card">
    <div class="card-body">
        {{-- <div class="row">
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
        </div> --}}
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
                        <td>{{ $loop->index+1}}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->type }}</td>
                        <td>{{ $product->size }}</td>
                        <td>{{ $count }}</td>
                        <td>{{ $count . ' gr' }}</td>
                        <td>{{ $product->grade }}</td>
                        <td>{{ 'Rp.' . $product->price }}</td>

                        <td>
        
                            <button class="btn btn-success" wire:click="addproduct({{$product['id']}})" onclick="console.log('click')"><i
                                    class="fas fa-plus"></i></button>
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
        {{-- {{ $orders->render() }} --}}
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-body">
    
                    <form class="form-produk">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-5">
                                <div class="input-group">
                                        {{-- <button onclick="tampilProduk()" class="btn btn-info btn-flat" type="button"><i
                                                class="fa fa-plus mr-3"></i> Tambah Produk</button> --}}
                                                <input type="text" wire:model="id_produk" id="myInput">

                            
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
    
                    <div class="row p-3">
                        
                        <div class="col-lg-8">
                            <form action="{{ '#' }}" class="form-penjualan" method="post">
                                @csrf
                                <input type="hidden" name="id_penjualan" value="{{ '$id_penjualan' }}">
                                <input type="hidden" name="total" id="total">
                                <input type="hidden" name="total_item" id="total_item">
                                <input type="hidden" name="bayar" id="bayar">
                                
    
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
                                                value="{{ '-'}}">
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
                    <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan ml-5 mb-3"><i
                            class="fa fa-floppy-o"></i> Simpan Transaksi</button>
                </div>
            </div>
        </div>
    </div>
</div>
