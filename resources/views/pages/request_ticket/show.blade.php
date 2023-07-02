@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="progress m-2 mb-4">
                        <div class="progress-bar" role="progressbar" style="
                        <?php if($requestTickets->status == 0) { 
                            echo "width: 30%;";
                        }elseif($requestTickets->status == 1){
                            echo "width: 60%;";
                        }else{
                            echo "width: 100%;";
                        }
                        ?>
                        " aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="row justify-content-md-center">
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
                        <div class="col-md-3">
                            <div class="form-group mt-2">
                                @if(!$requestTickets->attachment)
                                <div class="card-body shadow" style="height: 250px;">
                                    <img src="{{asset('./assets/img/file-not-found.jpg')}}" alt="" srcset=""
                                        style="width: 100%;">
                                </div>
                                @elseif(Str::contains($requestTickets->attachment,['.jpg','.png']))
                                <div class="card-body shadow" style="height: 250px;">
                                    <img src="{{asset('storage/'.$requestTickets->attachment)}}" alt="" srcset=""
                                        style="width: 100%;">
                                </div>
                                @else
                                <div class="card-body shadow" style="height: 250px;">
                                    <img src="https://static.vecteezy.com/system/resources/previews/022/597/326/original/3d-file-doc-icon-illustration-png.png" alt="" srcset=""
                                        style="width: 100%;">
                                </div>
                                @endif
                                <div class="form-group mt-3">
                                    <a href="{{route('download_bank_accounts',['id' => Crypt::encryptString($requestTickets->attachment)])}}"
                                        class="btn btn-sm btn-primary w-100 font-roboto {{$requestTickets->attachment ? '': 'disabled'}}">Download</a>
                                </div>
                            </div>
                            <!-- <img src="{{asset('./assets/img/3.png')}}" alt="" srcset="" style="max-width: 100%;"> -->
                        </div>
                        <div class="col-md-5 m-2" style="font-size: 12px;">
                            <div class="card-body shadow">
                                <table class="table table-borderless text-small">
                                    <tr>
                                        <td style="width: 25%;">Permintaan Pengguna</td>
                                        <td>: {{@$requestTickets->title}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%;">Perusahaan</td>
                                        <td>: {{@$requestTickets->company->company}}</td>
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
                            </div>
                            @if(@Auth::user()->level->special_character == env('LEVEL_ADMIN') OR
                            @Auth::user()->level->special_character == env('LEVEL_EDITOR'))
                            <form action="{{route('update_request_ticket',['id' => $requestTickets->id])}}"
                                method="post">
                                @method('PUT')
                                @csrf
                                @if(!$requestTickets->assignment_on_user_id)
                                <div class="form-group mt-3">
                                    <small>Perhatikan pembaharuan status permintaan dan pemilihan penugasan akan
                                        mempengaruhi GPM dari setiap karyawan</small>
                                </div>
                                <div class="form-group">
                                    <select name="" id="" class="form-control form-control-sm w-60">
                                        <option value="">Open</option>
                                        <option value="">In Progress</option>
                                        <option value="">Close</option>
                                    </select>
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
                                @if($requestTickets->status == 1)
                                <div class="form-group mt-4 text-capitalize">
                                    <small>Pemintaan untuk <a href="{{route('create_ticket_request_hardware_software',['id' => Crypt::encryptString($requestTickets->id)])}}"><u>pengadaan
                                                hadware/software</u></a></small>
                                </div>
                                @endif
                                @error('assignTo')
                                <p class="error__required">* {{ $message }}</p>
                                @enderror
                                <div class="form-group" id="assignToToggle">
                                    <!-- <small>Berikan Tugas Kepada</small> -->
                                    <select name="assignTo" id="assignTo"
                                        class="form-select assignTo form-select-sm w-60 mt-1 text-capitalize">
                                    </select>
                                </div>
                                <div class="form-group mt-4 d-flex justify-content-end">
                                    <button type="submit"
                                        class="{{$requestTickets->assignment_on_user_id ? 'disabled' : ''}} btn bg-gradient-info w-40 mt-4 mb-0">simpan</button>
                                </div>
                            </form>
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
                    url: '{{url("/request-tickets/searching-users")}}',
                    dataType: 'json',
                    processResults: function ({
                        data
                    }) {
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
