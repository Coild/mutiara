<x-layout>
    <x-item.pageheader>
        <x-slot name="name"> Produk </x-slot>

    </x-item.pageheader>
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">List Produk</h2>
            <button class="btn btn-primary float-right mr-3"
                onclick="window.location.href='{{ route('print_all.barcode') }}'">Cetak Barcode</button>
            <button class="btn btn-primary float-right mr-3" data-toggle="modal" data-target="#tambah">Tambah</button>
            <button class="btn btn-primary float-right mr-3" data-toggle="modal" data-target="#upload">Upload</button>

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Metal</th>
                        <th>Carat</th>
                        <th>Weight</th>
                        <th>Pearls</th>
                        <th>Color</th>
                        <th>Shape</th>
                        <th>Grade</th>
                        <th>Size</th>
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
                            <td>{{ $product->weight . ' gr' }}</td>
                            <td>{{ $product->pearls }}</td>
                            <td>{{ $product->color }}</td>
                            <td>{{ $product->shape }}</td>
                            <td>{{ $product->grade }}</td>
                            <td>{{ $product->size }}</td>
                            @if (Auth::user()->level == 'admin')
                                <td>{{ 'Rp.' . $product->price }}</td>
                            @endif
                            <td>{{ 'Rp.' . $product->price_sell }}</td>

                            <td>
                                <a data-toggle="modal" data-target="#edit" class="btn btn-primary"
                                    onclick='lempar(@json($product))'><i class="fas fa-edit"></i></a>
                                <button class="btn btn-success"
                                    onclick="window.location.href='/product/sertificate/{{ $product->id }}'"><i
                                        class="fas fa-print"></i></button>
                                <button class="btn btn-danger btn-delete"
                                    onclick="window.location.href='produkhapus?id={{ $product->id }}'"><i
                                        class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Metal</th>
                        <th>Carat</th>
                        <th>Weight</th>
                        <th>Pearls</th>
                        <th>Color</th>
                        <th>Shape</th>
                        <th>Grade</th>
                        <th>Size</th>
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
                    <form action="{{ route('produk.post') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="name">Weight</label>
                            <input type="text" name="weight"
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
    <div class="modal fade" id="upload">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload Produk</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('import.product') }}" method="POST" enctype="multipart/form-data">
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
                    <form action="{{ route('produk.edit') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="name">Weight</label>
                            <input type="text" name="weight"
                                class="form-control @error('name') is-invalid @enderror" id="xweight"
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

    <script>
        function lempar(data) {
            console.log(data['id']);
            document.getElementById("xid").value = data['id'];
            document.getElementById("xtype").value = data['type'];
            document.getElementById("xmetal").value = data['metal'];
            document.getElementById("xcarat").value = data['carat'];
            document.getElementById("xweight").value = data['weight'];
            document.getElementById("xpearls").value = data['pearls'];
            document.getElementById("xcolor").value = data['color'];
            document.getElementById("xshape").value = data['shape'];
            document.getElementById("xgrade").value = data['grade'];
            document.getElementById("xsize").value = data['size'];
            document.getElementById("xprice").value = data['price'];
            document.getElementById("xprice_sell").value = data['price_sell'];
        }
    </script>
</x-layout>
