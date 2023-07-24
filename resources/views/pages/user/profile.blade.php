@extends('layouts.app')

@section('contents')
<div class="container-fluid">
    <div class="page-header min-height-300 border-radius-xl mt-4"
        style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
        <span class="mask bg-gradient-primary opacity-6"></span>
    </div>
    <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative" style="margin: 10px 0px 0px 10px">
                    @if(Auth::user()->photo)
                    <img src="{{asset('storage/'.Auth::user()->photo)}}" alt="profile_image"
                        class="w-100 border-radius-lg shadow-sm" style="height: auto; width: 100%; max-width: 100%;">
                    @else
                    <img src="{{ Avatar::create(Str::upper(Auth::user()->name))->setShape('square')->setFontSize(30)->toBase64() }}" alt="profile_image"
                        class="w-100 border-radius-lg shadow-sm" style="height: auto; width: 100%; max-width: 100%; border-radius: 10px;">
                    @endif
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1 text-capitalize">
                        {{Auth::user()->name}}
                    </h5>
                    <small style="font-family: var(--bs-font-roboto);">{{$status}}</small>
                    <!-- <p class="mb-0 font-weight-bold text-sm">
                        {{Auth::user()->email}}
                    </p> -->
                </div>
            </div>
            <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                <div class="nav-wrapper position-relative end-0">
                    <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                        <!-- <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 " data-bs-toggle="modal" data-bs-target="#exampleModal"
                                href="javascript:;" role="tab" aria-selected="false">
                                <i class="fa-duotone fa-grid-2"></i>
                                <span class="ms-1">Settings</span>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                href="javascript:;" role="tab" aria-selected="false"><a href="{{route('logout')}}">
                                    <i class="fa-duotone fa-right-from-bracket small"></i>
                                    <span class="ms-1 small">Sign Out</span></a>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row m-3">
                        <div class="col-md-6" style="font-family: var(--bs-font-roboto);">
                            <div class="card">
                                <div class="card-body shadow">
                                    <form action="{{route('update_photo_users',['id' => Auth::user()->id])}}" method="post" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Photo Profile</label>
                                            <input type="file" name="photo" class="form-control form-control-sm">
                                            @error('photo')
                                            <p class="error__required">* {{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body shadow">
                                    <div class="table table-responsive">
                                        <table class="table table-borderless" style="font-size: 12px;">
                                            <tbody>
                                                <tr>
                                                    <td class="w-40">Nama Lengkap</td>
                                                    <td class="text-capitalize">: {{Auth::user()->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Email</td>
                                                    <td class="text-capitalize">: {{Auth::user()->email}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Username</td>
                                                    <td class="text-capitalize">: {{Auth::user()->username}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Telepon</td>
                                                    <td class="text-capitalize">: {{Auth::user()->phone}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-40">Perusahaan</td>
                                                    <td class="text-capitalize">: {{Auth::user()->company->company}}</td>

                                                </tr>
                                                <tr>
                                                    <td class="w-40">Divisi</td>
                                                    <td class="text-capitalize">: {{Auth::user()->division->division}}</td>
                                                </tr>
                                            </tbody>
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
