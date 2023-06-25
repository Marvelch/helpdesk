<?php

namespace App\Http\Controllers;

use App\Models\RequestHardwareSoftware;
use App\Http\Controllers\Controller;
use App\Models\detailRequestHardwareSoftware;
use App\Models\inventory;
use App\Models\requestTicket;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use PhpParser\Node\Stmt\TryCatch;
use Auth;
use DB;
use Alert;
use Illuminate\Support\Str;

class RequestHardwareSoftwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requestHardwareSoftware = RequestHardwareSoftware::all();

        return view('pages.request_hardware_software.index',compact('requestHardwareSoftware'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventorys = inventory::all();

        return view('pages.request_hardware_software.create',compact('inventorys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createRequestTicket($id)
    {
        $requestTickets = requestTicket::find(Crypt::decryptString($id));

        return view('pages.request_hardware_software.create_ticket',compact('requestTickets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $generateUniqueCode = generateUniqueCode();

            RequestHardwareSoftware::create([
                'unique_request'        => $generateUniqueCode,
                'requests_from_users'   => $request->requestsFromUsers ? $request->requestsFromUsers : Auth::user()->name,
                'description'           => $request->descriptionFromUsers,
                'transaction_date'      => Now(),
                'created_by_user_id'    => Auth::user()->id
            ]);

            foreach($request->itemName as $key => $item) {
                detailRequestHardwareSoftware::create([
                    'unique_request'        => $generateUniqueCode,
                    'items_id'              => inventory::where('item_name',Str::lower($item))->exists() ? str_replace(array('[',']'),"",inventory::where('item_name',Str::lower($item))->pluck('id')) : NULL,
                    'items_new_request'     => inventory::where('item_name',Str::lower($item))->exists() ? '' : Str::lower($item),
                    'qty'                   => $request->qty[$key],
                    'transaction_status'    => inventory::where('item_name',Str::lower($item))->exists() ? 'EXISTS' : 'NOT_EXISTS',
                    'description'           => $request->description[$key]
                ]);
            }

            DB::commit();

            Alert::success('Success','software and hardware requests are just waiting for Approval');
            return back();

        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            return $th;
        }
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

     /**
     * Data search for inventory
     */
    public function searchInventory(Request $request)
    {
        $data = inventory::where('item_name','LIKE','%'.request('q').'%')->paginate(5);

        return response()->json($data);
    }
}
