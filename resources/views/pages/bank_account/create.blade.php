@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <form action="{{route('store_bank_accounts')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-4 d-flex align-items-center">
                                <img src="{{asset('./assets/img/1.gif')}}" class="w-100" alt="" srcset="">
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="">Nama Pengguna</label>
                                    <input name="fullname" type="text" class="form-control form-control-sm" value="{{old('fullname')}}">
                                    @error('fullname')
                                    <p class="error__required">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Username</label>
                                            <input name="username" type="text" class="form-control form-control-sm" value="{{old('username')}}">
                                            @error('username')
                                            <p class="error__required">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Kata sandi</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text" id="inputGroup-sizing-sm"><i
                                                        class="fa-regular fa-lock"></i></span>
                                                <input name="password" value="{{old('password')}}" type="text" class="form-control">
                                            </div>
                                            @error('password')
                                            <p class="error__required">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">URL</label>
                                    <input type="text" name="url" class="form-control form-control-sm" value="{{old('url')}}">
                                    @error('url')
                                    <p class="error__required">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input name="email" type="text" class="form-control form-control-sm" value="{{old('email')}}">
                                </div>
                                <div class="form-group">
                                    <label for="">Dokumen PDF / JPG</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"></span>
                                        <input name="attachment" type="file" class="form-control"
                                            aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                    @error('attachment')
                                    <p class="error__required">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Anydesk</label>
                                            <input name="anydesk" type="text" class="form-control form-control-sm" value="{{old('anydesk')}}">
                                            @error('anydesk')
                                            <p class="error__required">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">IP Address</label>
                                            <input name="ip_address" type="text" class="form-control form-control-sm" value="{{old('ip_address')}}">
                                            @error('ip_address')
                                            <p class="error__required">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                    <textarea name="description" id="" cols="10" rows="5"
                                        class="form-control form-control-sm">{{old('description')}}</textarea>
                                    @error('description')
                                    <p class="error__required">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="text-center d-flex justify-content-end">
                                    <button type="submit" class="btn bg-gradient-info w-30 mt-4 mb-0">simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
