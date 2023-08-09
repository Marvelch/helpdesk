<?php

namespace App\Http\Controllers;

use App\Models\bankAccounts;
use App\Models\company;
use App\Models\devision;
use App\Models\division;
use App\Models\requestTicket;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use DB;
use Auth;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Events\MyEvent;
use App\Models\Position;
use Alert;

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
        $items = user::orderBy('created_at', 'DESC')->get();

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
        $position = Position::all();

        return view('pages.user.create',compact('items','divisions','position'));
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
        $position = Position::all();
        
        return view('pages.user.edit',compact('items','companys','divisions','position'));
    }

     /**
     * Save the form submit for new user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|unique:users|min:2|max:255',
            'username'          => 'required|unique:users|min:2|max:255',
            'email'             => 'required|unique:users',
            'password'          => 'required',
            'confirm_password'  => 'required',
            'phone'             => 'required|unique:users',
            'company_id'        => 'required',
            'division_id'       => 'required',
            'position_id'       => 'required'
        ]);

        DB::beginTransaction();

        try {
            User::create([
                'name'          => Str::lower($request->name),
                'email'         => Str::lower($request->email),
                'username'      => str_replace(' ','',Str::lower($request->username)),
                'level_id'      => 3,
                'phone'         => $request->phone,
                'password'      => Hash::make($request->password),
                'company_id'    => $request->company_id,
                'password_text' => $request->password,
                'multi_company' => $request->multi_company == 'on' ? 1 : 0, 
                'division_id'   => $request->division_id,
                'position_id'   => $request->position_id
            ]);

            DB::commit();

            Alert::success('Berhasil','Penambahan pengguna berhasil tersimpan !');

            return redirect()->route('index_users');
        } catch (\Throwable $th) {
            //throw $th;

            // DB::rollback();

            // Alert::error('Gagal','Kesalahan penginputan silahkan coba lagi !');

            // return back();
            return $th;
        }
    }

     /**
     * Make changes to data in the database
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'              => 'required|min:2|max:255',
            'username'          => 'required|min:2|max:255',
            'password'          => 'required',
            'confirm_password'  => 'required',
            'phone'             => 'required',
            'company_id'        => 'required',
            'division_id'       => 'required',
            'position_id'       => 'required'
        ]);

        DB::beginTransaction();

        try {
            if($request->password) {
                if($request->password == $request->confirm_password) {
                    User::find($id)->update([
                        'name'          =>  $request->name,
                        'email'         =>  $request->email,
                        'password'      =>  Hash::make($request->password),
                        'password_text' =>  $request->password,
                        'phone'         =>  $request->phone, 
                        'company_id'    =>  $request->company_id,
                        'division_id'   =>  $request->division_id,
                        'multi_company' =>  $request->multi_company == 'on' ? 1 : 0, 
                        'position_id'   =>  $request->position_id
                    ]);

                    DB::commit();
                    return redirect('users')->with('BERHASIL','Pembaharuan Informasi Pengguna Berhasil !');
                }else{
                    DB::rollback();
                    return back()->with('GAGAL','Password Tidak Sesuai, Tolong Periksa Lagi');
                }
            }else{
                 User::find($id)->update([
                    'name'          =>  $request->name,
                    'email'         =>  $request->email,
                    'password'      =>  Hash::make($request->password),
                    'password_text' =>  $request->password,
                    'phone'         =>  $request->phone, 
                    'company_id'    =>  $request->company_id,
                    'division_id'   =>  $request->division_id,
                    'position_id'   =>  $request->position_id
                ]);

                DB::commit();
                return redirect('users')->with('BERHASIL','Pembaharuan Informasi Pengguna Berhasil !');
            }
            
            DB::commit();

            Alert::success('BERHASIL','Pembaharuan Data Pengguna Telah Berhasil');

            return redirect()->route('index_users');
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            return back()->with('GAGAL','Pembaharuan Data Tidak Berhasil!');
        }
    }
}
