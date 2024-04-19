<?php

namespace App\Http\Controllers;

use App\Models\signature;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reservation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use DB;

class SignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $result = reservation::where('unique',$id)->first();

        return view('signature',compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(signature $signature)
    {
        return view('submited');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(signature $signature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $unique_rev)
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
        $res = reservation::where('unique', $unique_rev)->first();

        $response = Http::get('http://10.10.30.14:1024/api/reservation/user', ['term' => $res->assign_to]);

        if ($response->successful() && $response->json() !== null) {
        // Get the response data
        $responseData = $response->json();

        // Ensure response data is not empty and has the expected structure
        if ($response->successful() && $response->json() !== null) {
            $employee_phone = $responseData[0]['phone'];

            // Check if the phone number starts with '0', then replace it with '62'
            if (substr($employee_phone, 0, 1) === '0') {
                $employee_phone = '62' . substr($employee_phone, 1);
            }

            $notificationData = [
                'name' => $res->full_name,
                'unique' => $unique_rev,
                'employee_name' => ucfirst($res->employee_name),
                'visit_date' => $res->visit_date,
                'total_visitor' => $res->total_visitor,
                'purpose_of_visit' => $res->purpose_of_visit,
                'employee_phone' => $employee_phone
                // Add any other data you need to send
            ];
        } else {
            // Handle the case where response data is empty or the key doesn't exist
            $default_phone = '6282217797018'; // Provide a default phone number
            $notificationData = [
                'name' => $res->full_name,
                'unique' => $unique_rev,
                'employee_name' => ucfirst($res->employee_name) ? ucfirst($res->employee_name) : 'Unknown',
                'visit_date' => $res->visit_date,
                'total_visitor' => $res->total_visitor,
                'purpose_of_visit' => $res->purpose_of_visit,
                'employee_phone' => $default_phone
                // Add any other data you need to send
            ];
        }

        // Send notification
        $response = Http::post('http://10.10.30.14:8888/wa/reservation/notification', $notificationData);
    }

    reservation::where('unique', $unique_rev)->update([
        'signature_visitor' => $path
    ]);

    DB::commit();

    return redirect()->route('signature_submited');
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
    public function destroy(signature $signature)
    {
        //
    }
}
