@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card"
                style="z-index: 1; font-family: var(--bs-font-roboto); background-image: url('/assets/img/background/2.jpg'); background-repeat:no-repeat; -webkit-background-size:cover; -moz-background-size:cover; -o-background-size:cover; background-size:cover; background-position:center;">
                <div class="card-body">
                    <div class="row mb-5 mt-5 d-flex justify-content-center">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{route('update_users',['id' => $items->id])}}" method="post"
                                        autocomplete="off" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <div class="row center justify-content-md-center mt-5 mb-5">
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <label for="">Nama Lengkap</label>
                                                    <input name="name" type="text" class="form-control form-control-sm"
                                                        value="{{$items->name}}" required>
                                                    @error('name')
                                                    <p class="error__required">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Username</label>
                                                    <input name="username" type="text" class="form-control form-control-sm"
                                                        value="{{$items->username}}" required>
                                                    @error('username')
                                                    <p class="error__required">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Email</label>
                                                    <input type="email" name="email" id="email"
                                                        class="form-control form-control-sm" value="{{$items->email}}"
                                                        required>
                                                    @error('email')
                                                    <p class="error__required">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group pt-2">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" id="checkbox" type="checkbox"
                                                            id="flexSwitchCheckDefault">
                                                        <label class="form-check-label"
                                                            for="flexSwitchCheckDefault">Ubah
                                                            Kata Sandi</label>
                                                    </div>
                                                </div>
                                                <div class="form-group password">
                                                    <label for="">Kata Sandi</label>
                                                    <input type="text" name="password" id="password"
                                                        class="form-control form-control-sm"
                                                        value="{{$items->password_text}}">
                                                    @error('password')
                                                    <p class="error__required">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group confirm_password">
                                                    <label for="">Konfirmasi Kata Sandi</label>
                                                    <input type="text" name="confirm_password" id="confirm_password"
                                                        class="form-control form-control-sm"
                                                        value="{{$items->password_text}}">
                                                    @error('confirm_password')
                                                    <p class="error__required">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <label for="">Telepon</label>
                                                    <input type="text" name="phone" id="phone"
                                                        class="form-control form-control-sm" value="{{$items->phone}}"
                                                        required>
                                                    @error('phone')
                                                    <p class="error__required">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Perusahaan</label>
                                                    <select name="company_id" id="selectCompany"
                                                        class="selectCompany form-control form-control-sm">
                                                    </select>
                                                    @error('company_id')
                                                    <p class="error__required">* {{ $message }}</p>
                                                    @enderror
                                                    <input type="hidden" id="company_id"
                                                        value="{{@$items->company_id}}">
                                                    <input type="hidden" id="company_text"
                                                        value="{{@$items->company->company}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Devisi</label>
                                                    <select name="division_id" id="selectDivision"
                                                        class="selectDivision form-control form-control-sm">
                                                    </select>
                                                    @error('division_id')
                                                    <p class="error__required">* {{ $message }}</p>
                                                    @enderror
                                                    <input type="hidden" id="division_id"
                                                        value="{{@$items->division_id}}">
                                                    <input type="hidden" id="division_text"
                                                        value="{{@$items->division->division}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Jabatan</label>
                                                    <select name="position_id" id="position_id"
                                                        class="form-control form-control-sm">
                                                        @foreach($position as $item)
                                                        <option value="{{$item->id}}" {{($item->id == $items->position_id) ? 'selected' : ''}}>{{$item->position}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('item_name')
                                                    <p class="error__required">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="alert alert-info error_password" role="alert"
                                                    style="font-size: 12px; color: white;">
                                                    <i class="fa-solid fa-bell" style="padding-right: 15px;"></i> Make
                                                    sure
                                                    the
                                                    password is correct.
                                                </div>
                                                @if ($alert = Session::get('failed'))
                                                <div class="alert alert-info" role="alert"
                                                    style="font-size: 12px; color: white;">
                                                    <i class="fa-solid fa-bell"
                                                        style="padding-right: 15px;"></i>{{$alert}}
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

     $('#selectCompany').on('change',function() {
        $('#selectDivision').val('');
     });

    var $option = $("<option selected></option>").val($('#company_id').val()).text($('#company_text').val());

    $('#selectCompany').append($option).trigger('change');

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
    });

    var $option = $("<option selected></option>").val($('#division_id').val()).text($('#division_text').val());

    $('#selectDivision').append($option).trigger('change');

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
