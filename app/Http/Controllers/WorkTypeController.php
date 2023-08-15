<?php

namespace App\Http\Controllers;

use App\Models\WorkType;
use App\Http\Controllers\Controller;
use App\Models\requestTicket;
use Illuminate\Http\Request;
use Alert;
use DB;

class WorkTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = WorkType::all();

        return view('pages.work_type.index',compact('items'));
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
    public function show(WorkType $workType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkType $workType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkType $workType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkType $workType,$id)
    {
        DB::beginTransaction();
        try {
            $tickets = requestTicket::where('type_of_work_id',$id)->first();

            if($tickets == NULL) {
                WorkType::find($id)->delete();
            }else{
                Alert::info('GAGAL','Tipe Pekerjaan Telah Digunakan !');

                return back();
            }

            DB::commit();

            Alert::success('BERHASIL','Penghapusan Data Tipe Pekerjaan Berhasil');

            return back();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();

            Alert::error('GAGAL','Helpdesk Mengalami Gangguan, Ulangai Lagi !');

            return back();
        }
    }
}
