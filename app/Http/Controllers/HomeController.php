<?php

namespace App\Http\Controllers;

use App\Models\bankAccounts;
use App\Models\company;
use App\Models\devision;
use App\Models\division;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use DB;
use Auth;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $items = user::orderBy('created_at', 'DESC')->paginate(5);

        return view('pages.user.index',compact('items'));
    }

    /**
     * create new enteri for submit new user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $items = company::all();
        $divisions = division::all();

        return view('pages.user.create',compact('items','divisions'));
    }

    /**
     * Make changes to user data.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Request $request, $id)
    {
        $items = User::find(Crypt::decryptString($id));
        $companys = company::all();
        $divisions = division::all();
        
        return view('pages.user.edit',compact('items','companys','divisions'));
    }

    /**
     * Show the application profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        return view('pages.user.profile');
    }

     /**
     * Save the form submit for new user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'level_id'  => 3,
                'phone'     => $request->phone,
                'password'  => Hash::make($request->password),
                'company_id'=> $request->company_id,
            ]);

            DB::commit();

            return back();
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            return $th->getMessage();
        }
    }

     /**
     * Make changes to data in the database
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            if($request->password) {
                if($request->password == $request->confirm_password) {
                    User::find($id)->update([
                        'name'      =>  $request->name,
                        'email'     =>  $request->email,
                        'password'  =>  Hash::make($request->password),
                        'phone'     =>  $request->phone, 
                        'company_id'=>  $request->company_id
                    ]);

                    DB::commit();
                    return redirect('users')->with('success','Pembaharuan Informasi Pengguna Berhasil !');
                }else{
                    DB::rollback();
                    return back()->with('failed','Make sure the password is correct');
                }
            }else{
                 User::find($id)->update([
                    'name'      =>  $request->name,
                    'email'     =>  $request->email,
                    'phone'     =>  $request->phone, 
                    'company_id'=>  $request->company_id
                ]);

                DB::commit();
                return redirect('users')->with('success','Pembaharuan Informasi Pengguna Berhasil !');
            }
            
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            return back()->with('failed','Pembaharuan Data Tidak Berhasil!');
        }
    }

}
