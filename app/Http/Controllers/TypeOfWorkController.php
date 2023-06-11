<?php

namespace App\Http\Controllers;

use App\Models\typeOfWork;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class TypeOfWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.type_of_work.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'typeofwork' => 'required|unique:type_of_works'
        ]);

        DB::beginTransaction();

        try {
            typeOfWork::create([
                'typeofwork'  => $request->typeofwork,
            ]);

            DB::commit();

            return back()->with('success','Penginputan Master Jenis Pekerjaan Berhasil');
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            return back()->with('failed','Penginputan Master Jenis Pekerjaan Gagal');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(typeOfWork $typeOfWork)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(typeOfWork $typeOfWork)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, typeOfWork $typeOfWork)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(typeOfWork $typeOfWork)
    {
        //
    }
}
