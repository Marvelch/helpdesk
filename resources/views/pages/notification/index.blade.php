@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-10 col-md-6">
                    <div class="card h-100">
                        <div class="card-body p-3 m-5">
                            @if(count($items) > 0)
                            @foreach($items as $item)
                            <div class="timeline timeline-one-side">
                                <div class="timeline-block mb-3">
                                    <!-- <span class="timeline-step">
                                        <i class="fa-solid fa-circle fa-sm text-success text-gradient"></i>
                                    </span> -->
                                    <div class="timeline-content">
                                        <div class="card shadow">
                                            <div class="card-body" onclick="window.location='{{ url($item->path) }}'" style="cursor: pointer;">
                                                <div class="row">
                                                    <div class="col-2 text-center">
                                                        <img src="{{ Avatar::create(Str::upper(@Str::lower($item->tickets->usersReq->name) ? @Str::lower($item->tickets->usersReq->name) : 'NULL'))->setShape('square')->setFontSize(30)->toBase64() }}"
                                                            alt="profile_image" class="w-80 border-radius-lg shadow-sm"
                                                            style="border-radius: 10px; margin-top: 10px;">
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="row" style="font-size: 12px;">
                                                            <div class="col-md-12">
                                                                <span class="fw-bold">Request Ticket
                                                                    #{{@$item->id}}</span>
                                                                <br>
                                                                <span
                                                                    style="font-size: 10px;">{{@Str::lower($item->tickets->created_at)}}</span>
                                                            </div>
                                                            <div class="col-md-12 text-capitalize">
                                                                <span style="font-size: 11px;">Pemintaan pengguna
                                                                    {{@Str::lower($item->tickets->usersReq->name)}}
                                                                    dengan jenis laporan pekerjaan
                                                                    {{@Str::lower($item->tickets->work_type->type)}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="form-group d-flex justify-content-center">
                                <img src="{{asset('./assets/img/icon/alert_notification.png')}}"
                                    alt="" srcset="" style="width: 60%;">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
