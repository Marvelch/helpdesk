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
use App\Models\User;

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
        $typeOfWorks = typeOfWork::all();

        return view('pages.request_ticket.create',compact('companys','divisions','typeOfWorks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            if($request->file('attachment')) {
                $attachment = $request->file('attachment')->store('bankaccount');
            }

            requestTicket::create([
                'request_on_user_id'    => Auth::user()->id,
                'title'                 => $request->title,
                'company_id'            => $request->company,
                'division_id'           => $request->division,
                'deadline'              => $request->deadline,
                'type_of_work_id'       => $request->typeOfWork,
                'location'              => $request->location,
                'description'           => $request->description,
                'status'                => 0,
                'attachment'            => @$attachment
            ]);

            DB::commit();

            Alert::success('Accepted','The repair request has been received');

            return redirect()->route('index_request_ticket');
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            Alert::success('Failed','There is a problem with the system');

            return redirect()->route('index_request_ticket');
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
        $typeOfWorks = typeOfWork::all();

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
                    $data = User::find($request->assignTo);
                    $pusher->trigger("private.$request->assignTo",'my-event',$data);
                }
            }else{
                DB::rollback();

                Alert::info('Info','Tidak ada tindakan apapun!');
                return redirect()->back();
            }

            DB::commit();

            Alert::success('Success','Status updates and assignments have been successful');

            return back();
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            Alert::error('Failed','There was a problem while saving');
            
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
