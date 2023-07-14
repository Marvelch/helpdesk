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
                <div class="avatar avatar-xl position-relative">
                    <img src="../assets/img/bruce-mars.jpg" alt="profile_image"
                        class="w-100 border-radius-lg shadow-sm">
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1 text-capitalize">
                        {{Auth::user()->name}}
                    </h5>
                    <small style="font-family: var(--bs-font-roboto);">Offline</small>
                    <!-- <p class="mb-0 font-weight-bold text-sm">
                        {{Auth::user()->email}}
                    </p> -->
                </div>
            </div>
            <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                <div class="nav-wrapper position-relative end-0">
                    <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 " data-bs-toggle="modal" data-bs-target="#exampleModal"
                                href="javascript:;" role="tab" aria-selected="false">
                                <i class="fa-duotone fa-grid-2"></i>
                                <span class="ms-1">Settings</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-1 " data-bs-toggle="modal" data-bs-target="#exampleModal"
                                href="javascript:;" role="tab" aria-selected="false"><a href="{{route('logout')}}">
                                <i class="fa-duotone fa-right-from-bracket"></i>
                                <span class="ms-1">Log out</span></a>
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
                                 <div class="form-group">
                                <label for="">Keterangan</label>
                                <input type="text" class="form-control form-control-sm w-70">
                            </div>
                            </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card align" style="width: 18rem;">
                                <img src="https://cdn3d.iconscout.com/3d/premium/thumb/search-not-found-5342748-4468820.png"
                                    class="card-img-top w-70" alt="...">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Pilih File JPG / PNG</label>
                                        <input class="form-control" type="file" id="formFile">
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
