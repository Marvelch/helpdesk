<?php

namespace App\Http\Controllers;

use App\Models\inventory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Alert;
use App\Models\DetailInventory;
use Illuminate\Support\Str;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\helpers;
use App\Models\detailRequestHardwareSoftware;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventorys = inventory::orderBy('created_at', 'DESC')->paginate(10);

        return view('pages.inventory.index',compact('inventorys'));
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
     * Show the form for creating transaction a new resource.
     */
    public function createTransaction()
    {
        $inventorys = inventory::all();

        return view('pages.inventory.create_transaction',compact('inventorys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_name'     => 'required|min:3|unique:inventories|max:255',
            // 'stock'         => 'required|numeric|min:0|not_in:0'
        ]);

        DB::beginTransaction();

        try {
            $inventory_unique = generateUniqueCode();

            inventory::create([
                'item_name'             => Str::lower($request->item_name),
                'item_code'             => $request->itemCode,
                'description'           => Str::lower($request->description),
                // 'stock'                 => DB::raw("IFNULL(stock,0) + $request->stock"),
                'stock'                 => 0,
                'barcode'               => $request->barcode,
                'inventory_unique'      => $inventory_unique
            ]);

            DB::commit();

            Alert::success('Berhasil','Barang telah tersimpan pada inventory');

            return redirect()->route('index_inventory');

        } catch (\Throwable $th) {
            //throw $th;

            Alert::error('Gagal','Inventori tidak tersedia karena gangguan !');

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeTransaction(Request $request)
    {
        $request->validate([
            'item_name'     => 'required|min:3|max:255',
            'stock'         => 'required|numeric|min:0|not_in:0'
        ]);

        DB::beginTransaction();

        try {
            // inventory::create([
            //     'item_name'         => Str::lower($request->item_name)
            // ],
            // [
            //     'item_code'             => $request->itemCode,
            //     'description'           => Str::lower($request->description),
            //     // 'stock'                 => DB::raw("IFNULL(stock,0) + $request->stock"),
            //     'stock'                 => 0,
            //     'inventory_unique'      => generateUniqueCode(),
            //     'created_by_user_id'    => Auth::user()->id
            // ]);

            $items = inventory::select('inventory_unique')
                                ->where('item_name',Str::lower($request->item_name))
                                ->first();

            if(inventory::where('item_name',Str::lower($request->item_name))->exists() AND $items != NULL){
                inventory::where('item_name',Str::lower($request->item_name))->update([
                    'stock'                 => DB::raw("IFNULL(stock,0) + $request->stock"),
                ]);

                DetailInventory::create([
                    'inventory_unique'  => $items->inventory_unique,
                    'stock_in'          => $request->stock,
                    'created_by_user_id'=> Auth::user()->id,
                    'description'       => $request->description
                ]);

            }else{
                DB::rollback();

                Alert::info('Gagal','Barang yang kamu pilih tidak terdaftar pada inventori !');

                return redirect()->back();
            }

            DB::commit();

            Alert::success('Berhasil','Penambahan stok pada inbentori telah berhasil');

            return redirect()->back();

        } catch (\Throwable $th) {
            //throw $th;

            return $th->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeBercode(Request $request)
    {
        DB::beginTransaction();

        try {
            $items = inventory::select('inventory_unique')
                                ->where('barcode',$request->barcode)
                                ->first();

            if(inventory::where('barcode',$request->barcode)->exists() AND $request->qty >= 1){
                inventory::where('barcode',$request->barcode)->update([
                    'stock'                 => DB::raw("IFNULL(stock,0) + $request->qty"),
                ]);

                DetailInventory::create([
                    'inventory_unique'  => $items->inventory_unique,
                    'stock_in'          => $request->qty,
                    'created_by_user_id'=> Auth::user()->id,
                    'description'       => 'Scanner Barcode'
                ]);

            }else{
                DB::rollback();

                Alert::info('Gagal','Barang yang kamu pilih tidak terdaftar pada inventori !');

                return redirect()->back();
            }

            DB::commit();

            Alert::success('Berhasil','Penambahan stok barang telah berhasil');

            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            return $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(inventory $inventory,$id)
    {
        $inventorys = inventory::where('inventory_unique',Crypt::decryptString($id))->first();

        $details = DetailInventory::where('inventory_unique',Crypt::decryptString($id))->get();

        return view('pages.inventory.show',compact('inventorys','details'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(inventory $inventory)
    {
        
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
    public function destroy(inventory $inventory, $id)
    {
        DB::beginTransaction();

        try {

            return inventory::where('id',$id)->first();
            
            inventory::find($id)->delete();

            DB::commit();

            Alert::success('Berhasil','Penghapusan barang pada inventori berhasil');

            return back();
        } catch (\Throwable $th) {

            DB::rollback();

            Alert::error('Gagal','Oppss.. penghapusan barang pada inventori gagal');

            return back();
        }
    }

    /**
     * Search for the name of the item on request
     */
    public function searchItemName(Request $request)
    {
        $data = inventory::where('item_name','LIKE','%'.request('q').'%')->paginate(5);

        return response()->json($data);
    }

    /**
     * Scan barcode
     */
    public function scanBercode(Request $request)
    {
        $data = inventory::where('barcode',$request->barcode)->first();
        
        return response()->json($data);
    }

}
