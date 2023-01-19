<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{$name ?? 'Dashboard'}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6 text-right">
                {{$slot}}
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
