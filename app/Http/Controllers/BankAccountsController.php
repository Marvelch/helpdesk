<?php

namespace App\Http\Controllers;

use App\Models\bankAccounts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use DB;
use Auth;
Use Alert;

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
            'password'      => 'required|min:3|max:40',
            'url'           => 'required|min:3|max:50',
            'attachment'    => 'mimes:csv,txt,xls,xlx,xlsx,xls,pdf,jpg,png|max:5048,',
            'description'   => 'required|max:255',
            'email'         => 'required|email',
        ]);

        DB::beginTransaction();
        
        try {
            if($request->file('attachment')) {
                $attachment = $request->file('attachment')->store('bankaccount');
            }

            bankAccounts::create([
                'email'             => $request->email,
                'fullname'          => $request->fullname,
                'username'          => $request->username,
                'password'          => $request->password,
                'url'               => $request->url,
                'attachment'        => @$attachment,
                'anydesk'           => $request->anydesk,
                'ip_address'        => $request->ip_address,
                'description'       => $request->description,
                'created_by_user_id'=> Auth::user()->id,
            ]);
            
            DB::commit();

            Alert::success('Approve', 'Account creation has been successful');

            return redirect('/bank-accounts');

        } catch (\Throwable $th) {
            DB::rollback();

            Alert::error('Approve', 'Sorry, the system has crashed. Check the transaction again');

            return redirect('/bank-accounts');
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
        DB::beginTransaction();

        try {
            bankAccounts::where('user_id',$id)->update([
                'ip_address' => $request->ipaddress,
                'anydesk' => $request->anydesk
            ]);

            DB::commit();

            return redirect()->back();

        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

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
            bankAccounts::find(Crypt::decryptString($id))->delete();

            DB::commit();

            Alert::success('Deleted','The deletion has been performed successfully');
            return back();
        } catch (\Throwable $th) {
            //throw $th;

             DB::commit();

            Alert::error('Failed','Deletion encountered a problem, try again');
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
