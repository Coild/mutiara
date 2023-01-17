<x-layout>
    <x-item.pageheader> </x-item.pageheader>
<div class="card">
    <div class="card-body">
        <div class="row">
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
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Total</th>
                    <th>Received Amount</th>
                    <th>Status</th>
                    <th>To Pay</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                    <td>{{'1'}}</td>
                    <td>{{'Reza R'}}</td>
                    <td>{{ '$' }} {{'100000'}}</td>
                    <td>{{ '$' }} {{'10000'}}</td>
                    <td>
                        @if(0 == 0)
                            <span class="badge badge-danger">Not Paid</span>
                        @elseif(0 < 1)
                            <span class="badge badge-warning">Partial</span>
                        @elseif(0 == 1)
                            <span class="badge badge-success">Paid</span>
                        @elseif(0 > 1)
                            <span class="badge badge-info">Change</span>
                        @endif
                    </td>
                    <td>{{'$'}} {{'100000'}}</td>
                    <td>{{'15000'}}</td>
                </tr>
                
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th>{{ '$' }} {{ '100000' }}</th>
                    <th>{{ '$' }} {{ '120000' }}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        {{-- {{ $orders->render() }} --}}
    </div>
</div>    
</x-layout>