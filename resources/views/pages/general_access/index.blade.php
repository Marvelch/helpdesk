@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="col-12 mt-4">
                        <div class="card mb-4">
                            <div class="card-header pb-0 p-3">
                                <h6 class="mb-1">General Access</h6>
                                <small class="text-sm">Pengelolaan akses untuk setiap menu Helpdesk</small>
                            </div>
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                                        <div class="card card-blog card-plain">
                                            <div class="position-relative">
                                                <a class="d-block shadow-xl border-radius-xl">
                                                    <img src="https://cdn3d.iconscout.com/3d/premium/thumb/call-to-action-8243309-6578770.png" style="width: 200px; height: 200px; object-fit: cover;" alt="img-blur-shadow"
                                                        class="img-fluid shadow border-radius-xl">
                                                </a>
                                            </div>
                                            <div class="card-body px-1 pb-0">
                                                <a href="javascript:;">
                                                    <h5>
                                                        Jenis Pekerjaan
                                                    </h5>
                                                </a>
                                                <p class="mb-4 text-sm">
                                                    Menu Request Ticket untuk menambahakn jenis pekerajaan baru dari devisi perusahaan
                                                </p>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <a type="button"
                                                        href="{{route('create_type_of_work')}}" class="btn btn-outline-primary btn-sm mb-0">TAMPILKAN</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                                        <div class="card card-blog card-plain">
                                            <div class="position-relative">
                                                <a class="d-block shadow-xl border-radius-xl">
                                                    <img src="https://cdn3d.iconscout.com/3d/premium/thumb/multiverse-4976000-4149678.png" alt="img-blur-shadow"
                                                        class="img-fluid border-radius-lg" style="width: 200px; height: 200px;">
                                                </a>
                                            </div>
                                            <div class="card-body px-1 pb-0">
                                                <a href="javascript:;">
                                                    <h5>
                                                        Divisi
                                                    </h5>
                                                </a>
                                                <p class="mb-4 text-sm">
                                                    Pengelolaan master untuk divisi dari setiap perusahaan SKB dan BPU
                                                </p>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <a href="{{route('create_division')}}" type="button"
                                                        class="btn btn-outline-primary btn-sm mb-0">TAMPILKAN</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                                        <div class="card card-blog card-plain">
                                            <div class="position-relative">
                                                <a class="d-block shadow-xl border-radius-xl">
                                                    <img src="https://cdn3d.iconscout.com/3d/premium/thumb/ui-development-5495848-4596619.png" alt="img-blur-shadow"
                                                        class="img-fluid shadow border-radius-xl">
                                                </a>
                                            </div>
                                            <div class="card-body px-1 pb-0">
                                                <p class="text-gradient text-dark mb-2 text-sm">Project #3</p>
                                                <a href="javascript:;">
                                                    <h5>
                                                        Minimalist
                                                    </h5>
                                                </a>
                                                <p class="mb-4 text-sm">
                                                    Different people have different taste, and various types of music.
                                                </p>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <button type="button"
                                                        class="btn btn-outline-primary btn-sm mb-0">View
                                                        Project</button>
                                                    <div class="avatar-group mt-2">
                                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Peterson">
                                                            <img alt="Image placeholder" src="../assets/img/team-4.jpg">
                                                        </a>
                                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Nick Daniel">
                                                            <img alt="Image placeholder" src="../assets/img/team-3.jpg">
                                                        </a>
                                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Ryan Milly">
                                                            <img alt="Image placeholder" src="../assets/img/team-2.jpg">
                                                        </a>
                                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Elena Morison">
                                                            <img alt="Image placeholder" src="../assets/img/team-1.jpg">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                                        <div class="card card-blog card-plain">
                                            <div class="position-relative">
                                                <a class="d-block shadow-xl border-radius-xl">
                                                    <img src="https://cdn3d.iconscout.com/3d/premium/thumb/online-payment-alert-6343278-5231318.png" alt="img-blur-shadow"
                                                        class="img-fluid shadow border-radius-xl">
                                                </a>
                                            </div>
                                            <div class="card-body px-1 pb-0">
                                                <p class="text-gradient text-dark mb-2 text-sm">Project #3</p>
                                                <a href="javascript:;">
                                                    <h5>
                                                        Minimalist
                                                    </h5>
                                                </a>
                                                <p class="mb-4 text-sm">
                                                    Different people have different taste, and various types of music.
                                                </p>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <button type="button"
                                                        class="btn btn-outline-primary btn-sm mb-0">View
                                                        Project</button>
                                                    <div class="avatar-group mt-2">
                                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Peterson">
                                                            <img alt="Image placeholder" src="../assets/img/team-4.jpg">
                                                        </a>
                                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Nick Daniel">
                                                            <img alt="Image placeholder" src="../assets/img/team-3.jpg">
                                                        </a>
                                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Ryan Milly">
                                                            <img alt="Image placeholder" src="../assets/img/team-2.jpg">
                                                        </a>
                                                        <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="Elena Morison">
                                                            <img alt="Image placeholder" src="../assets/img/team-1.jpg">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
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
