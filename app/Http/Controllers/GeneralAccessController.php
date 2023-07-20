<?php

namespace App\Http\Controllers;

use App\Models\generalAccess;
use App\Http\Controllers\Controller;
use App\Models\typeOfWork;
use App\Models\WorkType;
use Illuminate\Http\Request;
use DB;

class GeneralAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.general_access.index');
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
    public function show(generalAccess $generalAccess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(generalAccess $generalAccess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, generalAccess $generalAccess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(generalAccess $generalAccess)
    {
        //
    }

    /* --------------------------------------------------------------------------- Work Type Area ---------------------------------------------------------------------------*/

    public function index_type(Request $request) 
    {
        return view('pages.work_type.create');
    }

    public function store_type(Request $request)
    {
        $request->validate([
            'type' => 'required|unique:work_types'
        ]);

        DB::beginTransaction();

        try {
            WorkType::create([
                'type'  => $request->type,
            ]);

            DB::commit();

            return back()->with('success','Penginputan Master Jenis Pekerjaan Berhasil');
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            return back()->with('failed','Penginputan Master Jenis Pekerjaan Gagal');
        }
    }
}
