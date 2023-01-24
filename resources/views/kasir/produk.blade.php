<x-layout>
    <x-item.pageheader>
        <x-slot name="name"> Produk </x-slot>
       
    </x-item.pageheader>
    

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">List Produk</h2>
            <button class="btn btn-primary float-right  mr-3    " data-toggle="modal" data-target="#tambah">Tambah</button>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
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
                            <td>{{ $product->karat }}</td>
                            <td>{{ $product->weight . ' gr' }}</td>
                            <td>{{ $product->grade }}</td>
                            <td>{{ 'Rp.' . $product->price }}</td>

                            <td>
                                <a data-toggle="modal" data-target="#edit" class="btn btn-primary" onclick='lempar(@json($product))'><i class="fas fa-edit"></i></a>
                                <button class="btn btn-success" onclick="window.location.href='/product/sertificate/{{$product->id}}'"><i
                                    class="fas fa-print"></i></button>
                                <button class="btn btn-danger btn-delete" onclick="window.location.href='produkhapus?id={{$product->id}}'"><i
                                        class="fas fa-trash"></i></button>
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
                            <label for="name">Name</label>
                            <input type="text" name="name"
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
                            <label for="name">Tyoe</label>
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
                            <label for="name">Karat</label>
                            <input type="text" name="karat"
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
                            <label for="name">Name</label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror" id="xname"
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
                            <label for="name">Tyoe</label>
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
                            <label for="name">Karat</label>
                            <input type="text" name="karat"
                                class="form-control @error('name') is-invalid @enderror" id="xkarat"
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
            document.getElementById("xname").value = data['name'];
            document.getElementById("xsize").value = data['size'];
            document.getElementById("xtype").value = data['type'];
            document.getElementById("xkarat").value = data['karat'];
            document.getElementById("xweight").value = data['weight'];
            document.getElementById("xgrade").value = data['grade'];
            document.getElementById("xprice").value = data['price'];
        }
    </script>
</x-layout>
