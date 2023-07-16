@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card" style="z-index: 1; font-family: var(--bs-font-roboto); background-image: url('/assets/img/background/2.jpg'); background-repeat:no-repeat; -webkit-background-size:cover; -moz-background-size:cover; -o-background-size:cover; background-size:cover; background-position:center;">
                <div class="card-body">
                    <div class="row mb-5 mt-5">
                        <form action="{{route('update_users',['id' => $items->id])}}" method="post" autocomplete="off">
                            @method('PUT')
                            @csrf
                            <div class="row justify-content-md-center">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Nama Lengkap</label>
                                        <input name="name" type="text" class="form-control form-control-sm" 
                                            value="{{$items->name}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" id="email" class="form-control form-control-sm"
                                             value="{{$items->email}}" required>
                                    </div>
                                    <div class="form-group pt-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" id="checkbox" type="checkbox"
                                                id="flexSwitchCheckDefault">
                                            <label class="form-check-label" for="flexSwitchCheckDefault">Ubah Kata Sandi</label>
                                        </div>
                                    </div>
                                    <div class="form-group password">
                                        <label for="">Kata Sandi</label>
                                        <input type="text" name="password" id="password" class="form-control form-control-sm"
                                             value="{{$items->password_text}}">
                                    </div>
                                    <div class="form-group confirm_password">
                                        <label for="">Konfirmasi Kata Sandi</label>
                                        <input type="text" name="confirm_password" id="confirm_password"
                                            class="form-control form-control-sm" value="{{$items->password_text}}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Telepon</label>
                                        <input type="text" name="phone" id="phone" class="form-control form-control-sm"
                                             value="{{$items->phone}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Perusahaan</label>
                                        <select name="company_id" id="selectCompany" class="selectCompany form-control form-control-sm">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Devisi</label>
                                        <select name="division_id" id="company_id" class="selectDivision form-control form-control-sm">
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

    $('.selectCompany').on("select2:select", function(e) { 
        var data = "SKB";
        console.log(data);
    });

    $('.selectCompany').select2({
        ajax: {
            url: '{{url("/request-tickets/search-company")}}',
            dataType: 'json',
            processResults: function ({
                data
            }) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.id,
                            text: item.company
                        }
                    })
                }
            }
        }
    }).select2().select2('val','SKB');;

    $('.selectCompany').on('select2:select select2:unselect', function (e) {
        const id = $('.selectCompany').val();

        $(".selectDivision").select2({
            ajax: {
                url: "{{url('request-tickets/search-division')}}/" + id,
                dataType: 'json',
                processResults: function ({
                    data
                }) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.division
                            }
                        })
                    }
                }
            }
        });
    });

</script>
@endsection
