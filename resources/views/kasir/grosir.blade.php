<x-layout title="Product Transakasi">
    <x-item.pageheader>
        <x-slot name="name"> Produk </x-slot>

    </x-item.pageheader>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">List Produk</h2>

            {{-- <button class="btn btn-primary float-right mr-3" onclick="cetak_barcode()">Cetak Barcode</button> --}}
            {{-- <select class="form-control float-right mr-3" style="width: 200px; float: right;" id="tanggals">
                <option value="">Pilih Tanggal</option> --}}
            {{-- @foreach ($tanggal as $item)
                    <option value="{{ $item['created_at'] }}">{{ $item['created_at'] }}</option>
                @endforeach --}}
            </select>
            <button class="btn btn-primary float-right mr-3" data-toggle="modal" data-target="#tambah">Tambah</button>

            <button class="btn btn-primary float-right mr-3" data-toggle="modal" data-target="#upload">Upload</button>


        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Type</th>
                        <th>Metal</th>
                        <th>Carat</th>
                        <th>Weight1</th>
                        <th>Pearls</th>
                        <th>Color</th>
                        <th>Shape</th>
                        <th>Grade</th>
                        <th>Weight2</th>
                        <th>Size</th>
                        <th>Stok</th>
                        @if (Auth::user()->level == 'admin')
                            <th>Price</th>
                        @endif
                        <th>Price Sell</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $product)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $product->type }}</td>
                            <td>{{ $product->metal }}</td>
                            <td>{{ $product->carat }}</td>
                            <td>{{ $product->weight1 . ' gr' }}</td>
                            <td>{{ $product->pearls }}</td>
                            <td>{{ $product->color }}</td>
                            <td>{{ $product->shape }}</td>
                            <td>{{ $product->grade }}</td>
                            <td>{{ $product->weight2 . ' gr' }}</td>
                            <td>{{ $product->size }}</td>
                            <td>{{ $product->stok }}</td>
                            @if (Auth::user()->level == 'admin')
                                <td>{{ 'Rp ' . $product->price }}</td>
                            @endif
                            <td>{{ 'Rp ' . number_format($product->price_sell, 0, ',', '.') }}</td>

                            <td>
                                <a data-toggle="modal" data-target="#edit" class="btn btn-primary"
                                    onclick='lempar(@json($product))'><i class="fas fa-edit"></i></a>
                                <button class="btn btn-success" data-toggle="modal" data-target="#print"
                                    onclick="print_id({{ $product->id }}, 'print_id')"><i
                                        class="fas fa-print"></i></button>
                                <button class="btn btn-success" data-toggle="modal" data-target="#plus"
                                    onclick="print_id({{ $product->id }}, 'plus_id')"><i
                                        class="fas fa-plus"></i></button>
                                <a class="btn btn-danger btn-delete" href="grosir_hapus?id={{ $product->id }}"
                                    onclick="return confirm('Are you sure want to delete {{ $product->type }}')"><i
                                        class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Type</th>
                        <th>Metal</th>
                        <th>Carat</th>
                        <th>Weight1</th>
                        <th>Pearls</th>
                        <th>Color</th>
                        <th>Shape</th>
                        <th>Grade</th>
                        <th>Weight2</th>
                        <th>Size</th>
                        <th>Stok</th>
                        @if (Auth::user()->level == 'admin')
                            <th>Price</th>
                        @endif
                        <th>Price Sell</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <div class="modal fade" id="tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Default Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('grosir.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="name">Type</label>
                            <input type="text" name="type"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Type" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Metal</label>
                            <input type="text" name="metal"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Carat</label>
                            <input type="text" name="carat"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Weight1</label>
                            <input type="text" name="weight1"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Pearls</label>
                            <input type="text" name="pearls"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Color</label>
                            <input type="text" name="color"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Shape</label>
                            <input type="text" name="shape"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Grade</label>
                            <input type="text" name="grade"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Weight2</label>
                            <input type="text" name="weight2"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Size</label>
                            <input type="text" name="size"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Price</label>
                            <input type="text" name="price"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Price Sell</label>
                            <input type="text" name="price_sell"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
    <div class="modal fade" id="print">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Print Barcode</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form target="_blank" action="{{ route('grosir.print') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="print_id" id="print_id">
                        <div class="form-group">
                            <label for="name">Total</label>
                            <input type="text" name="jumlah" class="form-control">
                        </div>

                        <div class="flex justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary float-right">print</button>
                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="plus">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Stok</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('grosir.plus') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="plus_id" id="plus_id">
                        <div class="form-group">
                            <label for="name">Total</label>
                            <input type="number" name="jumlah" class="form-control">
                        </div>

                        <div class="flex justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary float-right">tambah</button>
                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="upload">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload Produk Grosir</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('grosir.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Download Template <a href="">disini</a> --}}
                        {{-- <div class="form-group">
                            <label for="name">File</label>
                            <input type="file" name="uploaded_file" class="form-control">
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Pilih File</label>
                            <div class="col-sm-10">
                                <input type="file" name="uploaded_file" class="form-control">
                            </div>
                        </div>

                        <div class="flex justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Default Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('grosir.edit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="xid" name="id">

                        <div class="form-group">
                            <label for="name">Type</label>
                            <input type="text" name="type"
                                class="form-control @error('name') is-invalid @enderror" id="xtype"
                                placeholder="Type" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Metal</label>
                            <input type="text" name="metal"
                                class="form-control @error('name') is-invalid @enderror" id="xmetal"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Carat</label>
                            <input type="text" name="carat"
                                class="form-control @error('name') is-invalid @enderror" id="xcarat"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Weight1</label>
                            <input type="text" name="weight1"
                                class="form-control @error('name') is-invalid @enderror" id="xweight1"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Pearls</label>
                            <input type="text" name="pearls"
                                class="form-control @error('name') is-invalid @enderror" id="xpearls"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Color</label>
                            <input type="text" name="color"
                                class="form-control @error('name') is-invalid @enderror" id="xcolor"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Shape</label>
                            <input type="text" name="shape"
                                class="form-control @error('name') is-invalid @enderror" id="xshape"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Grade</label>
                            <input type="text" name="grade"
                                class="form-control @error('name') is-invalid @enderror" id="xgrade"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Weight2</label>
                            <input type="text" name="weight2"
                                class="form-control @error('name') is-invalid @enderror" id="xweight2"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Size</label>
                            <input type="text" name="size"
                                class="form-control @error('name') is-invalid @enderror" id="xsize"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Price</label>
                            <input type="text" name="price"
                                class="form-control @error('name') is-invalid @enderror" id="xprice"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">Price Sell</label>
                            <input type="text" name="price_sell"
                                class="form-control @error('name') is-invalid @enderror" id="xprice_sell"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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

    <form action="{{ route('print_all.barcode') }}" method="post" id='cetak'>
        <input type="hidden" name="tanggal" id="kirim">
    </form>

    <script>
        function print_id(id, target) {
            document.getElementById(target).value = id;
        }

        

        function lempar(data) {
            console.log(data['id']);
            document.getElementById("xid").value = data['id'];
            document.getElementById("xtype").value = data['type'];
            document.getElementById("xmetal").value = data['metal'];
            document.getElementById("xcarat").value = data['carat'];
            document.getElementById("xweight1").value = data['weight1'];
            document.getElementById("xpearls").value = data['pearls'];
            document.getElementById("xcolor").value = data['color'];
            document.getElementById("xshape").value = data['shape'];
            document.getElementById("xgrade").value = data['grade'];
            document.getElementById("xweight2").value = data['weight2'];
            document.getElementById("xsize").value = data['size'];
            document.getElementById("xprice").value = data['price'];
            document.getElementById("xprice_sell").value = data['price_sell'];
        }
    </script>
</x-layout>
