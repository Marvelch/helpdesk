@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <form action="{{route('update_request_hardware_software')}}" method="post">
            @method('PUT')
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="card-body shadow-sm mb-2 bg-white rounded">
                        <div class="row">
                            <div class="col-8">
                            <div class="form-group mb-1 mt-2" style="margin-left: 7%;">
                                <h6 style="font-family: var(--bs-font-roboto);">Detail Permintaan Hardware dan Software
                                </h6>
                                <p style="font-size: 12px;">Pastikan permintaan telah sesuai dengan kebutuhan pengguna
                                </p>
                            </div>
                            <table class="table table-borderless pt-2" style="margin-left: 10%;">
                                <tbody style="font-size: 12px;">
                                    <tr>
                                        <th class="w-20">No Transaksi</th>
                                        <td>: {{@$headers->unique_request}}</td>
                                        <input type="hidden" name="unique_request" value="{{@$headers->unique_request}}">
                                        <input type="hidden" name="id_transaction" value="{{@$headers->id}}">
                                    </tr>
                                    <tr>
                                        <th>Permintaan</th>
                                        <td>: {{@Str::ucfirst($headers->userRequest->name)}}</td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <td>: {{@$headers->description}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-4 text-center">
                            @if(@$headers->status == env('DEFAULT') OR @$headers->status == env('INPROGRESS'))
                            <div class="row">
                                <div class="col-md-12">
                                    <img src="https://cdn3d.iconscout.com/3d/premium/thumb/businessman-working-on-laptop-2996954-2493508.png" class="rounded" alt="" srcset="" style="width: 80%;">
                                </div>
                                <div class="col-md-12 d-flex justify-content-center">

                                @if(Auth::user()->division->division == env('DIVISION_IT'))
                                    @if($headers->approval_general_manager == env('NOT_ACCEPTED') AND $headers->approval_manager == env('NOT_ACCEPTED') AND $headers->approval_supervisor == env('NOT_ACCEPTED'))
                                        <select name="approval_supervisor" id="" class="form-control form-control-sm w-60 mt-3">
                                            <option value="1">Terima</option>
                                            <option value="2">Tolak</option>
                                        </select>
                                    @elseif($headers->approval_supervisor == env('ACCEPTED'))
                                        <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                            Terima Kasih, Telah Menyetujui Permintaan {{@$headers->unique_request}}
                                        </p>
                                    @elseif($headers->approval_supervisor == env('CANCEL') AND $headers->status = env('UNCOMPLETED'))
                                        <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                            Hi {{Auth::user()->name}}, Telah Membatalkan Permintaan
                                        </p>
                                    @else 
                                         <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                            Menunggu Persetujuan Dari Manager & General Manager
                                        </p>
                                    @endif
                                @endif

                                <!-- Manager Not Multi Company -->
                                @if(Auth::user()->position_id == env('MANAGER') AND Auth::user()->division_id == $headers->division_id AND Auth::user()->multi_company == 0)
                                    @if($headers->approval_manager == env('NOT_ACCEPTED') AND $headers->approval_general_manager == env('NOT_ACCEPTED') AND $headers->approval_supervisor == env('ACCEPTED'))
                                        <select name="approval_manager" id="" class="form-control form-control-sm w-60 mt-3">
                                            <option value="1">Terima</option>
                                            <option value="2">Tolak</option>
                                        </select>
                                    @elseif($headers->approval_manager == env('ACCEPTED'))
                                        <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                            Terima Kasih, Telah Menyetujui Permintaan {{@$headers->unique_request}}
                                        </p>
                                    @elseif($headers->approval_manager == env('CANCEL') AND $headers->status = env('UNCOMPLETED'))
                                        <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                            Hi {{Auth::user()->name}}, Telah Membatalkan Permintaan
                                        </p>
                                    @elseif($headers->approval_supervisor == env('NOT_ACCEPTED') AND $headers->approval_general_manager == env('NOT_ACCEPTED'))
                                        <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                            Hi {{Auth::user()->name}}, permintaan sedang staff it cek dahulu
                                        </p>
                                    @endif
                                @endif

                                <!-- Manager With Multi Company -->
                                 @if(Auth::user()->position_id == env('MANAGER') AND Auth::user()->division->division == $headers->division->division AND Auth::user()->multi_company == 1)
                                    @if($headers->approval_manager == env('NOT_ACCEPTED') AND $headers->approval_general_manager == env('NOT_ACCEPTED') AND $headers->approval_supervisor == env('ACCEPTED'))
                                        <select name="approval_manager" id="" class="form-control form-control-sm w-60 mt-3">
                                            <option value="1">Terima</option>
                                            <option value="2">Tolak</option>
                                        </select>
                                    @elseif($headers->approval_manager == env('ACCEPTED'))
                                        <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                            Terima Kasih, Telah Menyetujui Permintaan {{@$headers->unique_request}}
                                        </p>
                                    @elseif($headers->approval_manager == env('CANCEL') AND $headers->status = env('UNCOMPLETED'))
                                        <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                            Hi {{Auth::user()->name}}, Telah Membatalkan Permintaan
                                        </p>
                                    @elseif($headers->approval_supervisor == env('NOT_ACCEPTED') AND $headers->approval_general_manager == env('NOT_ACCEPTED'))
                                        <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                            Hi {{Auth::user()->name}}, pemintaan masih proses pengecekan oleh IT
                                        </p>
                                    @endif
                                @endif
                                
                                @if(Auth::user()->position_id == env('GENERAL_MENAGER'))
                                    @if($headers->approval_manager == env('ACCEPTED') AND $headers->approval_general_manager == env('NOT_ACCEPTED') AND $headers->approval_supervisor == env('ACCEPTED'))
                                        <select name="approval_general_manager" id="" class="form-control form-control-sm w-60 mt-3">
                                            <option value="1">Terima</option>
                                            <option value="2">Tolak</option>
                                        </select>
                                    @elseif($headers->approval_general_manager == env('ACCEPTED'))
                                        <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                            Terima Kasih, Telah Menyetujui Permintaan {{@$headers->unique_request}}
                                        </p>
                                    @elseif($headers->approval_general_manager == env('CANCEL') AND $headers->status = env('UNCOMPLETED'))
                                        <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                            Hi {{Auth::user()->name}}, Telah Membatalkan Permintaan
                                        </p>
                                    @else 
                                         <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                            Menunggu Persetujuan Dari Manager & General Manager
                                        </p>
                                    @endif
                                @endif

                                @if(Auth::user()->position_id == env('STAFF') AND Auth::user()->division_id == $headers->division_id)
                                    @if(Auth::user()->division->division != env('DIVISION_IT'))
                                        @if($headers->status == env('DEFAULT'))
                                            <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                                Dalam Pengecekan Oleh Bagian Terkait
                                            </p>
                                        @elseif($headers->status == env('INPROGRESS'))
                                            <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                                Dalam Pengecekan Oleh Bagian Terkait
                                            </p>
                                        @elseif($headers->status == env('COMPLETED'))
                                            <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                                Permintaan Telah Diterima
                                            </p>
                                        @else
                                            <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                                Telah Dibatalkan
                                            </p>
                                        @endif
                                    @else
                                    @endif
                                @endif
                                </div>
                            </div>
                            @elseif(@$headers->status == env('UNCOMPLETED'))
                                <img src="https://cdni.iconscout.com/illustration/premium/thumb/website-warning-7328003-5988071.png" class="rounded" alt="" srcset="" style="width: 150px;">
                                <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 10px;">
                                    @if($headers->approval_manager == env('CANCEL'))
                                        <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 15px;">
                                            Manager Telah Membatalkan Permintaan
                                        </p>
                                    @elseif($headers->approval_general_manager == env('CANCEL'))
                                        <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 15px;">
                                            General Manager Telah Membatalkan Permintaan
                                        </p>
                                    @elseif($headers->approval_supervisor == env('CANCEL'))
                                        <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 15px;">
                                            Staff IT/Supervisor Telah Membatalkan Permintaan
                                        </p>
                                    @endif
                                </p>
                            @elseif(@$headers->status == env('COMPLETED'))
                                <img src="https://cdn3d.iconscout.com/3d/premium/thumb/accept-5064235-4223213.png" class="rounded" alt="" srcset="" style="width: 150px;">
                                <p style="font-family: var(--bs-font-roboto); font-size: 12px; margin-bottom: 2px; margin-top: 15px;" class="text-capitalize">
                                    Permintaan {{@$headers->unique_request}} telah diterima & dev IT akan menghubungi {{$headers->userRequest->name}}
                                </p>
                            @endif
                        </div>
                        </div>
                    </div>
                    @if(count($details) != 0)
                    <form action="{{route('store_request_hardware_software')}}" method="post">
                        @csrf
                        <table class="table table-responsive mt-5">
                            <table class="table table-borderless table-hover" id="myTable">
                                <thead>
                                    <tr class="text-sm text-center">
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Ketersediaan Inventori</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($details as $key => $detail)
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-sm text-capitalize"
                                                    value="{{$detail->items_id ?  $detail->inventorys->item_name : $detail->items_new_request}}"
                                                    disabled>
                                                <!-- <select name="itemName[]" id=""
                                                        class="itemName form-control  form-control-sm">
                                                        <option value="{{$detail->items_id ?  $detail->inventorys->item_name : $detail->items_new_request}}" selected>{{$detail->items_id ?  $detail->inventorys->item_name : $detail->items_new_request}}</option>
                                                        @foreach($inventorys as $inventory)
                                                        <option name="">{{$inventory->item_name}}</option>
                                                        @endforeach
                                                    </select> -->
                                                <!-- <select name="itemsId[]" id="itemsId"
                                                        class="itemsId form-select form-select-sm text-capitalize">
                                                    </select> -->
                                                <input type="hidden" name="itemName[]" value="{{$detail->items_id ?  $detail->inventorys->item_name : $detail->items_new_request}}">
                                                <input type="hidden" name="itemId[]" value="{{$detail->id}}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="" class="form-control form-control-sm"
                                                    value="{{@$detail->qty}}" disabled>
                                                <input type="hidden" name="qty[]" value="{{@$detail->qty}}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="" class="form-control form-control-sm"
                                                    value="{{@$detail->availability == 'EXISTS' ? 'Barang Tersedia' : 'Tidak Tersedia / Buat Pengajuan'}}"
                                                    disabled>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select name="transaction_status[]"  id=""
                                                    class="form-control form-control-sm" {{Auth::user()->level_id == env('NORMAL_ACCESS') ? 'disabled' : ''}}
                                                    @if($headers->approval_supervisor == '0' OR $headers->approval_manager == '0' OR $headers->approval_general_manager == '0') 
                                                        disabled
                                                    @endif
                                                    {{$detail->transaction_status == env('COMPLETED') ? 'readonly' : ''}}
                                                    {{$detail->transaction_status == env('UNCOMPLETED') ? 'readonly' : ''}}
                                                    >
                                                    <option value="1" @selected($detail->transaction_status == env('INPROGRESS'))>Dalam Pengecekan</option>
                                                    <option value="2" @selected($detail->transaction_status == env('COMPLETED'))>Tersedia</option>
                                                    <option value="3" @selected($detail->transaction_status == env('UNCOMPLETED'))>Tidak Tersedia</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" name="description[]"
                                                    class="form-control form-control-sm"
                                                    value="{{$detail->description}}" disabled>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <i class='remove-button fa-solid fa-circle-minus fa-lg'
                                                    style='color: #ec2727;'></i>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </table>
                        <div class="form-group mt-4"> 
                                @if($headers->status == env('DEFAULT') OR $headers->status == env('INPROGRESS'))
                                    @if(Auth::user()->division->division == env('DIVISION_IT') AND $headers->approval_general_manager == env('NOT_ACCEPTED') AND $headers->approval_manager == env('NOT_ACCEPTED') AND $headers->approval_supervisor == env('NOT_ACCEPTED'))
                                        <div class="text-center d-flex justify-content-end">
                                            <button type="button" class="btn bg-gradient-info w-15 mt-4 mb-0" data-bs-toggle="modal"
                                                data-bs-target="#update">simpan</button>
                                        </div>
                                    @elseif(Auth::user()->position_id == env('MANAGER') AND $headers->approval_manager == env('NOT_ACCEPTED') AND $headers->approval_supervisor == env('ACCEPTED') AND Auth::user()->division_id == $headers->division_id)
                                        <div class="text-center d-flex justify-content-end">
                                            <button type="button" class="btn bg-gradient-info w-15 mt-4 mb-0" data-bs-toggle="modal"
                                                data-bs-target="#update">simpan</button>
                                        </div>
                                    @elseif(Auth::user()->position_id == env('MANAGER') AND $headers->approval_manager == env('NOT_ACCEPTED') AND $headers->approval_supervisor == env('ACCEPTED') AND Auth::user()->division->division == $headers->division->division AND Auth::user()->multi_company == 1)
                                        <div class="text-center d-flex justify-content-end">
                                            <button type="button" class="btn bg-gradient-info w-15 mt-4 mb-0" data-bs-toggle="modal"
                                                data-bs-target="#update">simpan</button>
                                        </div>
                                    @elseif(Auth::user()->position_id == env('GENERAL_MENAGER') AND $headers->approval_general_manager == env('NOT_ACCEPTED') AND $headers->approval_manager == env('ACCEPTED'))
                                        <div class="text-center d-flex justify-content-end">
                                            <button type="button" class="btn bg-gradient-info w-15 mt-4 mb-0" data-bs-toggle="modal"
                                                data-bs-target="#update">simpan</button>
                                        </div>
                                    @elseif(Auth::user()->division->division == env('DIVISION_IT') AND $headers->approval_general_manager == env('ACCEPTED') AND $headers->approval_manager == env('ACCEPTED') AND $headers->approval_supervisor == env('ACCEPTED'))
                                        <div class="text-center d-flex justify-content-end">
                                            <button type="button" class="btn bg-gradient-info w-15 mt-4 mb-0" data-bs-toggle="modal"
                                                data-bs-target="#update">selesai</button>
                                        </div>
                                    @endif
                                    <!-- @if(Auth::user()->position_id == env('STAFF') AND Auth::user()->division_id == env('DIVISION_IT'))
                                        @if($headers->approval_supervisor == env('DEFAULT'))
                                            <div class="text-center d-flex justify-content-end">
                                                <button type="button" class="btn bg-gradient-info w-15 mt-4 mb-0" data-bs-toggle="modal"
                                                    data-bs-target="#update">simpan</button>
                                            </div>
                                        @elseif($headers->approval_supervisor == env('ACCEPTED') AND $headers->approval_manager == env('ACCEPTED') AND $headers->approval_general_manager == env('ACCEPTED'))
                                            <div class="text-center d-flex justify-content-end">
                                                <button type="button" class="btn bg-gradient-info w-15 mt-4 mb-0" data-bs-toggle="modal"
                                                    data-bs-target="#update">simpan</button>
                                            </div>
                                        @endif
                                    @elseif($headers->approval_manager == env('DEFAULT') AND Auth::user()->position_id == env('MANAGER') AND Auth::user()->division_id == $headers->division_id AND $headers->approval_supervisor == env('ACCEPTED'))
                                        <div class="text-center d-flex justify-content-end">
                                            <button type="button" class="btn bg-gradient-info w-15 mt-4 mb-0" data-bs-toggle="modal"
                                                data-bs-target="#update">simpan</button>
                                        </div>
                                    @elseif($headers->approval_general_manager == env('DEFAULT') AND Auth::user()->position_id == env('GENERAL_MENAGER') AND $headers->approval_manager == env('ACCEPTED'))
                                        <div class="text-center d-flex justify-content-end">
                                            <button type="button" class="btn bg-gradient-info w-15 mt-4 mb-0" data-bs-toggle="modal"
                                                data-bs-target="#update">simpan</button>
                                        </div>
                                    @endif -->
                                @endif
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="update" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-dark">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body mb-2">
                                        <div class="row">
                                            <div class="col-4">
                                                <i class="fa-solid fa-triangle-exclamation mt-2"
                                                    style="color: #ff0000; font-size: 100px; margin-left: 20px;"></i>
                                            </div>
                                            <div class="col-md-8 text-center">
                                                <h3>WARNING!!!</h3>
                                                <small>Pembaharuan data pada sistem akan mempengaruhi transaksi</small>
                                                <small></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btnsubmit btn-primary btn-sm">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="form-group m-3 pt-3">
                        <h6 style="font-family: var(--bs-font-roboto);">Detail Tidak Muncul</h6>
                        <p style="font-size: 12px;">Detail Permintaan Tidak Tersedia, Hubungi Devisi Teknologi Informasi
                            (IT) Apabila Mengalami Error Pada Sistem. </p>
                    </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).on('click', '.remove-button', function () {
        $(this).closest('tr').remove();
    });
    // $('.itemsId').select2({
    //     ajax: {
    //         url: '{{url("/request-hardware-software/searching-inventory")}}',
    //         dataType: 'json',
    //         processResults: function ({
    //             data
    //         }) {
    //             return {
    //                 results: $.map(data, function (item) {
    //                     return {
    //                         id: item.id,
    //                         text: item.item_name
    //                     }
    //                 })
    //             }
    //         }
    //     }
    // });

</script>
@endsection
