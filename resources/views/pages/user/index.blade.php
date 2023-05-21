@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <form action="{{url('/bank-accounts/store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Nama Pengguna</label>
                                        <input name="name" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" id="" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="email" name="password" id="" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Konfirmasi Password</label>
                                        <input type="email" name="confirm_password" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-4 offset-md-1">
                                    <div class="form-group">
                                        <label for="">Telepon</label>
                                        <input type="email" name="phone" id="" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Devisi / Perusahaan</label>
                                        <select name="devision" id="" class="form-control">
                                            <option value=""></option>
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
