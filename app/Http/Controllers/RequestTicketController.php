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
use App\Models\Notification;
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

            Alert::success('Berhasil','Pembuatan tiket laporan telah berhasil');

            return redirect()->route('index_request_ticket');
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            Alert::success('Gagal','Oppsss... Gagal membuat tiket laporan');

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

        return view('pages.request_ticket.show',compact('companys','divisions','typeOfWorks','requestTickets'));
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

                    $pusher->trigger("private.$request->assignTo",'my-event',['message' => 'Laporan Tiket #'.$data->id,'url' => '/request-tickets/show/'.$request->notification,'countNotif' => $resultCount]);

                    Notification::create([
                        'users_id'      => $request->assignTo,
                        'path'          => '/request-tickets/show/'.$request->notification,
                        'read'          => NULL
                    ]);
                }
            }else{
                DB::rollback();

                Alert::info('Info','Perhatikan penginputan pada sistem Helpdesk !');
                return redirect()->back();
            }

            DB::commit();

            Alert::success('Berhasil','Pembaharuan informasi pekerjaan telah berhasil !');

            return back();
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            Alert::error('Gagal','Gagal memperbaharui infomasi, silahkan cek kembali !');
            
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

                Alert::info('OPPSS...','Permintaan Hardware & Software Belum Selesai');

                return back();
            }else{
                requestTicket::find($id)->update([
                    'status'    => $request->status
                ]);
            }

            DB::commit();

            Alert::success('BERHASIL','Informasi tiket telah diperbaharui. Terima kasih.');

            return back();
        } catch (\Throwable $th) {
            DB::rollback();

            Alert::error('GAGAL','Kegagalan helpdesk pembaharuan informasi tiket');

            return back();
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
