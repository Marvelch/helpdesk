<?php

namespace App\Http\Controllers;

use App\Models\division;
use App\Http\Controllers\Controller;
use App\Models\company;
use App\Models\RequestHardwareSoftware;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;
use Alert;
use Illuminate\Support\Facades\Validator;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = division::all();
        
        return view('pages.division.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = company::all();

        return view('pages.division.create',compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            
        $validator = Validator::make($request->all(), [
            'company_id'    => 'required',
            'division'      => ['required','max:150',Rule::unique('divisions')
                                            ->where('company_id',$request->company_id)
                            ]
        ]);

        if($validator->stopOnFirstFailure()->fails()) {
            return back()->with('failed','Sorry Duplicate Company and Division !');
        }

        DB::beginTransaction();

        try {
            
            division::firstOrCreate([
                'company_id'    => $request->company_id,
                'division'      => $request->division
            ]);

            DB::commit();

            Alert::success('BERHASIL','Penambahan Data Pada Helpdesk Telah Berhasil');
            
            return redirect()->route('index_division');
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            return back()->with('error','Gangguan Penginputan Data Pada Helpdesk');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(division $division)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(division $division)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, division $division)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(division $division, $id)
    {
        DB::beginTransaction();

        try {
            $division = RequestHardwareSoftware::where('division_id',$id)->first();
            $user = User::where('division_id',$id)->first();

            if($division == NULL AND $user == NULL) {
                division::find($id)->delete();
            }else{
                DB::rollback();

                Alert::info('INFO','Tidak Bisa Dihapus. Divisi Telah Digunakan');
                return back();
            }

            DB::commit();

            Alert::success('BERHASIL','Penghapusan Data Telah Berhasil Diproses');
            return back();
        } catch (\Throwable $th) {
            DB::rollback();

            Alert::error('GAGAL','Helpdesk Mengalami Gangguan, Ulangi Lagi');
            return back();
        }
    }
}
