<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laravel Generate Barcode Examples</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
    @foreach ($data as $item)
        <table style="display: inline-block;margin: 2.5px;width: 190px;overflow:hidden;position:relative;padding: 1px;margin: 0px; background:; ">
            <tbody>
                <tr>
                    <td>
                        {!!'<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($item->barcode, 'C128',2,50,array(1,1,1), true) . '" alt="barcode"   />'!!}
                    </td>
                </tr>
            </tbody>
        </table>
    @endforeach
</body>
</html>