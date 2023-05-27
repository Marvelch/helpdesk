@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <form action="{{route('update_users',['id' => $items->id])}}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Nama Pengguna</label>
                                        <input name="name" type="text" class="form-control" autocomplete="off"
                                            value="{{$items->name}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            autocomplete="off" value="{{$items->email}}" required>
                                    </div>
                                    <div class="form-group pt-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" id="checkbox" type="checkbox"
                                                id="flexSwitchCheckDefault">
                                            <label class="form-check-label" for="flexSwitchCheckDefault">Change
                                                Password</label>
                                        </div>
                                    </div>
                                    <div class="form-group password">
                                        <label for="">Kata Sandi</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            autocomplete="off">
                                    </div>
                                    <div class="form-group confirm_password">
                                        <label for="">Konfirmasi Kata Sandi</label>
                                        <input type="password" name="confirm_password" id="confirm_password"
                                            class="form-control" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-4 offset-md-1">
                                    <div class="form-group">
                                        <label for="">Telepon</label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                            autocomplete="off" value="{{$items->phone}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Devisi / Perusahaan</label>
                                        <select name="company_id" id="company_id" class="form-control">
                                            @foreach($companys as $company)
                                            <option value="{{$company->id}}">{{$company->company}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="alert alert-info error_password" role="alert"
                                        style="font-size: 12px; color: white;">
                                        <i class="fa-solid fa-bell" style="padding-right: 15px;"></i> Make sure the
                                        password is correct.
                                    </div>
                                    @if ($alert = Session::get('failed'))
                                    <div class="alert alert-info" role="alert"
                                        style="font-size: 12px; color: white;">
                                        <i class="fa-solid fa-bell" style="padding-right: 15px;"></i>{{$alert}}
                                    </div>
                                    @endif
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
<script>
    $('.password').hide();
    $('.confirm_password').hide();
    $('.error_password').hide();

    $(document).ready(function () {
        $('.password, .confirm_password').on('change paste', function () {
            const password = $("input[id=password]").val();
            const confirm_password = $("input[id=confirm_password]").val();

            if (password != confirm_password) {
                if (!$("input[id=confirm_password]").val()) {
                    $('.error_password').hide();
                } else if (!$("input[id=password]").val()) {
                    $('.error_password').hide();
                } else {
                    $('.error_password').show();
                }
            } else {
                $('.error_password').hide();
            }
        });
    });

    $('#checkbox').on('click', function () {
        if ($('#checkbox').prop('checked')) {
            $('.password').show();
            $('.confirm_password').show();
        } else {
            $('.password').hide();
            $('.confirm_password').hide();
            $('.error_password').hide();
        }
    });

</script>
@endsection
