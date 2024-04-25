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
                                    <li><a class="dropdown-item border-radius-md small"
                                            href="{{route('create_inventory')}}"><i class="fa-light fa-boxes-stacked"
                                                style="margin-right: 10px;"></i>
                                            Tambah Master</a></li>
                                    <li><a class="dropdown-item border-radius-md small"
                                            href="{{route('create_transaction_inventory')}}"><i
                                                class="fa-light fa-bag-shopping" style="margin-right: 13px;"></i>
                                            Pengelolaan Stok</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-responsive-sm">
                        <table id="myTable" data-order='[[ 1, "asc" ]]' data-page-length='10'
                            class="display table-striped table-hover">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kode</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama Tamu</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Perusahaan</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Total Tamu
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Tanggal
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jam</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Karyawan</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($results as $key => $result)
                                <tr>
                                    <td class="align-middle small">
                                        <span class="text-xs font-weight-bold">{{@Str::upper($result->unique)}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs font-weight-bold">{{@$result->full_name}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs font-weight-bold">{{ucfirst(@$result->company)}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs font-weight-bold">{{@$result->total_visitor}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs font-weight-bold">{{@$result->visit_date}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span
                                            class="text-xs font-weight-bold">{{@$result->expected_arrival_time}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span
                                            class="text-xs font-weight-bold">{{ucfirst(strtolower(@$result->employee_name))}}</span>
                                    </td>
                                    <td class="align-middle text-sm text-center">
                                        <div class="row">
                                            <div class="d-flex justify-content-center">
                                                <div class="col-2 m-1">
                                                    <span class="text-xs font-weight-bold" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModa{{$key}}"><i
                                                    class="fa-solid fa-lg fa-comments"></i></span>
                                                </div>
                                                @if($subBagian == 'SECURITY')
                                                <div class="col-2 m-1">
                                                    <i class="fa-duotone fa-lg fa-pen-field" data-bs-toggle="modal" data-bs-target="#{{$result->unique}}"></i>
                                                </div>
                                                @endif
                                                <div class="col-2 m-1">
                                                    <a href="{{route('reservation_print',['id'=>$result->unique])}}" target="_blank" rel="noopener noreferrer"><i class="fa-duotone fa-lg fa-print" title="Print Document"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal -->
                                <div class="modal fade" id="{{$result->unique}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{$result->unique}}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{route('reservation_settime',['id'=>$result->unique])}}" method="post">
                                        @csrf
                                    <div class="modal-body">
                                        @if($result->date != null && $result->in != null && $result->out != null)
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-center">
                                                    <img src="https://img.freepik.com/premium-vector/documents-icon-paper-sheets-approved-document-3d-paper-corporate-business-icon_22052-4099.jpg" alt="" srcset="" class="w-50">
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    <p class="text-sm fw-bold mt-2">Reservasi Telah Selesai</p>
                                                </div>
                                            </div>
                                        @else
                                            @if($result->signature_employee == null)
                                                <div class="row d-flex justify-content-center text-center">
                                                    <div class="col-md-12">
                                                        <img src="https://static.vecteezy.com/system/resources/previews/016/716/169/original/notification-alert-3d-icon-png.png" alt="" srcset="" class="w-50">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p class="text-sm fw-bold mt-2">Karyawan belum menyetujui permintaan</p>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="col-md-12 d-flex justify-content-center">
                                                        <img src="https://static.vecteezy.com/system/resources/previews/021/972/674/original/approve-3d-render-icon-illustration-with-transparent-background-protection-and-security-png.png" alt="" srcset="" class="w-50">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p class="text-sm fw-bold mt-4 text-capitalize">Lakukan pemerisaan kedatangan tamu :</p>
                                                        @if($result->in == null)
                                                        <select name="in" id="" class="form-control">
                                                            <option value="1">Check In</option>
                                                        </select>
                                                        @else
                                                        <select name="out" id="" class="form-control">
                                                            <option value="2">Check Out</option>
                                                        </select>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        @if($result->signature_employee)
                                            @if($result->date == null || $result->in == null || $result->out == null)
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            @endif
                                        @endif
                                    </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModa{{$key}}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                               <div class="row">
                                                <div class="col-md-6 text-center">
                                                    <p class="text-sm">TTD Pengunjung</p>
                                                    <img src="{{ asset('storage/' . $result->signature_visitor) }}" alt="Visitor Signature" class="w-100">
                                                </div>
                                                <div class="col-md-6 text-center">
                                                    @if($result->signature_employee != null)
                                                    <p class="text-sm">TTD Karyawan</p>
                                                    <img src="{{ asset('storage/' . $result->signature_employee) }}" alt="Visitor Signature" class="w-100">
                                                    @else
                                                    <a href="{{route('reservation_edit',['id'=>$result->unique])}}" class="btn btn-primary mt-4">Tanda Tangan</a>
                                                    @endif
                                                </div>
                                               </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        });
    });

</script>
@endsection
