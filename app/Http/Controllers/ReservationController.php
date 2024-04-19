<?php

namespace App\Http\Controllers;

use App\Models\reservation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;
use Auth;
use DB;

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
            'status' => 0
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

        // Access the sub_bagian value
        $sub_bagian = $data[0]['sub_bagian'];

        if($sub_bagian == 'SECURITY') {
            $results = reservation::all();
        }else{
            $results = reservation::where('assign_to',$data[0]['code'])->get();
        }

        return view('pages.reservation.show',compact('results'));
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

        // Store the file in the storage
        // $path = $file->store($folderPath);

        // Store the file in the storage using its original name and extension
        $path = $file->storeAs($folderPath, $file->getClientOriginalName());

        // Delete the temporary file
        unlink($tempFilePath);

        DB::beginTransaction();

        try {
            reservation::where('unique', $id)->update([
                'signature_employee' => $path
            ]);

            DB::commit();

            return redirect()->route('reservation_show');
        } catch (\Throwable $th) {
            // Handle the exception as needed
            DB::rollback();
            // Log or return the exception
            return $th;
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
