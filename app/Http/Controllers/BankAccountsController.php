<?php

namespace App\Http\Controllers;

use App\Models\bankAccounts;
use App\Models\User;
use Illuminate\Http\Request;
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
        try {
            bankAccounts::firstOrCreate([
                'user_id'   => $request->user_id,
            ],
            [
                'ip_address' => $request->ipaddress,
                'anydesk'   => $request->anydesk
            ]
            );
            
            DB::commit();
            Alert::success('Success Title', 'Success Message');
            return redirect('/bank-accounts');
        } catch (\Throwable $th) {
            DB::rollback();

            // return redirect()->back();
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
