@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card"
                style="background-image: url('/assets/img/background/2.jpg'); background-repeat:no-repeat; -webkit-background-size:cover; -moz-background-size:cover; -o-background-size:cover; background-size:cover; background-position:center;">
                <div class="card-body">
                    <div class="row mt-5 justify-content-center">
                        <div class="col-md-3">
                            <div class="card">
                                @if(!$bankAccounts->attachment)
                                <div class="card-body shadow" style="height: 250px;">
                                    <img src="{{asset('./assets/img/404.png')}}" alt="" srcset="" style="width: 100%;">
                                </div>
                                @elseif(Str::contains($bankAccounts->attachment,['.jpg','.png']))
                                <div class="card-body shadow" style="height: 250px;">
                                    <img src="{{asset('storage/'.$bankAccounts->attachment)}}" alt="" srcset=""
                                        style="width: 100%;">
                                </div>
                                @else
                                <div class="card-body shadow" style="height: 250px;">
                                    <img src="{{asset('./assets/img/docs.png')}}" alt="" srcset="" style="width: 100%;">
                                </div>
                                @endif
                            </div>
                            <div class="form-group mt-3">
                                <a href="{{route('download_bank_accounts',['id' => Crypt::encryptString($bankAccounts->attachment)])}}"
                                    class="btn btn-sm btn-primary w-100 font-roboto {{$bankAccounts->attachment ? '': 'disabled'}}">Download</a>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-left: 30px;">
                            <div class="">
                                <div class="card-body shadow-sm p-3 mb-5 bg-body rounded" style="font-size: 15px;">
                                    <div class="table-responsive form-control-disabled-transparent">
                                        <div class="table-responsive small">
                                            <table class="table table-borderless ">
                                                <tbody>
                                                    <tr>
                                                        <td class="w-30 fw-bold">Nama Lengkap</td>
                                                        <td>: {{@Str::ucfirst($bankAccounts->fullname)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">Username</td>
                                                        <td>: {{@Str::ucfirst($bankAccounts->username)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">URL</td>
                                                        <td>: {{@Str::lower($bankAccounts->url)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">Kata Sandi</td>
                                                        <td>: {{@$bankAccounts->password}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold">Keterangan</td>
                                                        <td>: {{@$bankAccounts->description}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            </table>
                                        </div>
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
