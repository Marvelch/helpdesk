@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-5 mt-5">
                        <form action="{{route('store_users')}}" method="post" autocomplete="off">
                            @csrf
                            <div class="row justify-content-md-center">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Nama Pengguna</label>
                                        <input name="name" type="text" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" id="email" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="password" name="password" id="password" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Konfirmasi Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Telepon</label>
                                        <input type="text" name="phone" id="phone" class="form-control form-control-sm">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Perusahaan</label>
                                        <select name="company_id" id="company_id" class="form-control form-control-sm">
                                            @foreach($items as $item)
                                                <option value="{{$item->id}}">{{$item->company}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Devisi</label>
                                        <select name="division_id" id="company_id" class="form-control form-control-sm">
                                            @foreach($divisions as $item)
                                                <option value="{{$item->id}}">{{$item->division}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <div class="form-group">
                                            <button type="submit"
                                                class="btn bg-gradient-info w-100 mt-4 mb-0">simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
