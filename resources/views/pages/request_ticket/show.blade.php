@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body mb-5">
                    <div class="row justify-content-md-center mt-5">
                        @if ($alert = Session::get('failed'))
                        <div class="alert alert-primary w-80 mb-3" role="alert" style="font-size: 12px; color: white;">
                            <i class="fa-solid fa-bell" style="padding-right: 15px;"></i>{{$alert}}
                        </div>
                        @endif
                        @if ($alert = Session::get('success'))
                        <div class="alert alert-info w-80 mb-3" role="alert" style="font-size: 12px; color: white;">
                            <i class="fa-solid fa-bell" style="padding-right: 15px;"></i>{{$alert}}
                        </div>
                        @endif
                        <div class="col-md-4">
                            <div class="form-group mt-2">
                                @if(!$requestTickets->attachment)
                                <div class="card card-blog card-plain">
                                    <div class="position-relative">
                                        <a class="d-block shadow-xl border-radius-xl p-2">
                                            <img src="{{asset('./assets/img/gif/404.gif')}}" alt="img-blur-shadow"
                                                class="img-fluid shadow border-radius-xl"
                                                style="height: 35vh; width: 100%;">
                                        </a>
                                    </div>
                                </div>
                                @elseif(Str::contains($requestTickets->attachment,['.jpg','.png']))
                                <div class="card shadow card-blog card-plain">
                                    <div class="card-body">
                                        <h6>Document</h6>
                                        <p
                                            style="font-size: 11px; font-family: var(--bs-font-quicksand); text-align: justify;">
                                            Terlampir untuk file pendukung laporan. Bila file mengalami gangguan dapat
                                            menghubungi kami ke <a href="http://">whatsapp</a> - Information Technology
                                        </p>
                                        <div class="row mt-3 d-flex justify-content-center">
                                            <hr style="border: 1px solid green;">
                                            <div class="col">
                                                <p class="fw-bold text-sm mt-2">Docs Request #{{@$requestTickets->id}}
                                                </p>
                                            </div>
                                            <div class="col">
                                                <a class="btn btn-sm"
                                                    href="{{route('download_bank_accounts',['id' => Crypt::encryptString($requestTickets->attachment)])}}"
                                                    {{$requestTickets->attachment ? '': 'disabled'}}>download</a>
                                            </div>
                                        </div>
                                        <!-- <div class="position-relative">
                                        <a class="d-block">
                                            <img src="https://cdn.dribbble.com/users/2882033/screenshots/14282247/media/70e1a373c18a438ddbae86d25e5b6df7.png" alt="img-blur-shadow"
                                                class="img-fluid shadow border-radius-xl" style="height: 35vh; width: 100%;">
                                        </a>
                                    </div> -->
                                        <!-- <div class="card-body px-1 pb-0">
                                        <p class="text-gradient text-dark mb-2" style="font-size: 12px;"><a href="{{route('download_bank_accounts',['id' => Crypt::encryptString($requestTickets->attachment)])}}" {{$requestTickets->attachment ? '': 'muted'}}>Download Docs Request #{{@$requestTickets->id}}</a></p>
                                    </div> -->
                                    </div>
                                </div>
                                @else
                                <div class="card card-blog card-plain">
                                    <div class="position-relative">
                                        <a class="d-block shadow-xl border-radius-xl p-2">
                                            <img src="{{asset('./assets/img/gif/404.gif')}}" alt="img-blur-shadow"
                                                class="img-fluid shadow border-radius-xl"
                                                style="height: 35vh; width: 100%;">
                                        </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <!-- <img src="{{asset('./assets/img/3.png')}}" alt="" srcset="" style="max-width: 100%;"> -->
                        </div>
                        <div class="col-md-6 m-2" style="font-size: 12px;">
                            <div class="card shadow-sm">
                                <div class="card-body m-2">
                                    <table class="table table-borderless text-small">
                                        <tr>
                                            <td class="w-40">Permintaan Pengguna</td>
                                            <td>: {{@$requestTickets->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>Perusahaan</td>
                                            <td>: {{$requestTickets->company->company}}</td>
                                        </tr>
                                        <tr>
                                            <td>Devisi</td>
                                            <td>: {{$requestTickets->division->division}}</td>
                                        </tr>
                                        <tr>
                                            <td>Hingga Tanggal</td>
                                            <td>: {{@date('d-m-Y',strtotime($requestTickets->deadline))}}</td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Pekerjaan</td>
                                            <td>: {{@$requestTickets->work_type->type}}</td>
                                        </tr>
                                        <tr>
                                            <td>Lokasi</td>
                                            <td>: {{@$requestTickets->location}}</td>
                                        </tr>
                                        <tr>
                                            <td>Keterangan</td>
                                            <td>: {!! strip_tags($requestTickets->description) !!}</td>
                                        </tr>
                                        @if(@$requestTickets->assignment_on_user_id)
                                        <tr>
                                            <td>Ditugaskan Kepada</td>
                                            <td>: {{Str::ucfirst($requestTickets->usersAss->name)}}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                            @if(@Auth::user()->level_id == env('LEVEL_ADMIN') OR
                            @Auth::user()->level_id == env('LEVEL_EDITOR'))
                            <form action="{{route('update_request_ticket',['id' => $requestTickets->id])}}"
                                method="post">
                                @method('PUT')
                                @csrf
                                @if(!$requestTickets->assignment_on_user_id)
                                <div class="form-group mt-3">
                                    <small>Perhatikan pembaharuan status permintaan dan pemilihan penugasan akan
                                        mempengaruhi GPM dari setiap karyawan</small>
                                </div>
                                <div class="form-group mt-2">
                                    <small>Perbaharui status dan assign kepada :</small>
                                    <select name="approvement" class="approvement w-60 mt-3 form-select form-select-sm"
                                        aria-label=".form-select-sm example">
                                        <option value="0" selected>Tidak Diterima</option>
                                        <option value="1">Diterima</option>
                                    </select>
                                </div>
                                @endif
                                @error('assignTo')
                                <p class="error__required">* {{ $message }}</p>
                                @enderror
                                <input type="hidden" name="notification"
                                    value="{{Crypt::encryptString($requestTickets->id)}}">
                                <div class="form-group" id="assignToToggle">
                                    <p style="margin-bottom: 12px; font-size: 11px;">Ditugaskan Kepada :</p>
                                    <select name="assignTo" id="assignTo"
                                        class="form-select assignTo form-select-sm w-60 mt-1 text-capitalize">
                                    </select>
                                </div>
                                @if($requestTickets->status == env('DEFAULT'))
                                <div class="form-group mt-4 d-flex justify-content-end">
                                    <button type="submit"
                                        class="{{$requestTickets->assignment_on_user_id ? 'disabled' : ''}} btn bg-gradient-info w-40 mt-4 mb-0">simpan</button>
                                </div>
                                @endif
                            </form>
                            @endif
                            @if(@$requestTickets->assignment_on_user_id == Auth::user()->id AND
                            @$requestTickets->status
                            == env('INPROGRESS') OR Auth::user()->level_id == env('LEVEL_ADMIN') OR
                            Auth::user()->level_id == env('LEVEL_EDITOR'))
                            @if($requestTickets->status == env('COMPLETED'))
                            <div class="form-group mt-2">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <small class="text-capitalize"><i class="fa-solid fa-bell fa-lg"
                                                style="margin-right: 12px;"></i> permintaan tiket
                                            #{{@$requestTickets->id}} telah selesai</small>
                                    </div>
                                </div>
                            </div>
                            @elseif($requestTickets->status == env('INPROGRESS'))
                            <form action="{{route('update_status_request_ticket',['id' => $requestTickets->id])}}"
                                method="post">
                                @method('PUT')
                                @csrf
                                <!-- 
                                <div class="form-group mt-4 text-capitalize">
                                    <small>Pemintaan untuk <a
                                            href="{{route('create_ticket_request_hardware_software',['id' => Crypt::encryptString($requestTickets->id)])}}"><u>pengadaan
                                                hadware/software</u></a></small>
                                </div>
                                <p style="font-size: 11px; margin-top: 20px; margin-bottom: 5px;">Konfirmasi Status
                                    Permintaan</p>
                                <select name="status" id="" class="form-control form-control-sm w-50">
                                    <option value="{{env('COMPLETED')}}">SELESAI</option>
                                    <option value="{{env('UNCOMPLETED')}}">BATAL</option>
                                </select>
                                <div class="form-group mt-4 d-flex justify-content-end">
                                    <button type="submit" class="btn bg-gradient-info w-40 mt-4 mb-0">simpan</button>
                                </div> -->
                                <div class="form-group mt-3">
                                    <small>Pemintaan untuk <a
                                            href="{{route('create_ticket_request_hardware_software',['id' => Crypt::encryptString($requestTickets->id)])}}"><u>pengadaan
                                                hadware/software</u></a></small>
                                </div>
                                <div class="form-group mt-4 d-flex justify-content-end">
                                    <a class="btn bg-gradient-info w-30 mt-4 mb-0" data-bs-toggle="modal"
                                        href="#exampleModalToggle" role="button">periksa</a>
                                </div>
                                <div class="modal fade" id="exampleModalToggle" aria-hidden="true"
                                    aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                    <div class="modal-dialog modal-fullscreen">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" style="color: black;"><i
                                                        class="fa-solid fa-xmark"></i></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table table-responsive">
                                                    <table class="table table-striped">
                                                        <thead class="text-center">
                                                            <tr>
                                                                <th>Nama Barang</th>
                                                                <th>Qty</th>
                                                                <th>Pilih</th>
                                                            </tr>
                                                        </thead>
                                                        @foreach($itemsRequests as $item)
                                                        <tbody>
                                                            <tr class="text-capitalize">
                                                                <td>
                                                                    {{$item->item_name}}
                                                                    <input type="hidden" name="items_id"
                                                                        value="{{$item->items_id}}">
                                                                    <input type="hidden" name="inventory_unique[]"
                                                                        value="{{$item->inventory_unique}}">
                                                                </td>
                                                                <td class="text-center">
                                                                    {{$item->qty}}
                                                                    <input type="hidden" name="qty[]"
                                                                        value="{{$item->qty}}">
                                                                </td>
                                                                <td class="w-30">
                                                                    <div
                                                                        class="form-check form-switch d-flex justify-content-center">
                                                                        <input name="item_use[]"
                                                                            class="form-check-input" type="checkbox"
                                                                            id="flexSwitchCheckDefault"
                                                                            style="font-size: 16px;">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row m-4">
                                                <div class="col-md-12 ">
                                                    <div class="form-group">
                                                        <select name="status" id=""
                                                                class="form-control form-control-sm w-20 shadow">
                                                                <option value="{{env('COMPLETED')}}">SELESAI</option>
                                                                <option value="{{env('UNCOMPLETED')}}">BATAL</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-sm btn-primary" {{@$item->status == 2 ? '' : 'disabled'}}>simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#assignToToggle').hide();

    $('.approvement').on('change', function () {
        if ($('.approvement').find(':selected').val() == 1) {
            $('#assignToToggle').show();

            $('.assignTo').select2({
                ajax: {
                    url: '{{url("/request-tickets/searching/users/assign/to")}}',
                    dataType: 'json',
                    processResults: function ({
                        data
                    }) {
                        console.log(data);
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                }
                            })
                        }
                    }
                }
            });
        } else {
            $('#assignToToggle').hide();
        }
    });

</script>
@endsection
