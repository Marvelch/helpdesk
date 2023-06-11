<?php

namespace App\Http\Controllers;

use App\Models\bankAccounts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
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
        $items = bankAccounts::all();

        return view('pages.bank_account.index',compact('items'));
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
            'attachment'    => 'required|mimes:csv,txt,xls,xlx,xlsx,xls,pdf,jpg,png|max:5048,',
            'anydesk'       => 'required|min:3|max:40',
            'ip_address'    => 'required|min:3|max:40',
            'description'   => 'required|max:255',
            'email'         => 'required|email',
        ]);

        DB::beginTransaction();
        
        try {
            $path = $request->file('attachment')->store('bankaccount');
            
            if(!$path) {
                abort(403);
            } 

            bankAccounts::create([
                'email'             => $request->email,
                'fullname'          => $request->fullname,
                'username'          => $request->username,
                'password'          => $request->password,
                'url'               => $request->url,
                'attachment'        => $path,
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

            // Alert::error('Approve', 'Sorry, the system has crashed. Check the transaction again');

            // return redirect('/bank-accounts');

            return $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(bankAccounts $bankAccounts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(bankAccounts $bankAccounts, $id)
    {
        $item = bankAccounts::where('user_id',$id)->first();
        $item_users = User::all();

        return view('pages.bank_account.edit',compact('item','item_users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, bankAccounts $bankAccounts, $id)
    {
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
    public function destroy(bankAccounts $bankAccounts)
    {
        //
    }
}
