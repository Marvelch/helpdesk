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
use App\Models\division;
use App\Models\User;
use Illuminate\Support\Str;

class RequestHardwareSoftwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->level_id == env('LEVEL_ADMIN') OR Auth::user()->division->division == env('DIVISION_IT') OR Auth::user()->level_id == env('LEVEL_EDITOR')) {
            $requestHardwareSoftware = RequestHardwareSoftware::all();
        }elseif(Auth::user()->position_id == env('GENERAL_MENAGER')){
            $requestHardwareSoftware = RequestHardwareSoftware::where('check_approval_general_manager',1)->get();
        }elseif(Auth::user()->position_id == env('MANAGER')){
            $getDivision = division::find(Auth::user()->division_id);

            if(Auth::user()->multi_company == 1){
                $requestHardwareSoftware = DB::table('divisions')
                                                ->select('request_hardware_software.description','divisions.division','x.name as requests_by_user','y.name as created_by_user','request_hardware_software.requests_from_users','request_hardware_software.status','request_hardware_software.created_by_user_id','request_hardware_software.division_id','request_hardware_software.unique_request','request_hardware_software.id','request_hardware_software.approval_supervisor','request_hardware_software.approval_manager','request_hardware_software.approval_general_manager')
                                                ->join('request_hardware_software','divisions.id','=','request_hardware_software.division_id')
                                                ->join('users as x','request_hardware_software.requests_from_users','=','x.id')
                                                ->join('users as y','request_hardware_software.created_by_user_id','=','y.id')
                                                ->where('divisions.division',$getDivision->division)
                                                ->get();
            }else{
                $requestHardwareSoftware = RequestHardwareSoftware::where('division_id',Auth::user()->division_id)->get();
            }
        }else{
            $requestHardwareSoftware = RequestHardwareSoftware::where('created_by_user_id',Auth::User()->id)
                                                                ->orWhere('requests_from_users',Auth::User()->id)
                                                                ->get();
        }

        // dd($requestHardwareSoftware);
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
                    'unique_request'                => $generateUniqueCode,
                    'requests_from_users'           => Auth::user()->id,
                    'description'                   => $request->requestDescription,
                    'transaction_date'              => Now(),
                    'status'                        => 0,
                    'division_id'                   => Auth::user()->division_id,
                    'created_by_user_id'            => Auth::user()->id
                ]);

                foreach($request->itemName as $key => $item) {
                    detailRequestHardwareSoftware::create([
                        'unique_request'        => $generateUniqueCode,
                        // 'items_id'              => inventory::where('item_name',Str::lower($item))->exists() ? str_replace(array('[',']'),"",inventory::where('item_name',Str::lower($item))->pluck('id')) : NULL,
                        // 'items_new_request'     => inventory::where('item_name',Str::lower($item))->exists() ? '' : Str::lower($item),
                        'items_id'              => $item,
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

            Alert::success('BERHASIL','Penambahan Transaksi Telah Berhasil');
            
            return redirect()->route('index_request_hardware_software');

        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            Alert::error('GAGAL','Penambahan Transaksi Baru Gagal, Ulangi Lagi');
            
            return back();
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

            $data = requestTicket::find($request->ticketId);

            RequestHardwareSoftware::create([
                'unique_request'        => $uniqueTransaction,
                'requests_from_users'   => $data->request_on_user_id,
                'status'                => 0,
                'description'           => 'Request From Tiket #'.$request->ticketId,
                'request_ticket_id'     => $request->ticketId,
                'division_id'           => $data->usersReq->division_id,
                'transaction_date'      => Now(),
                'created_by_user_id'    => Auth::user()->id
            ]);
            
            foreach($request->itemName as $key => $item) {

                 detailRequestHardwareSoftware::create([
                        'unique_request'    => $uniqueTransaction,
                        'items_id'          => $item,
                        'qty'               => $request->qty[$key],
                        'availability'      => 'EXISTS',
                        'transaction_status'=> 0,
                        'description'       => 'Permintaan dari tiket #'.$request->ticketId,
                    ]);

                // $inventory = inventory::select('stock','id')->where('item_name',Str::lower($item))->first();

                // if($request->qty[$key] >= 0) {
                //     if($inventory) {
                //         detailRequestHardwareSoftware::create([
                //             'unique_request'    => $uniqueTransaction,
                //             'items_id'          => $inventory->id,
                //             'qty'               => $request->qty[$key],
                //             'availability'      => 'EXISTS',
                //             'transaction_status'=> 0,
                //             'description'       => 'Permintaan dari ',$request->ticketId,
                //         ]);
                //     }
                //     else{
                //         detailRequestHardwareSoftware::create([
                //             'unique_request'    => $uniqueTransaction,
                //             'items_new_request' => $item,
                //             'qty'               => $request->qty[$key],
                //             'availability'      => 'NOT_EXISTS',
                //             'transaction_status'=> 0,
                //             'description'       => 'Permintaan dari ',$request->ticketId,
                //         ]);
                //     }
                // }
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
                        'approval_supervisor' => $request->approval_supervisor,
                        'check_approval_general_manager' => $request->check_approval_general_manager == "on" ? 1 : 0,
                        'status' => 1
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
                    
                    if(RequestHardwareSoftware::where('id',$request->id_transaction)->where('approval_manager',0)->where('check_approval_general_manager',1)->exists()){
                        RequestHardwareSoftware::find($request->id_transaction)->update([
                            'approval_manager' => $request->approval_manager
                        ]);
                    }else{
                         RequestHardwareSoftware::find($request->id_transaction)->update([
                            'approval_manager' => $request->approval_manager,
                            'approval_general_manager' => 1,
                        ]);
                    }
                        

                    if($request->approval_manager == 2) {
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

                    if($request->approval_general_manager == 2) {
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
                            
                            $items = inventory::select('stock','inventory_unique')->where('id',$request->inventoryId[$key])->first();

                            $checkRequestTicketOnHardware = RequestHardwareSoftware::where('id',$request->id_transaction)
                                                                                ->where('request_ticket_id',$request->ticket_id)
                                                                                ->first();
                            if($request->qty[$key] == 0){
                                DB::rollback();

                                Alert::info('Masalah','Pemintaan Tidak Sesuai Periksa Kembali');

                                return redirect()->back();     
                            }

                            if($items) {
                                if($request->qty[$key] > $items->stock) {
                                    DB::rollback();

                                    Alert::info('Masalah','Pemintaan Barang Pada Stok Inventori Tidak Tersedia');

                                    return redirect()->back();
                                }else{
                                    if(is_null($checkRequestTicketOnHardware)) {
                                        inventory::where('id',$request->inventoryId[$key])->update([
                                            'stock' => $items->stock - $request->qty[$key],
                                        ]);

                                        DetailInventory::create([
                                            'inventory_unique'      => $items->inventory_unique,
                                            'stock_out'             => $request->qty[$key],
                                            'description'           => 'Permintaan hardware dan software '.$request->unique_request,
                                            'created_by_user_id'    => Auth::user()->id
                                        ]);
                                    }

                                    detailRequestHardwareSoftware::find($id)->update([
                                        'transaction_status'    => $request->transaction_status[$key]
                                    ]);
                                }
                            }else{
                                DB::rollback();

                                Alert::info('INFO','Inventori Tidak Ditemukan, Periksa Kembali.');

                                return back();
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

            DB::rollback();

            Alert::error('GAGAL','Kesalahan Perhatikan Pengelolaan Data Transaksi');

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $data = RequestHardwareSoftware::find($id);

            if($data->status == 0) {
                RequestHardwareSoftware::find($id)->delete();

                detailRequestHardwareSoftware::where('unique_request',$data->unique_request)->delete();
            }else{
                DB::commit();

                Alert::info('OPPSS','Penghapusan Tidak Bisa Karena Telah Diproses');
                return back();
            }

            DB::commit();

            Alert::success('BERHASIL','Penghapusan Data Hardware Software Berhasil');
            return back();
        } catch (\Throwable $th) {
            DB::rollback();

            Alert::error('GAGAL','Penghapusan Transaksi Gagal, Ulangi Lagi');
            return back();
        }
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
