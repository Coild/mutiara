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


        $pdf = new FPDF('L', 'mm', array(215, 138));

        for ($i = 0; $i < sizeof($order->product); $i++) {

            $pdf->SetFont('Arial', 'b', 12);
            $pdf->AddPage();
            $pdf->Image("storage/img/nota.jpg", 0, 0, 215, 138);
            $pdf->Cell(0, 5, 'Nota Pembelian', 0, 0, 'C');
            $pdf->Ln(5);
            $pdf->Cell(0, 5, 'LOMBOK MUTIARA', 0, 0, 'C');
            $pdf->Ln(5);
            $pdf->Cell(0, 5, '---------------------------------------------------------', 0, 0, 'C');
            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(20, 5, 'Kasir', 0, 0, 'L');
            $pdf->Cell(20, 5, ': Fulan', 0, 0, 'L');
            $pdf->Cell(110, 5, '', 0, 0, 'L');
            $pdf->Cell(20, 5, 'No. Nota', 0, 0, 'L');
            $pdf->Cell(20, 5, ': ' . str_pad($order->id, 4, "0", STR_PAD_LEFT), 0, 0, 'L');
            $pdf->Ln(5);
            $pdf->Cell(20, 5, 'Buyer', 0, 0, 'L');
            $pdf->Cell(20, 5, ': ' . $order->name, 0, 0, 'L');
            $pdf->Cell(110, 5, '', 0, 0, 'L');
            $pdf->Cell(20, 5, 'Date ', 0, 0, 'L');
            $pdf->Cell(20, 5, ': ' . $order->date, 0, 0, 'L');
            $pdf->Ln(8);
            $pdf->Cell(10, 5, 'No', 0, 0, 'L');
            $pdf->Cell(10, 5, 'Qty', 0, 0, 'L');
            $pdf->Cell(20, 5, 'Product', 0, 0, 'L');
            $pdf->Cell(100, 5, 'Description', 0, 0, 'L');
            $pdf->Cell(15, 5, 'Price', 0, 0, 'L');
            $pdf->Cell(15, 5, 'Disc', 0, 0, 'L');
            $pdf->Cell(25, 5, 'Total', 0, 1, 'L');

            $pdf->Cell(0, 2, '----------------------------------------------------------------------------------------------------------------------------------------------------------------------
        ', 0, 1, 'L');

            $pdf->Cell(10, 5, '1', 0, 0, 'L');
            $pdf->Cell(10, 5, '1', 0, 0, 'L');
            $pdf->Cell(20, 5, $order->product[$i]->type, 0, 0, 'L');
            $pdf->Cell(
                100,
                5,
                $order->product[$i]->shape . ", " .
                    $order->product[$i]->pearls . ", " .
                    $order->product[$i]->color . ", " .
                    $order->product[$i]->size . " mm, ",
                0,
                0,
                'L'
            );
            $pdf->Cell(15, 5, $order->product[$i]->price_sell, 0, 0, 'L');
            $pdf->Cell(15, 5, $order->product[$i]->discount . ' %', 0, 0, 'L');
            $pdf->Cell(25, 5, $order->product[$i]->price_discount, 0, 1, 'L');
            $pdf->Cell(10, 5, '', 0, 0, 'L');
            $pdf->Cell(10, 5, '', 0, 0, 'L');
            $pdf->Cell(20, 5, '', 0, 0, 'L');
            $pdf->Cell(
                100,
                5,
                "Grade " . $order->product[$i]->grade . ", " .
                    $order->product[$i]->weight . " gr, " .
                    $order->product[$i]->carat . " carat, ",
                0,
                0,
                'L'
            );
            $pdf->Cell(15, 5, '', 0, 0, 'L');
            $pdf->Cell(15, 5, '', 0, 0, 'L');
            $pdf->Cell(25, 5, '', 0, 1, 'L');

            $pdf->Ln(5);
            $pdf->Cell(0, 5, 'Diterima Oleh', 0, 0, 'L');
            $pdf->Ln(25);
            $pdf->Cell(0, 5, '-----------------------------------', 0, 1, 'L');
            $pdf->Cell(0, 5, $order->name, 0, 0, 'L');
            $pdf->Ln(5);
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
        // return $request->order;
        $today = Carbon::now()->format('Y-m-d');
        $data = new Order();

        $data->name = $request->name;
        $data->uang = $request->uang;
        $data->date = $today;
        $data->save();

        $total = 0;
        foreach ($request->order as $r) {
            // return $r['product_id'];

            $product = Product::where('id', '=', $r['product_id'])->first();
            // return $product;
            if ($r['discount'] != 0) {
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
        }
    }





    function list_product(array $product)
    {
    }
}
