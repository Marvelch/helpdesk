<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use DB;

class NewsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * displays data for news.
     */
    public function getAll()
    {
        DB::beginTransaction();
        try {

            $getData = News::orderBy('created_at', 'desc')->take(2)->get();

            // Your data
            $data = [
                'message' => 'Success',
                'data' => $getData,
            ];

            // Your custom HTTP status code
            $statusCode = 200; // Change this to the desired status code

            return response()->json($data, $statusCode);

            DB::commit();
            //code...
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();
        }
    }
}
