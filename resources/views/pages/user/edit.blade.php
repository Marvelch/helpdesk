@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <form action="{{route('store_users')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Nama Pengguna</label>
                                        <input name="name" type="text" class="form-control" autocomplete="off" value="{{$items->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" autocomplete="off" value="{{$items->email}}">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Konfirmasi Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-4 offset-md-1">
                                    <div class="form-group">
                                        <label for="">Telepon</label>
                                        <input type="text" name="phone" id="phone" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Devisi / Perusahaan</label>
                                        <select name="company_id" id="company_id" class="form-control">
                                            
                                        </select>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <div class="form-group">
                                            <button type="submit"
                                                class="btn bg-gradient-info w-100 mt-4 mb-0">perbaharui</button>
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
