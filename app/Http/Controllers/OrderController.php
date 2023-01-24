<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    public function index(){
    	$data = Order::get();
    	return response()->json([
            'status' => 'success',
            'message' => 'List of Order',
            'data' => $data
        ], 200);
    }

    public function get($id){
        $data = Order::where('id',$id)->first();
        if($data){
	        return response()->json([
	            'status' => 'success',
	            'message' => 'Detail Order Found',
	            'data' => $data
	        ], 200);
	    }else{
	    	return response()->json([
	            'status' => 'error',
	            'message' => 'Detail Order Not Found',
	            'data' => null
	        ], 404);
	    }
    }

    public function store(Request $request){
        // return $request->order;
        $today = Carbon::now()->format('Y-m-d');
        $data = new Order();

        $data->name = $request->name;
        $data->uang = $request->uang;
        $data->date = $today;
        $data->save();

        $total=0;
        foreach($request->order as $r){
            // return $r['product_id'];

            $product = Product::where('id','=',$r['product_id'])->first();
            // return $product;
        
            // return $product->price;
            $total+=$product->price;
            $product->status=1;
            $product->order_id = $data->id;
            $product->update();
        }
        // return $total;
        $data->total = $total;
        $data->kembalian = $request->uang-$total;
        $data->update();
        return response()->json([
            'status' => 'success',
            'message' => 'Order Created',
            'data' => $data
        ], 201);
    }

    public function print_invoice($id){
        $order = Order::with(['product'])->where('id','=',$id)->first();
        // return $order;
        $pdf = new FPDF('P','mm',array(100,150));
        $pdf->SetFont('Arial', 'b', 12);
        $pdf->AddPage();
        $pdf->Cell(0,5,'Nota Pembelian',0, 0,'C');
        $pdf->Ln(5);
        $pdf->Cell(0,5,'LOMBOK MUTIARA',0, 0,'C');
        $pdf->Ln(5);
        $pdf->Cell(0,5,'---------------------------------------------------------',0, 0,'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20,5,'Kasir',0, 0,'L');
        $pdf->Cell(20,5,': Fulan',0, 0,'L');
        $pdf->Ln(5);
        $pdf->Cell(20,5,'Pembeli',0, 0,'L');
        $pdf->Cell(20,5,': '.$order->name,0, 0,'L');
        $pdf->Ln(8);
        $pdf->Cell(10,5,'Qty',1, 0,'L');
        $pdf->Cell(20,5,'Product',1, 0,'L');
        $pdf->Cell(15,5,'Wight',1, 0,'L');
        $pdf->Cell(15,5,'Karat',1, 0,'L');
        $pdf->Cell(15,5,'Price',1, 1,'L');
        foreach($order->product as $or){
            $pdf->Cell(10,5,'1',1, 0,'L');
            $pdf->Cell(20,5,$or->name,1, 0,'L');
            $pdf->Cell(15,5,$or->weight.' gr',1, 0,'L');
            $pdf->Cell(15,5,$or->karat.' K',1, 0,'L');
            $pdf->Cell(15,5,number_format($or->price, 0, ',', '.'),1, 1,'L');
        }
        $pdf->Ln(5);
        $pdf->Cell(0,5,'----------------------------------',0, 0,'L');
        $pdf->Ln(5);
        $pdf->Cell(15,5,'Total',0, 0,'L');
        $pdf->Cell(20,5,': Rp.'.number_format($order->total, 0, ',', '.'),0, 1,'L');
        $pdf->Cell(15,5,'Uang',0, 0,'L');
        $pdf->Cell(20,5,': Rp.'.number_format($order->uang, 0, ',', '.'),0, 1,'L');
        $pdf->Cell(15,5,'Kembali',0, 0,'L');
        $pdf->Cell(20,5,': Rp.'.number_format($order->kembalian, 0, ',', '.'),0, 1,'L');
        $pdf->Cell(0,5,'-----------------------------------',0, 0,'L');
        $pdf->Ln(5);
        $pdf->Output();
        exit;
    }

    public function agregat(Request $request){
        $validator = Validator::make($request->all(),[
            "start" => "required",
            "end" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ],501);
        }

        $order = Order::with(['product'])->get();
        return $order->product;
        // $pro = [];
        // foreach($order as $or){
        //     array_push($pro, $product->name);
        // }
        // return $pro;
        
        $start = $request->start;
        $end = $request->end;

        $pdf = new Fpdf('P','mm','A4');

		$pdf->SetFont('Arial', 'B', 15);
        $pdf->AddPage();
        
        // $pdf->Image("images/abitour.jpeg",0,0,205,297);
        // $pdf->SetMargins(20, 10, 0);
        $pdf->Ln(6);

        $pdf->SetFont('Arial','B',16);
        $pdf->Image("storage/img/logo_mutiara.png",12,8,34,22.455);
		// $pdf->Cell(40,5,'',1, 0,'C');
        // $pdf->Cell(145,5,'LAPORAN KEUANGAN',1, 0,'L');
       
		$pdf->Ln(15);
        $pdf->Cell(190,5,'------------------------------------------------------------------------------------------------------',0, 1,'C');
		$pdf->Ln(5);
        $pdf->Cell(190,5,'LAPORAN KEUANGAN',0, 1,'C');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',10);
        $pdf->Cell(10,6,'No',1, 0,'C');
        $pdf->Cell(25,6,'Tanggal',1, 0,'C');
        $pdf->Cell(50,6,'Pembeli',1, 0,'C');
        $pdf->Cell(55,6,'Produk',1, 0,'C');
        $pdf->Cell(50,6,'Jumlah',1, 1,'C');

        $pdf->SetFont('Arial','',10);
        $pdf->Cell(10,6,'No',1, 0,'C');
        $pdf->Cell(25,6,$order[0]->date,1, 0,'C');
        $pdf->Cell(50,6,$order[0]->name,1, 0,'C');

        

        $pdf->Cell(55,6,'Produk',1, 0,'C');
        $pdf->Cell(50,6,'Jumlah',1, 0,'C');

		

        $pdf->Output();

        exit;
    }

    function list_product(array $product){

    }
}
