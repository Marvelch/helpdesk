@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="card">
                                @if(!$bankAccounts->attachment)
                                <div class="card-body shadow" style="height: 320px;">
                                    <img src="{{asset('./assets/img/file-not-found.jpg')}}" alt="" srcset=""
                                        style="width: 100%;">
                                </div>
                                @elseif(Str::contains($bankAccounts->attachment,['.jpg','.png']))
                                <div class="card-body shadow" style="height: 320px;">
                                    <img src="{{asset('storage/'.$bankAccounts->attachment)}}" alt="" srcset=""
                                        style="width: 100%;">
                                </div>
                                @else
                                <div class="card-body shadow" style="height: 320px;">
                                    <img src="https://s.smallpdf.com/static/ef08c0c199f39523d073.svg" alt="" srcset=""
                                        style="width: 100%;">
                                </div>
                                @endif
                            </div>
                            <div class="form-group mt-3">
                                <a href="{{route('download_bank_accounts',['id' => Crypt::encryptString($bankAccounts->attachment)])}}"
                                    class="btn btn-sm btn-primary w-100 font-roboto {{$bankAccounts->attachment ? '': 'disabled'}}"><i class="fa-solid fa-download"
                                        style="color: #ffffff; font-size: 13px; margin-right: 4px;"></i>Download</a>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <!-- kosong -->
                        </div>
                        <div class="col-md-7 small">
                            <div class="table-responsive">
                                <div class="form-group">
                                    <label for="">Nama Lengkap</label>
                                    <div class="input-group mb-3 text-center">
                                        <span class="input-group-text pr-3" id="basic-addon1"
                                            style="padding-right: 17px;"><i class="fa-duotone fa-user"></i></span>
                                        <input type="text" class="form-control form-control-sm"
                                            value="{{$bankAccounts->fullname}}" aria-label="Username"
                                            aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <div class="input-group mb-3 text-center">
                                        <span class="input-group-text pr-3" id="basic-addon1"
                                            style="padding-right: 17px;"><i class="fa-duotone fa-user-shield"></i></span>
                                        <input type="text" class="form-control form-control-sm"
                                            value="{{$bankAccounts->username}}" aria-label="Username"
                                            aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">URL</label>
                                    <div class="input-group mb-3 text-center">
                                        <span class="input-group-text pr-3" id="basic-addon1"
                                            style="padding-right: 17px;"><i class="fa-regular fa-browser"></i></span>
                                        <input type="text" class="form-control form-control-sm"
                                            value="{{$bankAccounts->url}}" aria-label="Username"
                                            aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Kata Sandi</label>
                                    <div class="input-group mb-3 text-center">
                                        <span class="input-group-text pr-3" id="basic-addon1"
                                            style="padding-right: 17px;"><i class="fa-duotone fa-lock-keyhole"></i></span>
                                        <input type="text" class="form-control form-control-sm"
                                            value="{{$bankAccounts->password}}" aria-label="Username"
                                            aria-describedby="basic-addon1">
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                    <textarea name="" id="" cols="30" rows="5"
                                        class="form-control">{{$bankAccounts->description}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
