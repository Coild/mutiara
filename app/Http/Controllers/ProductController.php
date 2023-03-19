<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Response;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::get();
        return response()->json([
            'status' => 'success',
            'message' => 'List of Product',
            'data' => $data
        ], 200);
    }

    public function get($id)
    {
        $data = Product::where('id', $id)->first();
        if ($data) {
            return response()->json([
                'status' => 'success',
                'message' => 'Detail Product Found',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Detail Product Not Found',
                'data' => null
            ], 404);
        }
    }

    public function getByBarcode($barcode)
    {
        $data = Product::where('barcode', $barcode)->first();
        if ($data) {
            return response()->json([
                'status' => 'success',
                'message' => 'Detail Product Found',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Detail Product Not Found',
                'data' => null
            ], 404);
        }
    }

    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [
            "type" => "required",
            "metal" => "required",
            "carat" => "required",
            "weight1" => "required",
            "pearls" => "required",
            "color" => "required",
            "shape" => "required",
            "grade" => "required",
            "weight2" => "required",
            "size" => "required",
            "price" => "required",
            "price_sell" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ], 501);
        }

        $string = uniqid(rand());
        $randomString = substr($string, 0, 8);

        $data = new Product();
        $data->type = $request->type;
        $data->metal = $request->metal;
        $data->carat = $request->carat;
        $data->weight1 = $request->weight1;
        $data->pearls = $request->pearls;
        $data->color = $request->color;
        $data->shape = $request->shape;
        $data->grade = $request->grade;
        $data->weight2 = $request->weight2;
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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "type" => "required",
            "metal" => "required",
            "carat" => "required",
            "weight1" => "required",
            "pearls" => "required",
            "color" => "required",
            "shape" => "required",
            "grade" => "required",
            "weight2" => "required",
            "size" => "required",
            "price" => "required",
            "price_sell" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ], 501);
        }

        $data = Product::firstWhere('id', $id);
        if ($data) {
            $data->type = $request->type;
            $data->metal = $request->metal;
            $data->carat = $request->carat;
            $data->weight1 = $request->weight1;
            $data->pearls = $request->pearls;
            $data->color = $request->color;
            $data->shape = $request->shape;
            $data->grade = $request->grade;
            $data->weight2 = $request->weight2;
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
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Product Not Found',
                'data' => null
            ], 404);
        }
    }

    public function destroy($id)
    {
        $data = Product::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Detail Product Deleted',
            'data' => null
        ], 201);
    }

    public function print_barcode($id)
    {
        $data = Product::where('id', $id)->first();
        if ($data) {
            return view('product', ["barcode" => $data->barcode]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Detail Product Not Found',
                'data' => null
            ], 404);
        }
    }

    public function print_all_barcode()
    {
        // return "tes";
        $data = Product::all();
        if ($data) {
            return view('barcode', compact('data'));
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Detail Product Not Found',
                'data' => null
            ], 404);
        }
    }

    public function print_sertificate($id)
    {
        // return $id;
        $data = Product::where('id', $id)->first();
        // return $data;
        $pdf = new Fpdf('L', 'mm', array(104, 140));

        $pdf->SetFont('Arial', 'B', 15);
        $pdf->AddPage();

        $pdf->Image("storage/img/sertif2.jpg", 0, 0, 140, 104);
        $pdf->SetMargins(0, 0, 0);


        $pdf->SetFont('Times', '', 9);
        // $pdf->SetXY(96, 34);
        $pdf->Ln(20);
        $pdf->Cell(76, 5, '', 0, 0, 'L');
        $pdf->Cell(20, 5, 'Product Type', 0, 0, 'L');
        $pdf->Cell(44, 5, ': ' . $data->type, 0, 1, 'L');
        $pdf->Cell(76, 5, '', 0, 0, 'L');
        $pdf->Cell(20, 5, 'Metal', 0, 0, 'L');
        $pdf->Cell(44, 5, ': ' . $data->metal, 0, 1, 'L');
        $pdf->Cell(76, 5, '', 0, 0, 'L');
        $pdf->Cell(20, 5, 'Carat', 0, 0, 'L');
        $pdf->Cell(44, 5, ': ' . $data->carat . ' crt', 0, 1, 'L');
        $pdf->Cell(76, 5, '', 0, 0, 'L');
        $pdf->Cell(20, 5, 'Weight', 0, 0, 'L');
        $pdf->Cell(44, 5, ': ' . $data->weight1 . ' gr', 0, 1, 'L');
        $pdf->Cell(76, 5, '', 0, 0, 'L');
        $pdf->Cell(20, 5, 'Pearls', 0, 0, 'L');
        $pdf->Cell(44, 5, ': ' . $data->pearls, 0, 1, 'L');
        $pdf->Cell(76, 5, '', 0, 0, 'L');
        $pdf->Cell(20, 5, 'Color', 0, 0, 'L');
        $pdf->Cell(44, 5, ': ' . $data->color, 0, 1, 'L');
        $pdf->Cell(76, 5, '', 0, 0, 'L');
        $pdf->Cell(20, 5, 'shape', 0, 0, 'L');
        $pdf->Cell(44, 5, ': ' . $data->shape, 0, 1, 'L');
        $pdf->Cell(76, 5, '', 0, 0, 'L');
        $pdf->Cell(20, 5, 'Grade', 0, 0, 'L');
        $pdf->Cell(44, 5, ': ' . $data->grade, 0, 1, 'L');
        $pdf->Cell(76, 5, '', 0, 0, 'L');
        $pdf->Cell(20, 5, 'Weight', 0, 0, 'L');
        $pdf->Cell(44, 5, ': ' . $data->weight2 . ' gr', 0, 1, 'L');
        $pdf->Cell(76, 5, '', 0, 0, 'L');
        $pdf->Cell(20, 5, 'Size', 0, 0, 'L');
        $pdf->Cell(44, 5, ': ' . $data->size . ' mm', 0, 1, 'L');
        $pdf->Output();
        exit;
    }

    public function import(Request $request)
    {
        $file = $request->file('uploaded_file');
        Excel::import(new ProductImport, $file->store('files'));
        return redirect(route('produk'));
        // return redirect('/')->with('success', 'All good!');
    }

    public function uploadContent(Request $request)
    {
        $file = $request->file('uploaded_file');

        if ($file) {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize(); //Get size of uploaded file in bytes
            //Check for file extension and size
            $this->checkUploadedFileProperties($extension, $fileSize);
            //Where uploaded file will be stored on the server 
            $location = 'uploads'; //Created an "uploads" folder for that
            // Upload file
            // $file->storeAs($location, $filename);
            // In case the uploaded file path is to be stored in the database 
            $filepath = $location . "/" . $filename;

            // $file->move($location, $filename);
            move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $filepath . '.' . $extension);

            // Reading file
            $file = fopen($filepath, "r");
            $importData_arr = array(); // Read through the file and store the contents as an array
            $i = 0;
            //Read the contents of the uploaded file 
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);
                // Skip first row (Remove below comment if you want to skip the first row)
                if ($i == 0) {
                    $i++;
                    continue;
                }
                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata[$c];
                }
                $i++;
            }
            fclose($file); //Close after reading
            $j = 0;
            foreach ($importData_arr as $importData) {
                $j++;
                try {
                    $string = uniqid(rand());
                    $randomString = substr($string, 0, 8);

                    $data = new Product();
                    $data->type = $importData[1];
                    $data->metal = $importData[2];
                    $data->carat = $importData[3];
                    $data->weight1 = $importData[4];
                    $data->pearls = $importData[5];
                    $data->color = $importData[6];
                    $data->shape = $importData[7];
                    $data->grade = $importData[8];
                    $data->weight2 = $importData[9];
                    $data->size = $importData[10];
                    $data->price = $importData[11];
                    $data->price_sell = $importData[12];
                    $data->price_discount = $importData[12];
                    $data->barcode = $randomString;
                    $data->discount = 0;
                    $data->status = 0;

                    $data->save();
                } catch (\Exception $e) {
                    //throw $th;
                    // DB::rollBack();
                }
            }
            // return view('pro')
            return redirect(route('produk'));
            // return response()->json([
            //     'message' => "$j records successfully uploaded"
            // ]);
        } else {
            //no file was uploaded
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
    }
    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = array("csv", "xlsx"); //Only want csv and excel files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {
            } else {
                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
            }
        } else {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
        }
    }
}
