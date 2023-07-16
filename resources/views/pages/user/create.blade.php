@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card" style="z-index: 1; font-family: var(--bs-font-roboto);">
                <div class="card-body">
                    <div class="row mb-5 mt-5">
                        <form action="{{route('store_users')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="row justify-content-md-center">
                                <div class="col-4" style="z-index: 3;">
                                    <div class="form-group">
                                        <label for="">Nama Lengkap</label>
                                        <input name="name" type="text" class="form-control form-control-sm" value="{{old('name')}}">
                                        @error('name')
                                        <p class="error__required">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" id="email"
                                            class="form-control form-control-sm" value="{{old('email')}}">
                                        @error('email')
                                        <p class="error__required">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <div class="input-group mb-3">
                                            <input type="password" name="password" id="pwd"
                                                class="form-control form-control-sm" aria-label="Recipient's username"
                                                aria-describedby="basic-addon2"
                                                style="border-top-right-radius: 0px; border-bottom-right-radius: 0px" value="{{old('password')}}">
                                            <span class="input-group-text" id="basic-addon2"><i
                                                    class="password fa-solid fa-eye-slash"></i></span>
                                            @error('password')
                                            <p class="error__required">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Konfirmasi Password</label>
                                        <!-- <input type="password" name="confirm_password" id="confirm_password"
                                            class="form-control form-control-sm"> -->
                                        <div class="input-group mb-3">
                                            <input type="password" name="confirm_password" id="confirm_pwd"
                                                class="form-control form-control-sm" aria-label="Recipient's username"
                                                aria-describedby="basic-addon2"
                                                style="border-top-right-radius: 0px; border-bottom-right-radius: 0px" value="{{old('confirm_password')}}">
                                            <span class="input-group-text" id="basic-addon2"><i
                                                    class="confirm_password fa-solid fa-eye-slash"></i></span>
                                            @error('confirm_password')
                                            <p class="error__required">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Username</label>
                                        <input type="text" name="username" id="username" class="form-control form-control-sm" value="{{old('username')}}">
                                        @error('username')
                                        <p class="error__required">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Telepon</label>
                                        <input type="text" name="phone" id="phone" class="form-control form-control-sm" value="{{old('phone')}}">
                                        @error('phone')
                                        <p class="error__required">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Perusahaan</label>
                                        <!-- <select name="company_id" id="company_id" class="form-control form-control-sm">
                                            @foreach($items as $item)
                                            <option value="{{$item->id}}">{{$item->company}}</option>
                                            @endforeach
                                        </select> -->
                                        <select name="company_id" id="selectCompany"
                                            class="selectCompany form-select form-select-sm text-capitalize">
                                        </select>
                                        @error('company_id')
                                        <p class="error__required">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Devisi</label>
                                        <!-- <select name="division_id" id="company_id" class="form-control form-control-sm">
                                            @foreach($divisions as $item)
                                            <option value="{{$item->id}}">{{$item->division}}</option>
                                            @endforeach
                                        </select> -->
                                        <select name="division_id" id="selectDivision"
                                            class="selectDivision form-select form-select-sm text-capitalize">
                                        </select>
                                        @error('division_id')
                                        <p class="error__required">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Jabatan</label>
                                        <select name="position_id" id="position_id"
                                            class="form-control form-control-sm">
                                            @foreach($position as $item)
                                            <option value="{{$item->id}}">{{$item->position}}</option>
                                            @endforeach
                                        </select>
                                        @error('item_name')
                                        <p class="error__required">* {{ $message }}</p>
                                        @enderror
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
<script>
    $(document).ready(function () {
        $(".password").on("click", function () {

            if ($('#pwd').attr('type') == 'password') {
                $('#pwd').attr('type', 'text');
                $('.password').removeClass('fa-eye-slash');
                $('.password').addClass('fa-eye');
            } else {
                $('#pwd').attr('type', 'password');
                $('.password').removeClass('fa-eye');
                $('.password').addClass('fa-eye-slash');
            }
        })

        $(".confirm_password").on("click", function () {

            if ($('#confirm_pwd').attr('type') == 'password') {
                $('#confirm_pwd').attr('type', 'text');
                $('.confirm_password').removeClass('fa-eye-slash');
                $('.confirm_password').addClass('fa-eye');
            } else {
                $('#confirm_pwd').attr('type', 'password');
                $('.confirm_password').removeClass('fa-eye');
                $('.confirm_password').addClass('fa-eye-slash');
            }
        })
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
    });

    $('#selectCompany').on('select2:select select2:unselect', function (e) {
        const id = $('#selectCompany').val();

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
