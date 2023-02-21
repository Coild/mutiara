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
                @foreach ($cek as $product)
                    <tr>
                        <td>{{ $loop->index+1}}</td>
                        <td>{{ "100" }}</td>
                        <td>{{ "100" }}</td>
                        <td>{{ "100" }}</td>
                        <td>{{ "100" }}</td>
                        <td>{{ "100" . ' gr' }}</td>
                        <td>{{ "100" }}</td>
                        <td>{{ 'Rp.' . "100" }}</td>

                        <td>
                            {{-- <a data-toggle="modal" data-target="#edit" class="btn btn-primary" onclick='lempar(@json($product))'><i class="fas fa-edit"></i></a>
                            <button class="btn btn-success" onclick="window.location.href='/product/sertificate/{{$product->id}}'"><i
                                class="fas fa-print"></i></button>
                            <button class="btn btn-danger btn-delete" onclick="window.location.href='produkhapus?id={{$product->id}}'"><i
                                    class="fas fa-trash"></i></button> --}}
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
</div>   