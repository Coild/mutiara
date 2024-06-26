<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Generate Barcode</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/a4.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    @php
        $i = 0;
    @endphp

    @foreach ($data as $item)
        @php
            $i++;
        @endphp
        @if ($i == 1)
            <div class="page">
        @endif
        <div class="column">
            <table class="col-md-4">

                <thead class="balik" style="width: 150px; height: 15px; font-size: 10px;">
                    <th style=" float:left">
                        {{ $item->barcode }}
                    </th>
                </thead style="width: 150px">
                <tr class="balik" style="width: 150px; height:15px">
                    <td>
                        {!! '<img src="data:image/png;base64,' .
                            DNS1D::getBarcodePNG($item->barcode, 'C128', 1, 11) .
                            '" alt="barcode"   />' !!}
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid black;">

                    </td>
                </tr>
                <tr style="height: 15px; font-size: 10px; border-bottom: 1px solid black;">
                    <td style="width: 100px;">
                        <div style="width: 80px;  margin-top: 2px;">
                            <small style="float:left">{{  $item->carat == '-' ?  '-': rtrim(number_format($item->carat, 2), '0')  }}</small>
                            <small style="float:right">%</small>
                        </div>

                    </td>
                </tr>
                <tr style="height: 15px; font-size: 10px; border-bottom: 1px solid black;">
                    <td style="width: 100px;">
                        <div style="width: 80px">
                            <small style="float:left">{{ $item->weight1 }}</small>
                            <small style="float:right">.gr</small>
                        </div>

                    </td>
                </tr>
                <tr style="height: 15px; font-size: 10px; border-bottom: 1px solid black;">
                    <td style="width: 100px;">
                        <div style="width: 80px">
                            <small style="float:left">{{ $item->weight2 }}</small>
                            <small style="float:right">.gr</small>
                        </div>

                    </td>
                </tr>
                <tr style="height: 15px; font-size: 10px;">
                    <td style="width: 100px;">
                        <div style="width: 80px">
                            <small style="float:left">Rp</small>
                            <small style="float:right">{{ number_format($item->price_sell, 0, ',', '.') }}</small>
                        </div>

                    </td>
                </tr>
            </table>
        </div>
        @if ($i % 48 == 0)
            </div>
            <div class="page">
        @endif
    @endforeach

    </div>
</body>

</html>
