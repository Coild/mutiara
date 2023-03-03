<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laravel Generate Barcode Examples</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/a4.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="page">
    @foreach ($data as $item)
    <div class="column">
        <table class="col-md-3">
            <tr>
                <td class="text-left">
                    <h6>{{$item['type'].' '.$item['metal'].$item['carat'].' Carat'}}</h6>
                </td>
            </tr>
            <tr>
                <td class="text-left">
                    {!! '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($item->barcode, 'C128', 2, 22) . '" alt="barcode"   />' !!}
                </td>
            </tr>
            <tr>
                <td class="text-left">
                    <small style="font-size: 12px">

                        {{ $item->barcode }}
                    </small>
                </td>
            </tr>
        </table>
    </div>
        {{-- {!! '<img src="data:image/png;base64,' .
            DNS1D::getBarcodePNG($item->barcode, 'C128', 2, 50, [1, 1, 1], true) .
            '" alt="barcode"   />' !!} --}}
    @endforeach
    </div>
</body>

</html>
