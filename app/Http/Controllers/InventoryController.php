<?php

namespace App\Http\Controllers;

use App\Models\inventory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Alert;
use Illuminate\Support\Str;

class InventoryController extends Controller
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
    public function create()
    {
        $inventorys = inventory::all();

        return view('pages.inventory.create',compact('inventorys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'itemsName'     => 'required|min:3|max:255',
            'itemCode'      => 'required',
            'stock'         => 'required|numeric|min:0|not_in:0'
        ]);

        DB::beginTransaction();

        try {

            inventory::updateOrCreate([
                'item_name'         => Str::lower($request->itemsName)
            ],
            [
                'item_code'             => $request->itemCode,
                'description'           => Str::lower($request->description),
                'stock'                 => DB::raw("IFNULL(stock,0) + $request->stock"),
                'created_by_user_id'    => Auth::user()->id
            ]);

            DB::commit();

            Alert::success('Aprrove','Inventory has increased');

            return redirect()->back();

        } catch (\Throwable $th) {
            //throw $th;

            return $th->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(inventory $inventory)
    {
        //
    }

    /**
     * Search for the name of the item on request
     */
    public function searchItemName(Request $request)
    {
        $data = inventory::where('item_name','LIKE','%'.request('q').'%')->paginate(5);

        return response()->json($data);
    }

}
