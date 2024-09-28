<x-layout title="Laporan Keuangan">
    <x-item.pageheader>
        <x-slot name="name"> Laporan Keuangan </x-slot>
    </x-item.pageheader>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-7"></div>
                <div class="col-md-5">
                    <form action="{{ route('order.agregat') }}" method="post">
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
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="form-group row">
                        <label for="totalrp"
                            class="col-lg-4 control-label text-center text-nowrap pt-2">Pendapatan</label>
                        <div class="col-lg-8">
                            <input type="text" value="{{ $total }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label for="totalrp" class="col-lg-4 control-label text-center text-nowrap pt-2">Modal</label>
                        <div class="col-lg-8">
                            <input type="text" value="{{ $modal }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label for="totalrp" class="col-lg-4 control-label text-center text-nowrap pt-2">Untung</label>
                        <div class="col-lg-8">
                            <input type="text" value="{{ $total - $modal }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            

            <table id="orders-table" class="display responsive nowrap" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pembeli</th>
                        <th>Total</th>
                        <th>Tanggal Transaksi</th>
                        <th>Detail</th>
                    </tr>
                </thead>
            </table>
            <table class="table">
                <tr>
                    <th></th>
                    <th></th>
                    <th>{{ 'Rp' }} {{ $total }}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>
</x-layout>
