<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

    public function store(Request $request){
        // return $request;
        $validator = Validator::make($request->all(),[
            "name" => "required",
            "size" => "required",
            "type" => "required",
            "karat" => "required",
            "weight" => "required",
            "price" => "required",
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
        $data->name = $request->name;
        $data->barcode = $randomString;
        $data->size = $request->size;
        $data->type = $request->type;
        $data->karat = $request->karat;
        $data->weight = $request->weight;
        $data->price = $request->price;

        $data->save();
        return response()->json([
            'status' => 'success',
            'message' => 'New Product Created',
            'data' => $data
        ], 201);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "name" => "required",
            "size" => "required",
            "type" => "required",
            "karat" => "required",
            "weight" => "required",
            "price" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ],501);
        }
        
        $data = Product::firstWhere('id',$id);
        if ($data){
            $data->name = $request->name;
            $data->size = $request->size;
            $data->type = $request->type;
            $data->karat = $request->karat;
            $data->weight = $request->weight;
            $data->price = $request->price;
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

    public function generate_barcode($id){
        $data = Product::where('id',$id)->first();
        if($data){
	        // return response()->json([
	        //     'status' => 'success',
	        //     'message' => 'Detail Product Found',
	        //     'data' => $data
	        // ], 200);
            return view('product',["barcode"=>$data->barcode]);
	    }else{
	    	return response()->json([
	            'status' => 'error',
	            'message' => 'Detail Product Not Found',
	            'data' => null
	        ], 404);
	    }

    }
}
