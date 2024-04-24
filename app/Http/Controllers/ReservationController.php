<?php

namespace App\Http\Controllers;

use App\Models\reservation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;
use DB;
use Illuminate\Support\Facades\App;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('reservation');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public static function generateUniqueCode($length = 4)
    {
        $code = strtoupper(Str::random($length)); // Gunakan str_random() untuk meng-generate string acak
        while (static::codeExists($code)) {
            $code = strtoupper(Str::random($length));
        }
        return $code;
    }

    protected static function codeExists($code)
    {
        // Lakukan pengecekan apakah kode sudah digunakan sebelumnya dalam database
        return reservation::where('unique', $code)->exists(); // Ganti YourModel dengan model yang sesuai
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
        // Make an asynchronous request to fetch data
        $response = Http::get('http://10.10.30.14:1024/api/reservation/user', ['term' => $request->employee]);

        // Proceed with creating the reservation
        $unique_code = 'RV-'.generateUniqueCode();

        $responseData = json_decode($response);

        reservation::create([
            'unique' => $unique_code,
            'full_name' => $request->full_name,
            'company' => $request->company,
            'total_visitor' => $request->total_visitor,
            'visitor_name' => $request->visitor_name,
            'purpose_of_visit' => $request->purpose_of_visit,
            'visit_date' => $request->visit_date,
            'expected_arrival_time' => $request->expected_arrival_time,
            'assign_to' => $responseData[0]->code,
            'employee_name' => $responseData[0]->name,
            'status' => 0,
            'phone' => $request->phone
        ]);

        return redirect()->route('signature_store', ['unique' => $unique_code]);
        } catch (\Throwable $th) {
            // Handle any exceptions
            return $th->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(reservation $reservation)
    {
        $response = Http::get('http://10.10.30.14:1024/api/reservation/find-people', ['term' => Auth::user()->id_people]);

        // Decode the JSON response
        $data = $response->json();

        if (empty(trim($data[0]['sub_bagian']))) {
            toast('ERP Data Sub_bagian INCOMPLETE', 'error');
            return back();
        } else {
            // Access the sub_bagian value
            $sub_bagian = $data[0]['sub_bagian'];
        }

        if ($sub_bagian == 'SECURITY') {
            $results = Reservation::orderBy('created_at', 'desc')->get();
        } else {
            $results = Reservation::where('assign_to', $data[0]['code'])
                                ->orderBy('created_at', 'desc')
                                ->get();
        }


        return view('pages.reservation.show',compact('results'));
    }

    /**
     * Display the specified resource.
     */
    public function print($id)
    {
        // $pdf = App::make('dompdf.wrapper');;

        $data = reservation::where('unique',$id)->first();

        $pdf = Pdf::loadView('pages.reservation.print', ['data' => $data]);

        return $pdf->stream();

        // $pdf = PDF::loadView('pages.reservation.print', compact('data'));
        // $pdf->setPaper('A4', 'portrait');
        // $sales_report_file_name = "daily_sales_".date('Y-m-d').".pdf";
        // return $pdf->stream($sales_report_file_name);
        // return $pdf->download('pages.reservation.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $results = reservation::where('unique',$id)->first();

        return view('pages.reservation.edit',compact('results'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $signatureData = $request->input('signature');

        // Get the path to the storage folder
        $folderPath = 'public/';

        $image_parts = explode(";base64,", $signatureData);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $unique = uniqid();

        // Create a temporary file to store the base64 data
        $tempFilePath = sys_get_temp_dir() . '/' . $unique . '.' . $image_type;
        file_put_contents($tempFilePath, $image_base64);

        // Create an UploadedFile instance from the temporary file
        $file = new UploadedFile($tempFilePath, $unique . '.' . $image_type, mime_content_type($tempFilePath), null, true);

        // Store the file in the storage using its original name and extension
        $path = $file->storeAs($folderPath, $file->getClientOriginalName());

        // Delete the temporary file
        unlink($tempFilePath);

        DB::beginTransaction();

        try {
            $result = reservation::where('unique', $id)->first();

            reservation::where('unique', $id)->update([
                'signature_employee' => $path
            ]);

            if (substr($result->phone, 0, 1) === '0') {
                $employee_phone = '62' . substr($result->phone, 1);
            }

            $notificationData = [
                'name' => ucfirst($result->full_name),
                'employee_name' => ucfirst($result->employee_name),
                'visit_date' => $result->visit_date,
                'visitor_phone' => $employee_phone,
                // Add any other data you need to send
            ];

            $url = "http://10.10.30.14:8888/wa/reservation/notification/visitor";

            Http::post($url, $notificationData);

            DB::commit();

            return redirect()->route('reservation_show');
        } catch (\Throwable $th) {
            // Handle the exception as needed
            DB::rollback();

            toast($th->getMessage(), 'error');
            // Log or return the exception
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(reservation $reservation)
    {
        //
    }
}
