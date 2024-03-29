@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="my-auto text-end">
                            <div class="dropdown float-lg-end pe-4">
                                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v text-secondary"></i>
                                </a>
                                <ul class="ticket__tables dropdown-menu px-2 py-3 ms-sm-n4 ms-n5"
                                    aria-labelledby="dropdownTable" style="font-family: var(--bs-font-roboto);">
                                    <!-- <li><a class="dropdown-item border-radius-md small"
                                            href="{{route('create_request_hardware_software')}}"><i
                                                class="fa-thin fa-microchip" style="margin-right: 10px;" ></i>
                                            Buat Permintaan</a></li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-responsive-sm">
                        <table id="myTable" data-page-length='10' class="display table-striped table-hover">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ID</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No Transaksi</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Permintaan</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Dibuat</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Keterangan</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Tanggal
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Bantuan
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requestHardwareSoftware as $item)
                                <tr>
                                    <td class="align-middle text-sm text-center">
                                        <span class="text-xs">{{@$item->id}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs">{{@$item->unique_request}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span
                                            class="text-xs">{{@Str::ucfirst($item->userRequest->name ? $item->userRequest->name : $item->requests_by_user)}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span
                                            class="text-xs">{{@Str::ucfirst($item->users->name ? $item->users->name : $item->created_by_user)}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs">{{@$item->description}}</span>
                                    </td>
                                    <td class="align-middle text-sm text-center">
                                        <span class="text-xs">
                                            @if($item->status == env('DEFAULT'))
                                            <span class="badge badge-sm bg-gradient-danger">Pengecekan</span>
                                            <!-- <i class="fa-solid fa-seal-exclamation fa-xl" style="color: #E74C3C;" title="MENUNGGU PENGECEKAN"></i> -->
                                            @elseif($item->status == 1)
                                            <span class="badge badge-sm bg-gradient-primary">Diproses</span>
                                            <!-- <i class="fa-duotone fa-clock fa-lg" style="--fa-secondary-color: #2ECC71;"
                                                title="DALAM PROSES"></i> -->
                                            @elseif($item->status == 2)
                                            <span class="badge badge-sm bg-gradient-success">Diterima</span>
                                            @elseif($item->status == 3)
                                            <span class="badge badge-sm bg-gradient-warning">Ditolak</span>
                                            @else
                                            <span class="badge badge-sm bg-gradient-info">Setengah</span>
                                            @endif
                                        </span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span
                                            class="text-xs">{{@date('d-m-Y',strtotime($item->transaction_date))}}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm d-flex justify-content-center">
                                        <div class="row">
                                            <div class="col-md-4">
                                            @if(Auth::user()->level_id != env('LEVEL_ADMIN') AND Auth::user()->level_id != env('LEVEL_EDITOR'))
                                                @if(Auth::user()->position_id == env('MANAGER') AND Auth::user()->division->division == $item->division OR Auth::user()->position_id == env('GENERAL_MENAGER'))
                                                <a href="{{route('edit_request_hardware_software',['id' => Crypt::encryptString($item->unique_request)])}}"
                                                    class="text-secondary font-weight-bold text-xs"
                                                    data-toggle="tooltip" data-original-title="Edit user">
                                                    <i class="fa-duotone fa-pen-to-square"></i>
                                                </a>
                                                @endif
                                            @else
                                            <a href="{{route('edit_request_hardware_software',['id' => Crypt::encryptString($item->unique_request)])}}"
                                                class="text-secondary font-weight-bold text-xs"
                                                data-toggle="tooltip" data-original-title="Edit user">
                                                <i class="fa-duotone fa-pen-to-square"></i>
                                            </a>
                                            @endif
                                            </div>
                                             <div class="col-md-4">
                                                <a href="{{route('show_request_hardware_software',['id' => Crypt::encryptString($item->unique_request)])}}"
                                                class="text-secondary font-weight-bold text-xs ml-1 mr-1"
                                                data-toggle="tooltip" data-original-title="Edit user">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                             </div>
                                            <div class="col-md-4">
                                                @if(Auth::user()->level_id != env('LEVEL_ADMIN') AND
                                                Auth::user()->level_id != env('LEVEL_EDITOR'))
                                                @if($item->requests_from_users == Auth::user()->id)
                                                <a class="text-secondary font-weight-bold text-xs"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{$item->id}}">
                                                    <i class="fa-duotone fa-trash"></i>
                                                </a>
                                                @endif
                                                <!-- Modal -->
                                                <div class="modal fade" id="deleteModal{{$item->id}}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-dark">
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body mb-2">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <i class="fa-solid fa-triangle-exclamation mt-2"
                                                                            style="color: #ff0000; font-size: 100px;"></i>
                                                                    </div>
                                                                    <div class="col-md-8 text-center">
                                                                        <h3>WARNING!!!</h3>
                                                                        @if($item->approval_supervisor != 0)
                                                                        <small>Permintaan tidak bisa dihapus, karena
                                                                            telah
                                                                            diterima oleh IT Staff</small>
                                                                        @else
                                                                        <small>Penghapusan permintaan pengguna secara
                                                                            permanen</small>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary btn-sm"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <form
                                                                    action="{{route('destroy_request_hardware_software',['id' => $item->id])}}"
                                                                    method="post">
                                                                    @csrf
                                                                    @if($item->approval_supervisor == 0)
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-sm">Hapus</button>
                                                                    @endif
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                <a class="text-secondary font-weight-bold text-xs"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{$item->id}}">
                                                    <i class="fa-duotone fa-trash"></i>
                                                </a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="deleteModal{{$item->id}}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-dark">
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body mb-2">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <i class="fa-solid fa-triangle-exclamation mt-2"
                                                                            style="color: #ff0000; font-size: 100px;"></i>
                                                                    </div>
                                                                    <div class="col-md-8 text-center">
                                                                        <h3>WARNING!!!</h3>
                                                                        @if($item->approval_supervisor != 0)
                                                                        <small>Permintaan tidak bisa dihapus, karena
                                                                            telah
                                                                            diterima oleh IT Staff</small>
                                                                        @else
                                                                        <small>Penghapusan permintaan pengguna secara
                                                                            permanen</small>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <!-- <i class="fa-sharp fa-solid fa-brake-warning text-danger fa-lg"
                                                            style="margin-right: 10px;"></i> konfirmasi Penghapusan Data
                                                        <b>{{@$item->fullname}} - {{$item->username}}</b> -->
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary btn-sm"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <form
                                                                    action="{{route('destroy_bank_accounts',['id' => $item->id])}}"
                                                                    method="post">
                                                                    @csrf
                                                                    @if($item->approval_supervisor == 0)
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-sm">Hapus</button>
                                                                    @endif
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            select: true,
            // info: false,
            // lengthChange: false,
            "oLanguage": {
                "sSearch": " "
            },
            "order": [
                [0, 'desc']
            ],
        });
    });

</script>
@endsection
