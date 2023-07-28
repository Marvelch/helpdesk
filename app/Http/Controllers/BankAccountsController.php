<?php

namespace App\Http\Controllers;

use App\Models\bankAccounts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Str;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use DB;
use Auth;
Use Alert;
use App\Models\inventory;
use Illuminate\Validation\Rules\Exists;

class BankAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bankAccounts = bankAccounts::all();

        return view('pages.bank_account.index',compact('bankAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = user::all();

        return view('pages.bank_account.create',compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'fullname'      => 'required|min:2|max:80',
            'username'      => 'required|min:3|max:40',
            'password'      => 'required',
            'url'           => 'required|min:3|max:50',
            'attachment'    => 'mimes:csv,txt,xls,xlx,xlsx,pdf,jpg,png'
        ]);

        DB::beginTransaction();
        
        try {
            
            if($request->file('attachment')) {
                $attachment = $request->file('attachment')->store('bankaccount');
            }

            bankAccounts::create([
                'email'             => Str::lower($request->email),
                'fullname'          => Str::lower($request->fullname),
                'username'          => $request->username,
                'password'          => $request->password,
                'url'               => Str::lower($request->url),
                'attachment'        => @$attachment,    
                'description'       => Str::lower($request->description),
                'created_by_user_id'=> Auth::user()->id,
            ]);
            
            DB::commit();

            Alert::success('Berhasil', 'Penambahan akun baru pengguna telah berhasil !');

            return redirect()->route('index_bank_accounts');

        } catch (\Throwable $th) {
            DB::rollback();

            Alert::error('Gagal', 'Pembuatan akun gagal tolong cek kembali !');

            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(bankAccounts $bankAccounts,$id)
    {
        $bankAccounts = bankAccounts::where('id',Crypt::decryptString($id))->first();
        $item_users = User::all();

        return view('pages.bank_account.show',compact('bankAccounts','item_users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(bankAccounts $bankAccounts, $id)
    {
        $bankAccounts = bankAccounts::where('id',Crypt::decryptString($id))->first();
        $item_users = User::all();

        return view('pages.bank_account.edit',compact('bankAccounts','item_users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, bankAccounts $bankAccounts, $id)
    {   
        $request->validate([
            'fullName'      => 'required|min:2|max:80',
            'userName'      => 'required|min:3|max:40',
            'password'      => 'required|min:3|max:40',
            'url'           => 'required|min:3|max:50',
            'attachment'    => 'mimes:csv,txt,xls,xlx,xlsx,xls,pdf,jpg,png|max:5048'
        ]);

        DB::beginTransaction();

        try {

            if($request->file('attachment')) {
                $attachment = $request->file('attachment')->store('bankaccount');
            }

            bankAccounts::find($id)->update([
                'fullname'      => $request->fullName,
                'email'         => $request->email,
                'username'      => $request->userName,
                'password'      => $request->password,
                'url'           => $request->url,
                'attachment'    => @$attachment,
                'description'   => $request->description,
                'email'         => $request->email
            ]);

            DB::commit();

            Alert::success('Berhasil','Pembaharuan informasi akun telah berhasil !');

            return redirect()->route('index_bank_accounts');

        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            // Alert::error('Gagal','Pembaharuan informasi akun gagal, ulangi kembali !');

            // return $request->back();

            return $th->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(bankAccounts $bankAccounts, $id)
    {
        DB::beginTransaction();

        try {
            bankAccounts::find($id)->delete();

            DB::commit();

            Alert::success('BERHASIL','Penghapusan Data Bank Account Berhasil');
            return back();
        } catch (\Throwable $th) {

            DB::rollback();

            Alert::error('GAGAL','Penghapusan Data Bank Account Gagal');
            return back();
        }
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