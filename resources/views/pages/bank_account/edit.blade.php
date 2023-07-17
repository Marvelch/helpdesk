@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card" style="z-index: 1; font-family: var(--bs-font-roboto);">
                <div class="card-body">
                    <form action="{{route('update_bank_accounts',['id' => $bankAccounts->id])}}" method="post"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row mt-5 justify-content-md-center">
                            <div class="col-md-3">
                                <div class="card">
                                    @if(!$bankAccounts->attachment)
                                    <div class="card-body shadow" style="height: 250px;">
                                        <img src="{{asset('./assets/img/404.png')}}"
                                            alt="" srcset="" style="width: 100%;">
                                    </div>
                                    @elseif(Str::contains($bankAccounts->attachment,['.jpg','.png']))
                                    <div class="card-body shadow" style="height: 250px;">
                                        <img src="{{asset('storage/'.$bankAccounts->attachment)}}" alt="" srcset=""
                                            style="width: 100%;">
                                    </div>
                                    @else
                                    <div class="card-body shadow" style="height: 250px;">
                                        <img src="https://static.vecteezy.com/system/resources/previews/022/597/326/original/3d-file-doc-icon-illustration-png.png"
                                            alt="" srcset="" style="width: 100%;">
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group mt-3">
                                    <div class="form-check">
                                        <input class="form-check-input checkbox" type="checkbox" value=""
                                            id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            <small>Mengubah Dokumen Pengguna</small>
                                        </label>
                                    </div>
                                </div>
                                @error('attachment')
                                <p class="error__required">* {{ $message }}</p>
                                @enderror
                                <div class="form-group attachment_download">
                                    <a href="{{route('download_bank_accounts',['id' => Crypt::encryptString($bankAccounts->attachment)])}}"
                                        class="btn btn-sm btn-primary w-100 font-roboto {{$bankAccounts->attachment ? '': 'disabled'}}">Download</a>
                                </div>
                                <div class="form-group attachment">
                                    <label for="">Dokumen PDF / Docs / JPG</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text" id="inputGroup-sizing-sm"></span>
                                        <input name="attachment" type="file" class="form-control"
                                            aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                </div>
                                <div class="form-group">
                                    @error('attachment')
                                    <p class="error__required">* {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 small" style="margin-left: 30px;">
                                <div class="table-responsive">
                                    <div class="form-group">
                                        <label for="">Nama Lengkap</label>
                                        <input type="text" name="fullName"
                                            class="form-control form-control-sm text-capitalize"
                                            value="{{$bankAccounts->fullname}}" aria-label="Username"
                                            aria-describedby="basic-addon1">
                                        @error('fullName')
                                        <p class="error__required">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="text" name="email" class="form-control form-control-sm"
                                            value="{{Str::ucfirst($bankAccounts->email)}}" aria-label="Username"
                                            aria-describedby="basic-addon1">
                                        @error('email')
                                        <p class="error__required">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Username</label>
                                        <input type="text" name="userName"
                                            class="form-control form-control-sm"
                                            value="{{$bankAccounts->username}}" aria-label="Username"
                                            aria-describedby="basic-addon1">
                                        @error('userName')
                                        <p class="error__required">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">URL</label>
                                        <input type="text" name="url" class="form-control form-control-sm"
                                            value="{{$bankAccounts->url}}" aria-label="Username"
                                            aria-describedby="basic-addon1">
                                        @error('url')
                                        <p class="error__required">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Kata Sandi</label>
                                        <input type="text" name="password" class="form-control form-control-sm"
                                            value="{{$bankAccounts->password}}" aria-label="Username"
                                            aria-describedby="basic-addon1">
                                        @error('password')
                                        <p class="error__required">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Keterangan</label>
                                        <textarea name="description" id="" cols="30" rows="5"
                                            class="form-control text-capitalize">{{$bankAccounts->description}}</textarea>
                                        @error('description')
                                        <p class="error__required">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <div class="form-group">
                                            <button class="btn btn-sm btn-primary">simpan</button>
                                        </div>
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
<script>
    $('.attachment').hide();

    $('.checkbox').on('click', function () {
        if ($('.checkbox').is(':checked')) {
            $('.attachment').show();
            $('.attachment_download').hide();
        } else {
            $('.attachment_download').show();
            $('.attachment').hide();
        }
    });

    $(document).ready(function () {

    });

</script>
@endsection
