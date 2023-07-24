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
use App\Models\DetailInventory;
use Illuminate\Support\Str;

class RequestHardwareSoftwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->level_id == env('LEVEL_ADMIN') OR Auth::user()->level_id == env('LEVEL_EDITOR') OR Auth::user()->position_id == env('GENERAL_MENAGER')) {
            $requestHardwareSoftware = RequestHardwareSoftware::all();
        }elseif(Auth::user()->position_id == env('MANAGER')){
            $requestHardwareSoftware = RequestHardwareSoftware::where('division_id',Auth::user()->division_id)->get();
        }else{
            $requestHardwareSoftware = RequestHardwareSoftware::where('created_by_user_id',Auth::User()->id)->get();
        }

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
        $inventorys = inventory::all();
        $requestHardwareSoftwares = RequestHardwareSoftware::where('request_ticket_id',$requestTickets->id)->first();

        return view('pages.request_hardware_software.create_ticket',compact('requestTickets','inventorys','requestHardwareSoftwares'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $generateUniqueCode = generateUniqueCode();

            if(count(array_unique($request->itemName)) == count($request->itemName)){

                RequestHardwareSoftware::create([
                    'unique_request'        => $generateUniqueCode,
                    'requests_from_users'   => Auth::user()->id,
                    'description'           => $request->requestDescription,
                    'transaction_date'      => Now(),
                    'status'                => 0,
                    'division_id'           => Auth::user()->division_id,
                    'created_by_user_id'    => Auth::user()->id
                ]);

                foreach($request->itemName as $key => $item) {
                    detailRequestHardwareSoftware::create([
                        'unique_request'        => $generateUniqueCode,
                        'items_id'              => inventory::where('item_name',Str::lower($item))->exists() ? str_replace(array('[',']'),"",inventory::where('item_name',Str::lower($item))->pluck('id')) : NULL,
                        'items_new_request'     => inventory::where('item_name',Str::lower($item))->exists() ? '' : Str::lower($item),
                        'qty'                   => $request->qty[$key],
                        'availability'          => inventory::where('item_name',Str::lower($item))->exists() ? 'EXISTS' : 'NOT_EXISTS',
                        'description'           => $request->description[$key],
                        'transaction_status'    => 0
                    ]);
                }
            }else{
                DB::rollback();

                Alert::info('PERHATIAN','Perhatikan Penginputan Barang Tidak Boleh Sama');
                
                return back();
            }

            DB::commit();

            Alert::success('Success','New request has been successfully created');
            
            return redirect()->route('index_request_hardware_software');

        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            return $th;
        }
    }

     /**
     * Display the specified resource.
     */
    public function storeFromTicket(Request $request)
    {

        DB::beginTransaction();

        try {
            $uniqueTransaction = generateUniqueCode();

            RequestHardwareSoftware::create([
                'unique_request'        => $uniqueTransaction,
                'requests_from_users'   => Auth::user()->id,
                'status'                => 0,
                'description'           => 'Request From Ticket #'.$request->ticketId,
                'request_ticket_id'     => $request->ticketId,
                'division_id'           => Auth::user()->division_id,
                'transaction_date'      => Now(),
                'created_by_user_id'    => Auth::user()->id
            ]);
            
            foreach($request->itemName as $key => $item) {
                $inventory = inventory::select('stock','id')->where('item_name',Str::lower($item))->first();

                if($request->qty[$key] >= 0) {
                    if($inventory) {
                        detailRequestHardwareSoftware::create([
                            'unique_request'    => $uniqueTransaction,
                            'items_id'          => $inventory->id,
                            'qty'               => $request->qty[$key],
                            'availability'      => 'EXISTS',
                            'transaction_status'=> 0,
                            'description'       => 'Permintaan dari ',$request->ticketId,
                        ]);
                    }else{
                        detailRequestHardwareSoftware::create([
                            'unique_request'    => $uniqueTransaction,
                            'items_new_request' => $item,
                            'qty'               => $request->qty[$key],
                            'availability'      => 'NOT_EXISTS',
                            'transaction_status'=> 0,
                            'description'       => 'Permintaan dari ',$request->ticketId,
                        ]);
                    }
                }
            }

            DB::commit();

            Alert::success('Tersimpan','Permintaan software dan hardware berhasil !');

            return redirect()->route('index_request_hardware_software');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();

            Alert::error('Gagal','Permintaan software dan hardware gagal, ulang lagi !');

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $headers = RequestHardwareSoftware::where('unique_request',Crypt::decryptString($id))->first();
        $details = detailRequestHardwareSoftware::where('unique_request',Crypt::decryptString($id))->get();

        return view('pages.request_hardware_software.show',compact('headers','details'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $headers = RequestHardwareSoftware::where('unique_request',Crypt::decryptString($id))->first();

        $details = detailRequestHardwareSoftware::where('unique_request',Crypt::decryptString($id))->get();

        $inventorys = inventory::all();
        
        return view('pages.request_hardware_software.edit',compact('headers','details','inventorys'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        DB::beginTransaction();

        try {
            // Approvement Staff IT, Manager, General Manager 
            if(RequestHardwareSoftware::where('id',$request->id_transaction)->where('approval_supervisor',0)->exists()) {
                    RequestHardwareSoftware::where('id',$request->id_transaction)->update([
                        'approval_supervisor' => $request->approval_supervisor
                    ]);

                    if($request->approval_supervisor == 2) {
                        RequestHardwareSoftware::where('id',$request->id_transaction)->update([
                            'status' => 3
                        ]);
                    }

                    DB::commit();
                    Alert::success('BERHASIL','Pembaharuan Status Permintaan Telah Berhasil');
                    return redirect()->back();
                    
            }else if(RequestHardwareSoftware::where('id',$request->id_transaction)->where('approval_manager',0)->exists()) {
                    RequestHardwareSoftware::find($request->id_transaction)->update([
                        'approval_manager' => $request->approval_manager
                    ]);

                    if($request->approval_supervisor == 2) {
                        RequestHardwareSoftware::where('id',$request->id_transaction)->update([
                            'status' => 3
                        ]);
                    }

                    DB::commit();
                    Alert::success('BERHASIL','Pembaharuan Status Permintaan Telah Berhasil');
                    return redirect()->back();

            }else if(RequestHardwareSoftware::where('id',$request->id_transaction)->where('approval_general_manager',0)->exists()) {
                    RequestHardwareSoftware::find($request->id_transaction)->update([
                        'approval_general_manager' => $request->approval_general_manager
                    ]);

                    if($request->approval_supervisor == 2) {
                        RequestHardwareSoftware::where('id',$request->id_transaction)->update([
                            'status' => 3
                        ]);
                    }

                    DB::commit();
                    Alert::success('BERHASIL','Pembaharuan Status Permintaan Telah Berhasil');
                    return redirect()->back();
            }

            // Validasi pesetujuan dari supervisor, manager dan general menager 
            if(RequestHardwareSoftware::where('id',$request->id_transaction)->where('approval_supervisor',1)->where('approval_manager',1)->where('approval_general_manager',1)->exists()) {

                $i = is_array($request->itemId) ? count($request->itemId) : 0;
                
                if($i <= 0) {
                    DB::rollback();

                    Alert::info('Pembatalan','Penghapusan transaksi tidak diperbolehkan');

                    return back();
                }else{
                    foreach($request->itemId as $key => $id) {

                        $filtering = detailRequestHardwareSoftware::find($id);

                        if($request->transaction_status[$key] == env('COMPLETED') AND $filtering->transaction_status != env('COMPLETED')) {
                            
                            $items = inventory::select('stock','inventory_unique')->where('item_name',Str::lower($request->itemName[$key]))->first();

                            if($request->qty[$key] == 0){
                                DB::rollback();

                                Alert::info('Masalah','Pemintaan '.$request->itemName[$key].' melanggar aturan sistem !');

                                return redirect()->back();     
                            }

                            if($items) {
                                if($request->qty[$key] > $items->stock) {
                                    DB::rollback();

                                    Alert::info('Masalah','Pemintaan '.$request->itemName[$key].' permintaan stok tidak tersedia !');

                                    return redirect()->back();
                                }else{
                                    inventory::where('item_name',Str::lower($request->itemName[$key]))->update([
                                        'stock' => $items->stock - $request->qty[$key],
                                    ]);

                                    DetailInventory::create([
                                        'inventory_unique'      => $items->inventory_unique,
                                        'stock_out'             => $request->qty[$key],
                                        'description'           => 'Permintaan hardware dan software '.$request->unique_request,
                                        'created_by_user_id'    => Auth::user()->id
                                    ]);

                                    detailRequestHardwareSoftware::find($id)->update([
                                        'transaction_status'    => $request->transaction_status[$key]
                                    ]);
                                }
                            }else{
                                // Penambahan atau pembuatan inventori baru
                                $inventory_unique = generateUniqueCode();

                                inventory::create([
                                    'item_name'             => Str::lower($request->itemName[$key]),
                                    'stock'                 => 0,
                                    'inventory_unique'      => $inventory_unique
                                ]);

                                DetailInventory::create([
                                    'inventory_unique'      => $inventory_unique,
                                    'stock_in'             => $request->qty[$key],
                                    'description'           => 'Permintaan hardware dan software '.$request->unique_request,
                                    'created_by_user_id'    => Auth::user()->id
                                ]);

                                DetailInventory::create([
                                    'inventory_unique'      => $inventory_unique,
                                    'stock_out'             => $request->qty[$key],
                                    'description'           => 'Permintaan hardware dan software '.$request->unique_request,
                                    'created_by_user_id'    => Auth::user()->id
                                ]);

                                detailRequestHardwareSoftware::find($id)->update([
                                    'transaction_status'    => $request->transaction_status[$key]
                                ]);
                            }
                        }elseif($request->transaction_status[$key] == env('UNCOMPLETED')){
                            detailRequestHardwareSoftware::find($id)->update([
                                'transaction_status'    => $request->transaction_status[$key]
                            ]);
                        }elseif($request->transaction_status[$key] == env('INPROGRESS')) {
                            detailRequestHardwareSoftware::find($id)->update([
                                'transaction_status'    => $request->transaction_status[$key]
                            ]);
                        }elseif($request->transaction_status[$key] == env('UNCOMPLETED')) {
                            detailRequestHardwareSoftware::find($id)->update([
                                'transaction_status'    => $request->transaction_status[$key]
                            ]);
                        }
                    }

                    detailRequestHardwareSoftware::whereNotIn('id',$request->itemId)
                                                ->where('unique_request',$request->unique_request)
                                                ->delete();
                }
            }else{
                DB::rollback();

                Alert::info('INFO','Permintaan Harus Memiliki Persetujuan Managar & General Manager');

                return back();
            }

            DB::commit();

            Alert::success('BERHASIL','Pembaharuan Informasi Permintaan Telah Berhasil');

            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;

            // DB::rollback();
            
            return $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestHardwareSoftware $requestHardwareSoftware)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyDetail($id)
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
