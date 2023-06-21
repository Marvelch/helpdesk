<?php

namespace App\Http\Controllers;

use App\Models\RequestHardwareSoftware;
use App\Http\Controllers\Controller;
use App\Models\requestTicket;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class RequestHardwareSoftwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        return view('request_hardware_software.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createRequestTicket($id)
    {
        $requestTickets = requestTicket::find(Crypt::decryptString($id));

        return view('pages.request_hardware_software.create',compact('requestTickets'));
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
    public function show(RequestHardwareSoftware $requestHardwareSoftware)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestHardwareSoftware $requestHardwareSoftware)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestHardwareSoftware $requestHardwareSoftware)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestHardwareSoftware $requestHardwareSoftware)
    {
        //
    }
}
