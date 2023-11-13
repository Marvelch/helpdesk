<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Alert;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::all();

        return view('pages.news.index',compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->file('img')) {
            $img = $request->file('img')->store('news');
        }

        DB::beginTransaction();

        try {
            News::create([
                'title'     => $request->title,
                'article'   => $request->article,
                'img'       => @$img,
                'status'    => 1,
                'created_user_id' => Auth::user()->id,
            ]);

            DB::commit();

            Alert::success('BERHASIL','Penginputan Berita Berhasil, Periksa Detail Berita.');

            return back();
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollback();

            Alert::error('GAGAL',$th->getMessage());

            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        //
    }
}
