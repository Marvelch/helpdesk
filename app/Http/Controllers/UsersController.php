<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Auth;
use Illuminate\Support\Facades\Storage;
use DB;
use Alert;

class UsersController extends Controller
{
    public function index()
    {
        return view('index');
    }

    /**
     * Show the application profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        $users = User::all();
        foreach ($users as $user) {
            if (Cache::has('user-online' . Auth::user()->id))
                $status = 'Online';
            else
                $status = 'Office';
        }

        return view('pages.user.profile',compact('status'));
    }

    /**
     * Update user photo
     * 
     */
    public function updatePhoto(Request $request, $id) 
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        DB::beginTransaction();

        try {
            if(User::find($id)->photo) {
                Storage::disk('public')->delete(User::find($id)->photo);
            }

            if($request->file('photo')) {
                $photo = $request->file('photo')->store('profile');
            }

            User::find($id)->update([
                'photo'  => $photo
            ]);

            DB::commit();

            Alert::success('BERHASIL','Pembaharuan Photo Profile Berhasil');

            return back();
        } catch (\Throwable $th) {
            // DB::rollback();

            // Alert::error('GAGAL','Helpdesk Mengalamai Masalah Pembaharuan Profile');

            // return back();

            return $th;
        }
    }
}
