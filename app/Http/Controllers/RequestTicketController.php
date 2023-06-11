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
use DB;
use Auth;

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
            requestTicket::create([
                'request_on_user_id'    => Auth::user()->id,
                'title'                 => $request->title,
                'company_id'            => $request->company,
                'division_id'           => $request->division,
                'deadline'              => $request->deadline,
                'type_of_work_id'       => $request->typeOfWork,
                'location'              => $request->location,
                'description'           => $request->description
            ]);

            DB::commit();

            return back()->with('success','The repair request has been received by the system');
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            return back()->with('failed','There is a problem with the system, please inform the relevant department');
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
            requestTicket::find($id)->update([
                'approvement' => $request->approvement,
                'approvement_by_user_id' => Auth::user()->id
            ]);

            DB::commit();

            return back()->with('success','Successfully provided check mark');
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            return $th->getMessage();
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
    public function search_division(Request $request,$id)
    {
        $data = division::where('company_id',$id)
                        ->where('division',request('q'))->paginate(5);

        return response()->json($data);
    }

    /**
     * Division search query to display on select button
     */
    public function search_company(Request $request)
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
}
