<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use DateTime;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    public function index()
    {
        $data = Order::get();
        return response()->json([
            'status' => 'success',
            'message' => 'List of Order',
            'data' => $data
        ], 200);
    }

    public function get($id)
    {
        $data = Order::where('id', $id)->first();
        if ($data) {
            return response()->json([
                'status' => 'success',
                'message' => 'Detail Order Found',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Detail Order Not Found',
                'data' => null
            ], 404);
        }
    }

    public function print_invoice($id)
    {
        $order = Order::with(['product'])->where('id', '=', $id)->first();
        // return sizeof($order->product);
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order Not found',
                'data' => null
            ], 404);
        }


        $pdf = new FPDF('L', 'mm', array(200, 110));

        for ($i = 0; $i < sizeof($order->product); $i++) {

            $pdf->SetFont('Arial', 'b', 12);
            $pdf->AddPage();
            $pdf->Image("storage/img/nota2.jpg", 0, 0, 200, 110);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(120, 5, '', 0, 0, 'L');
            $pdf->Cell(20, 5, 'Date', 0, 0, 'L');
            $pdf->Cell(40, 5, ': ' . $order->date, 0, 1, 'L');
            $pdf->Cell(120, 5, '', 0, 0, 'L');
            $pdf->Cell(20, 5, 'Name', 0, 0, 'L');
            $pdf->Cell(40, 5, ': ' . $order->name, 0, 1, 'L');
            $pdf->Cell(120, 5, '', 0, 0, 'L');
            $pdf->Cell(20, 5, 'Phone', 0, 0, 'L');
            $pdf->Cell(40, 5, ': ' . '085xxxxxxxxx', 0, 1, 'L');
            $pdf->Cell(120, 5, '', 0, 0, 'L');
            $pdf->Cell(20, 5, 'Bill No', 0, 0, 'L');
            $pdf->Cell(40, 5, ': ' . str_pad($order->id, 4, "0", STR_PAD_LEFT), 0, 1, 'L');
            $pdf->Cell(120, 5, '', 0, 0, 'L');
            $pdf->Cell(20, 5, 'Payment', 0, 0, 'L');
            $pdf->Cell(40, 5, ': ' . 'Transfer', 0, 1, 'L');
            $pdf->Ln(5);
            $pdf->Cell(20, 5, 'CODE', 0, 0, 'L');
            $pdf->Cell(10, 5, 'QTY', 0, 0, 'L');
            $pdf->Cell(90, 5, 'DESCRIPTION', 0, 0, 'L');
            $pdf->Cell(25, 5, 'UNIT PRICE', 0, 0, 'L');
            $pdf->Cell(10, 5, 'DISC', 0, 0, 'L');
            $pdf->Cell(25, 5, 'AMOUNT', 0, 1, 'L');
            $pdf->Cell(
                200,
                1,
                '---------------------------------------------------' .
                    '------------------------------------------------' .
                    '-------------------------------------------------',
                0,
                1,
                'L'
            );


            $pdf->Cell(20, 5, $order->product[$i]->barcode, 0, 0, 'L');
            $pdf->Cell(10, 5, '1', 0, 0, 'L');
            $pdf->Cell(
                90,
                5,
                $order->product[$i]->type . ", " .
                    $order->product[$i]->metal . ", " .
                    $order->product[$i]->carat . " crt, " .
                    $order->product[$i]->weight . " gr, " .
                    $order->product[$i]->pearls . ", " .
                    $order->product[$i]->color . ", ",
                0,
                0,
                'L'
            );
            $pdf->Cell(25, 5, $order->product[$i]->price_sell, 0, 0, 'L');
            $pdf->Cell(10, 5, $order->product[$i]->discount . ' %', 0, 0, 'L');
            $pdf->Cell(25, 5, $order->product[$i]->price_discount, 0, 1, 'L');
            $pdf->Cell(20, 5, '', 0, 0, 'L');
            $pdf->Cell(10, 5, '', 0, 0, 'L');
            $pdf->Cell(
                90,
                5,
                $order->product[$i]->shape . ", " .
                    $order->product[$i]->grade . ", " .
                    $order->product[$i]->size . " mm",
                0,
                0,
                'L'
            );
            $pdf->Cell(25, 5, '', 0, 0, 'L');
            $pdf->Cell(10, 5, '', 0, 0, 'L');
            $pdf->Cell(25, 5, '', 0, 1, 'L');
            $pdf->ln(10);
            $pdf->Cell(20, 5, '', 0, 0, 'L');
            $pdf->Cell(10, 5, '', 0, 0, 'L');
            $pdf->Cell(90, 5, '', 0, 0, 'L');
            $pdf->Cell(35, 5, 'TOTAL :', 0, 0, 'R');
            $pdf->Cell(25, 5, $order->product[$i]->price_discount, 0, 1, 'L');
        }
        $pdf->Output();
        exit;
    }

    public function agregat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "start" => "required",
            "end" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ], 501);
        }

        // return $order->product;
        // $pro = [];
        // foreach($order as $or){
        //     array_push($pro, $product->name);
        // }
        // return $pro;

        $start = $request->start;
        $end = new DateTime($request->end);
        $end = $end->modify('+1 day');
        $end = $end->format('Y-m-d');

        $data = Order::whereBetween('date', [$start, $end]);
        $order = $data->get();
        // return $start;
        if (count($order) == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order Not found',
                'data' => null
            ], 404);
        }

        // return $order[0]->product[0]->price;

        $total = 0;
        $modal = 0;
        foreach ($order as $or) {
            $total += $or->total;
            foreach ($or->product as $product) {
                $modal += $product->price;
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data Found',
            'total' => $total,
            'modal' => $modal,
            'untung' => $total - $modal,
            'order' => $order
        ], 200);
    }
    public function store(Request $request)
    {
        // return $request;
        $today = Carbon::now()->format('Y-m-d');
        $data = new Order();

        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->payment = $request->payment;
        $data->uang = $request->uang;
        $data->date = $today;
        $data->save();

        $total = 0;
        foreach ($request->order as $r) {
            // return $r['product_id'];

            // $product = Product::where('id', '=', $r['product_id'])->first();
            // return $product;
            // if ($r['discount'] != 0) {
            // if(0 != 0){

            $product = Product::where('id', '=', $r['product_id'])->first();
            // return $product;
            if ($r['discount'] != 0) {
                // if(0 != 0){

                $discount = ($r['discount'] / 100) * $product->price_sell;
                $price_sell = $product->price_sell - $discount;
                $product->price_discount = $price_sell;
                $product->discount = $r['discount'];
                $total += $price_sell;
            } else {
                $total += $product->price_sell;
            }
            // return $product->price;
            $product->status = 1;
            $product->order_id = $data->id;
            $product->update();
        }
        // return $total;
        $data->total = $total;
        $data->kembalian = $request->uang - $total;
        $data->update();
        return response()->json([
            'status' => 'success',
            'message' => 'Order Created',
            'data' => $data
        ], 201);
        // }
    }





    function list_product(array $product)
    {
    }
}
