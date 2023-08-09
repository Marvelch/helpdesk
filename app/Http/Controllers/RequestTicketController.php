<?php

namespace App\Http\Controllers;

use App\Models\requestTicket;
use App\Http\Controllers\Controller;
use App\Models\company;
use App\Models\division;
use App\Models\typeOfWork;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Pusher\Pusher;
use Illuminate\Support\Facades\Storage;
use DB;
use Auth;
use Alert;
use App\Models\DetailInventory;
use App\Models\detailRequestHardwareSoftware;
use App\Models\inventory;
use App\Models\Notification;
use App\Models\RequestHardwareSoftware;
use App\Models\User;
use App\Models\WorkType;

class RequestTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requestTickets = requestTicket::orderBy('created_at', 'DESC')->paginate(10);

        return view('pages.request_ticket.index',compact('requestTickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companys = company::all();
        $divisions = division::all();
        $typeOfWorks = WorkType::all();

        return view('pages.request_ticket.create',compact('companys','divisions','typeOfWorks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|min:3',
            'company'       => 'required',
            'division'      => 'required',
            'location'      => 'required',
            'work_type'     => 'required'
        ]);

        DB::beginTransaction();

        try {

            if(division::where('id',$request->division)->where('company_id',$request->company)->doesntExist()) {
                DB::rollback();

                Alert::info('INFO','Helpdesk Mengalami Masalah, Ulangi Penginputan');

                return back();
            }

            if($request->file('attachment')) {
                $attachment = $request->file('attachment')->store('ticket');
            }

            requestTicket::create([
                'request_on_user_id'    => Auth::user()->id,
                'title'                 => $request->title,
                'company_id'            => $request->company,
                'division_id'           => $request->division,
                'deadline'              => $request->deadline,
                'type_of_work_id'       => $request->work_type,
                'location'              => $request->location,
                'description'           => $request->description,
                'status'                => 0,
                'attachment'            => @$attachment
            ]);

            DB::commit();

            Alert::success('BERHASIL','Pembuatan Tiket Laporan Telah Berhasil');

            return redirect()->route('index_request_ticket');
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            Alert::error('GAGAL','Pembuatan Laporan Tiket Bermasalah, Ulangi Lagi');

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(requestTicket $requestTicket,$id)
    {
        $requestTickets = requestTicket::find(Crypt::decryptString($id));

        $companys = company::all();
        $divisions = division::all();
        $typeOfWorks = WorkType::all();

        $itemsRequests = DB::table('request_hardware_software')
                                ->join('detail_request_hardware_software','request_hardware_software.unique_request','=','detail_request_hardware_software.unique_request')
                                ->join('inventories','detail_request_hardware_software.items_id','=','inventories.id')
                                ->where('detail_request_hardware_software.transaction_status',2)
                                ->whereOr('detail_request_hardware_software.transaction_status',3)
                                ->where('request_hardware_software.request_ticket_id',Crypt::decryptString($id))
                                ->get();

        $hardwareSoftware = RequestHardwareSoftware::where('request_ticket_id',Crypt::decryptString($id))->first();

        return view('pages.request_ticket.show',compact('companys','divisions','typeOfWorks','requestTickets','itemsRequests','hardwareSoftware'));
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
    public function update(Request $request, $id)
    {

        DB::beginTransaction();

        try {
            if($request->approvement == 1) {
                if($request->assignTo == NULL) {
                    DB::rollback();

                    Alert::info('Info','Status diterima form assign to harus terisi !');
                    return redirect()->back();
                }else{
                    requestTicket::find($id)->update([
                        'assignment_on_user_id'     => $request->assignTo,
                        'status'                    => 1,
                    ]);

                    $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), array('cluster' => env('PUSHER_APP_CLUSTER')));
             
                    $data = requestTicket::find(Crypt::decryptString($request->notification));

                    $count = Notification::where('users_id',$request->assignTo)
                                ->where('read',null)
                                ->count();

                    $resultCount = $count + 1;

                    $pusher->trigger("private.$request->assignTo",'my-event',['message' => 'Request Ticket #'.$data->id,'url' => '/request-tickets/show/'.$request->notification,'countNotif' => $resultCount]);

                    Notification::create([
                        'users_id'      => $request->assignTo,
                        'path'          => '/request-tickets/show/'.$request->notification,
                        'read'          => NULL,
                        'ticket_id'     => $id
                    ]);
                }
            }else{
                DB::rollback();

                Alert::info('Info','Perhatikan Penginputan Pada Form Helpdesk');
                return redirect()->back();
            }

            DB::commit();

            Alert::success('Berhasil','Pembaharuan Laporan Pada Tiket Telah Berhasil');

            return back();
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            Alert::error('Gagal','Gagal Memperbaharui Informasi Pada Tiket, Ulangi Lagi');
            
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $data = DB::table('request_tickets')
                                ->select('request_hardware_software.status')
                                ->join('request_hardware_software','request_tickets.id','=','request_hardware_software.request_ticket_id' )
                                ->where('request_tickets.id',$id)
                                ->get();

            if(@$data[0]->status == env('INPROGRESS') OR @$data[0]->status == env('DEFAULT')) {
                DB::rollback();

                Alert::info('INFO.','Permintaan Hardware & Software Belum Selesai');

                return back();
            }else{
                if($request->status == env('COMPLETED')) {
                    requestTicket::find($id)->update([
                        'status'    => $request->status
                    ]);

                    if(!$data->isEmpty()) {
                        foreach($request->item_use as $key => $item) {

                            $getData = inventory::where('inventory_unique',$request->inventory_unique[$key])->first();

                            inventory::where('inventory_unique',$request->inventory_unique[$key])->update([
                                'stock' => $getData->stock - $request->qty[$key]
                            ]);

                            if($item == 'on') {
                                DetailInventory::create([
                                    'inventory_unique'      => $request->inventory_unique[$key],
                                    'stock_out'             => $request->qty[$key],
                                    'description'           => 'Penerimaan Dari Tiket #'.$id,
                                    'created_by_user_id'    => Auth::user()->id
                                ]);
                            }    
                        }
                    }
                }else{
                    requestTicket::find($id)->update([
                        'status'    => $request->status
                    ]);
                }
            }

            DB::commit();

            Alert::success('BERHASIL','Pembaharuan Informasi Laporan Tiket Telah Barhasil');

            return back();
        } catch (\Throwable $th) {
            // DB::rollback();

            // Alert::error('GAGAL','Pembaharuan Informasi Laporan Tiket Gagal, Ulangi Lagi');

            // return back();
            return $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(requestTicket $requestTicket)
    {
        //
    }

    /**
     * Division search query to display on select button
     */
    public function searchDivision(Request $request,$id)
    {
        $data = division::where('division','LIKE','%'.request('q').'%')
                        ->where('company_id',$id)->paginate(5);

        return response()->json($data);
    }

    /**
     * Division search query to display on select button
     */
    public function searchCompany(Request $request)
    {
        $data = company::where('company','LIKE','%'.request('q').'%')->paginate(5);

        return response()->json($data);
    }

    /**
     * Division search query to display on select button
     */
    public function approve(Request $request)
    {
        $requestTickets = requestTicket::where('approvement',1)->orderBy('created_at', 'DESC')->paginate(5);

        return view('pages.request_ticket.approve',compact('requestTickets'));
    }
    
    /**
     * look up the user in the users table
     */
    public function searchUsers(Request $request)
    {
        $data = User::where('name','LIKE','%'.request('q').'%')->paginate(5);

        return response()->json($data);
    }

    /**
     * look up the user in the users table
     */
    public function search_users_assign(Request $request)
    {
        $data = DB::table('divisions')
                    ->join('users','divisions.id','=','users.division_id')
                    ->where('divisions.division',env('DIVISION_IT'))
                    ->where('users.name','LIKE','%'.request('q').'%')->paginate(5);

        return response()->json($data);
    }

    /**
     * Download files from storage
     */
    public function download($id) 
    {
        DB::beginTransaction();

        try {
            DB::commit();
            return Storage::download(Crypt::decryptString($id));
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();
            return $th->getMessage();
            // Alert::error('Failed','Problem files contact the company website manager');
        }
    }

}
