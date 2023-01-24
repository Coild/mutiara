<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(){
    	$data = Product::get();
    	return response()->json([
            'status' => 'success',
            'message' => 'List of Product',
            'data' => $data
        ], 200);
    }

    public function get($id){
        $data = Product::where('id',$id)->first();
        if($data){
	        return response()->json([
	            'status' => 'success',
	            'message' => 'Detail Product Found',
	            'data' => $data
	        ], 200);
	    }else{
	    	return response()->json([
	            'status' => 'error',
	            'message' => 'Detail Product Not Found',
	            'data' => null
	        ], 404);
	    }
    }

    public function getByBarcode($barcode){
        $data = Product::where('barcode',$barcode)->first();
        if($data){
	        return response()->json([
	            'status' => 'success',
	            'message' => 'Detail Product Found',
	            'data' => $data
	        ], 200);
	    }else{
	    	return response()->json([
	            'status' => 'error',
	            'message' => 'Detail Product Not Found',
	            'data' => null
	        ], 404);
	    }
    }

    public function store(Request $request){
        // return $request;
        $validator = Validator::make($request->all(),[
            "type" => "required",
            "metal" => "required",
            "carat" => "required",
            "weight" => "required",
            "pearls" => "required",
            "color" => "required",
            "shape" => "required",
            "grade" => "required",
            "size" => "required",
            "price" => "required",
            "price_sell" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ],501);
        }
      
        $string = uniqid(rand());
        $randomString = substr($string, 0, 8);

        $data = new Product();
        $data->type = $request->type;
        $data->metal = $request->metal;
        $data->carat = $request->carat;
        $data->weight = $request->weight;
        $data->pearls = $request->pearls;
        $data->color = $request->color;
        $data->shape = $request->shape;
        $data->grade = $request->grade;
        $data->size = $request->size;
        $data->price = $request->price;
        $data->price_sell = $request->price_sell;
        $data->price_discount = $request->price_sell;
        $data->barcode = $randomString;
        $data->discount = 0;
        $data->status = 0;

        $data->save();
        return response()->json([
            'status' => 'success',
            'message' => 'New Product Created',
            'data' => $data
        ], 201);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "type" => "required",
            "metal" => "required",
            "carat" => "required",
            "weight" => "required",
            "pearls" => "required",
            "color" => "required",
            "shape" => "required",
            "grade" => "required",
            "size" => "required",
            "price" => "required",
            "price_sell" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ],501);
        }
        
        $data = Product::firstWhere('id',$id);
        if ($data){
            $data->type = $request->type;
            $data->metal = $request->metal;
            $data->carat = $request->carat;
            $data->weight = $request->weight;
            $data->pearls = $request->pearls;
            $data->color = $request->color;
            $data->shape = $request->shape;
            $data->grade = $request->grade;
            $data->size = $request->size;
            $data->price = $request->price;
            $data->price_sell = $request->price_sell;
            $data->price_discount = $request->price_sell;
            $data->update();
            return response()->json([
	            'status' => 'success',
	            'message' => 'Current Product Updated',
	            'data' => $data
	        ], 201);
        }else{
            return response()->json([
	            'status' => 'error',
	            'message' => 'Product Not Found',
	            'data' => null
	        ], 404);
        }
    }

    public function destroy($id){
        $data = Product::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Detail Product Deleted',
            'data' => null
        ], 201);
    }

    public function print_barcode($id){
        $data = Product::where('id',$id)->first();
        if($data){
            return view('product',["barcode"=>$data->barcode]);
	    }else{
	    	return response()->json([
	            'status' => 'error',
	            'message' => 'Detail Product Not Found',
	            'data' => null
	        ], 404);
	    }
    }

    public function print_sertificate($id){
        // return $id;
        $data = Product::where('id',$id)->first();
        // return $data;
        $pdf = new Fpdf('L','mm','A5');

		$pdf->SetFont('Arial', 'B', 15);
        $pdf->AddPage();
        
        $pdf->Image("storage/img/sertifikat_mutiara.jpg",0,0,210,148);
        $pdf->SetMargins(0, 10, 0);
        $pdf->Ln(65);

        $pdf->SetFont('Arial','B',14);
        // $pdf->SetTextColor(255,255,255);
        $pdf->Cell(68,5,'',0, 0,'L');
		$pdf->Cell(40,5,'Material',0, 0,'L');
		$pdf->Cell(100,5,': Material',0, 0,'L');
		$pdf->Ln(6);
        $pdf->Cell(68,5,'',0, 0,'L');
		$pdf->Cell(40,5,'Pearl',0, 0,'L');
		$pdf->Cell(100,5,': '.$data->type,0, 0,'L');
		$pdf->Ln(6);
        $pdf->Cell(68,5,'',0, 0,'L');
		$pdf->Cell(40,5,'Pearl Weight',0, 0,'L');
		$pdf->Cell(100,5,': '.$data->weight,0, 0,'L');
		$pdf->Ln(6);
        $pdf->Cell(68,5,'',0, 0,'L');
		$pdf->Cell(40,5,'Grade',0, 0,'L');
		$pdf->Cell(100,5,': '.$data->grade,0, 0,'L');
		$pdf->Ln(6);
        $pdf->Cell(68,5,'',0, 0,'L');
		$pdf->Cell(40,5,'Color',0, 0,'L');
		$pdf->Cell(100,5,': Material',0, 0,'L');
		$pdf->Ln(6);
        $pdf->Output();
        exit;
    }
}
