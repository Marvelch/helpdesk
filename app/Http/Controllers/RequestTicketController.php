<?php

namespace App\Http\Controllers;

use App\Models\requestTicket;
use App\Http\Controllers\Controller;
use App\Models\company;
use App\Models\division;
use Illuminate\Http\Request;

class RequestTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companys = company::all();
        $divisions = division::all();

        return view('pages.request_ticket.index',compact('companys','divisions'));
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
    public function show(requestTicket $requestTicket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(requestTicket $requestTicket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, requestTicket $requestTicket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(requestTicket $requestTicket)
    {
        //
    }
}
