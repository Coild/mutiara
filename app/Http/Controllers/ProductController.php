<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Str;
use Illuminate\Http\Response;


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
            "weight" => "required",
            "pearls" => "required",
            "color" => "required",
            "shape" => "required",
            "grade" => "required",
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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
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

    public function print_sertificate($id)
    {
        // return $id;
        $data = Product::where('id', $id)->first();
        // return $data;
        $pdf = new Fpdf('L', 'mm', 'A5');

        $pdf->SetFont('Arial', 'B', 15);
        $pdf->AddPage();

        // $pdf->Image("storage/img/sertifikat_mutiara.jpg",0,0,210,148);
        $pdf->SetMargins(5, 0, 5);
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 14);
        // $pdf->SetTextColor(255,255,255);
        // $pdf->Cell(95,5,'tes',1, 0,'L');
        $pdf->MultiCell(95, 7, '    Founded in 2019 Lombok Mutiara Sekarbela is a Jewelry gallery that focus on Pearls, Golds, and Silver.
    
    We create our jewelry from scratch and by our experience artisan we process it to a beautiful jewelry that will enhance your looks with our modern and traditional design.
    
    Since our material mostly use 91,6% gold, 70-75% White gold, 92,5% silver and the best pearls in Lombok our jewelry can also be your investment. Ana pearls is your place to go to buy your jewelry that will not only enhance', 1);
        $pdf->SetXY(110, 10);
        // $pdf->MultiCell(95, 5, 'Founded in 2019 Lombok Mutiara Sekarbela is a Jewelry gallery that focus on Pearls, Golds, and Silver.', 1);
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(95, 10, 'CERTIFICATE', 0, 1, 'C');
        $pdf->SetXY(110, 20);
        $pdf->Cell(95, 10, 'OF AUTHENTICITY', 0, 1, 'C');
        $pdf->SetXY(110, 30);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(95, 7, 'This certificate owned by', 0, 1, 'C');
        $pdf->SetXY(110, 37);
        $pdf->Cell(95, 7, 'Lombok Mutiara Sekarbela', 0, 1, 'C');
        $pdf->SetXY(110, 44);
        $pdf->Cell(95, 7, 'The authenticity of the item as follow', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(110, 55);
        $pdf->Cell(30, 5, 'Product Type', 0, 0, 'L');
        $pdf->Cell(65, 5, ': ' . $data->type, 0, 1, 'L');
        $pdf->SetXY(110, 61);
        $pdf->Cell(30, 5, 'Metal', 0, 0, 'L');
        $pdf->Cell(65, 5, ': ' . $data->metal, 0, 1, 'L');
        $pdf->SetXY(110, 67);
        $pdf->Cell(30, 5, 'Carrat', 0, 0, 'L');
        $pdf->Cell(65, 5, ': ' . $data->carat, 0, 1, 'L');
        $pdf->SetXY(110, 73);
        $pdf->Cell(30, 5, 'Weight', 0, 0, 'L');
        $pdf->Cell(65, 5, ': ' . $data->weight, 0, 1, 'L');
        $pdf->SetXY(110, 79);
        $pdf->Cell(30, 5, 'Pearl', 0, 0, 'L');
        $pdf->Cell(65, 5, ': ' . $data->pearls, 0, 1, 'L');
        $pdf->SetXY(110, 85);
        $pdf->Cell(30, 5, 'Color', 0, 0, 'L');
        $pdf->Cell(65, 5, ': ' . $data->color, 0, 1, 'L');
        $pdf->SetXY(110, 91);
        $pdf->Cell(30, 5, 'Shape', 0, 0, 'L');
        $pdf->Cell(65, 5, ': ' . $data->shape, 0, 1, 'L');
        $pdf->SetXY(110, 97);
        $pdf->Cell(30, 5, 'Grade', 0, 0, 'L');
        $pdf->Cell(65, 5, ': ' . $data->grade, 0, 1, 'L');
        $pdf->SetXY(110, 103);
        $pdf->Cell(30, 5, 'Weight', 0, 0, 'L');
        $pdf->Cell(65, 5, ': ' . $data->weight, 0, 1, 'L');
        $pdf->SetXY(110, 109);
        $pdf->Cell(30, 5, 'Size', 0, 0, 'L');
        $pdf->Cell(65, 5, ': ' . $data->size, 0, 1, 'L');
        $pdf->Output();
        exit;
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
            $file->move($location, $filename);
            // In case the uploaded file path is to be stored in the database 
            $filepath = public_path($location . "/" . $filename);
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
                // $name = $importData[1]; //Get user names
                // $email = $importData[3]; //Get the user emails
                $j++;
                try {
                    $string = uniqid(rand());
                    $randomString = substr($string, 0, 8);

                    $data = new Product();
                    $data->type = $importData[1];
                    $data->metal = $importData[2];
                    $data->carat = $importData[3];
                    $data->weight = $importData[4];
                    $data->pearls = $importData[5];
                    $data->color = $importData[6];
                    $data->shape = $importData[7];
                    $data->grade = $importData[8];
                    $data->size = $importData[9];
                    $data->price = $importData[10];
                    $data->price_sell = $importData[11];
                    $data->price_discount = $importData[11];
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
