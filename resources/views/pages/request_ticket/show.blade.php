@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="progress m-2 mb-4">
                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mt-5">
                                <!-- <img src="{{asset('./assets/img/4.png')}}" alt="" srcset="" class="rounded"
                                        style="width: 100%;"> -->
                                <label for="">Download File</label>
                                <input name="image" class="form-control form-control-sm select__image" type="file"
                                    style="width: 80%;">
                            </div>
                            <!-- <img src="{{asset('./assets/img/3.png')}}" alt="" srcset="" style="max-width: 100%;"> -->
                        </div>
                        <div class="col-md-7 m-2" style="font-size: 12px;">
                            @if ($alert = Session::get('failed'))
                            <div class="alert alert-primary" role="alert" style="font-size: 12px; color: white;">
                                <i class="fa-solid fa-bell" style="padding-right: 15px;"></i>{{$alert}}
                            </div>
                            @endif
                            @if ($alert = Session::get('success'))
                            <div class="alert alert-info" role="alert" style="font-size: 12px; color: white;">
                                <i class="fa-solid fa-bell" style="padding-right: 15px;"></i>{{$alert}}
                            </div>
                            @endif
                            <table class="table table-borderless text-small">
                                <tr>
                                    <td style="width: 25%;">Permintaan Pengguna</td>
                                    <td>: {{$requestTickets->title}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;">Perusahaan</td>
                                    <td  class="text-center">: {{@$requestTickets->company->company}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;">Devisi</td>
                                    <td>: {{@$requestTickets->division->division}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;">Hingga Tanggal</td>
                                    <td>: {{@date('d-m-Y',strtotime($requestTickets->deadline))}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;">Jenis Pekerjaan</td>
                                    <td>: {{@$requestTickets->typeOfWork->typeofwork}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;">Lokasi</td>
                                    <td>: {{@$requestTickets->location}}</td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;">Keterangan</td>
                                    <td>: {!! strip_tags($requestTickets->description) !!}</td>
                                </tr>
                            </table>
                            <div class="form-group">
                                <small>Hi {{Auth::user()->name}} Pilih <b>Diterima</b> untuk melanjutkan proses ke
                                    teknisi dan <b>Tidak Diterima</b> untuk membatalkan tiket.</small>
                            </div>
                            <form action="{{route('update_request_ticket',['id' => $requestTickets->id])}}"
                                method="post">
                                @method('PUT')
                                @csrf
                                <div class="form-group col-4">
                                    <select name="approvement" class="form-select form-select-sm"
                                        aria-label=".form-select-sm example">
                                        <option value="1" selected>Diterima</option>
                                        <option value="0">Tidak Diterima</option>
                                    </select>
                                </div>
                                <div class="form-group mt-4 d-flex justify-content-end">
                                    <button type="submit"
                                        class="{{$requestTickets->approvement ? 'disabled' : ''}} btn bg-gradient-info w-40 mt-4 mb-0">simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
