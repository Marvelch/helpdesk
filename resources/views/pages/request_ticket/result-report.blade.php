@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card shadow">
                        <div class="card-body">
                            <form action="{{route('result_report_request_ticket')}}" method="post">
                                @csrf
                                <div class="d-flex bd-highlight d-grid gap-3">
                                    <div class="form-group">
                                        <label for="">Dari Tanggal</label>
                                        <input name="start_date" type="date" class="form-control form-control-sm"
                                            value="{{date('Y-m-d',strtotime($start_date))}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Hingga Tanggal</label>
                                        <input name="end_date" type="date" class="form-control form-control-sm"
                                            value="{{date('Y-m-d',strtotime($end_date))}}">
                                    </div>
                                    <div class="ms-auto">
                                        <div class="form-group">
                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-primary btn-sm"><span
                                                        style="margin-left: 4px;">Cari</span></button>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card shadow mt-3">
                        <div class="card-body">
                            <div class="p-2">
                                <!-- <p class="text-muted mt-1" style="font-size: 12px; margin-left: 10px;">Laporan yang
                                    ditampilkan sesuai dengan tanggal mulai dan tanggal berakhir, pastikan telah memilih
                                    tanggalh sesui dengan ketentuan.</p> -->
                                <div class="m-2">
                                    <a class="btn btn-info btn-sm" href="{{route('export_report_request_ticket',['start_date'=>Crypt::encryptString($start_date),'end_date'=>Crypt::encryptString($end_date)])}}">Export</a>
                                </div>
                                <table id="myTable" data-order='[[ 1, "asc" ]]' data-page-length='10'
                                    class="table table-striped align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs er opacity-7">
                                                ID Tiket</th>
                                            <th class="text-uppercase text-secondary text-xxs er opacity-7">
                                                Tanggal</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs er opacity-7">
                                                Masalah</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs er opacity-7">
                                                Keterangan</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs er opacity-7">
                                                PIC
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs er opacity-7">
                                                Status
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs er opacity-7">
                                                Tipe
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($requestTickets as $item)
                                        <tr>
                                            <td class="align-middle text-sm">
                                                <span class="text-xs ">{{@$item->id}}</span>
                                            </td>
                                            <td class="align-middle text-sm">
                                                <span class="text-xs ">{{@date('d-m-Y',strtotime($item->created_at))}}</span>
                                            </td>
                                            <td class="align-middle text-sm">
                                                <span class="text-xs ">{{@$item->title}}</span>
                                            </td>
                                            <td class="align-middle text-sm">
                                                <span class="text-xs ">{{@$item->description}}</span>
                                            </td>
                                            <td class="align-middle text-sm">
                                                <span class="text-xs text-capitalize">{{@$item->usersAss->name}}</span>
                                            </td>
                                            <td class="align-middle text-sm text-center">
                                                <span class="text-xs ">
                                                    @if($item->status == 0)
                                                    <span class="badge badge-sm bg-gradient-danger">Menunggu</span>
                                                    @elseif($item->status == 1)
                                                    <span class="badge badge-sm bg-gradient-primary">Diproses</span>
                                                    @elseif($item->status == 2)
                                                    <span class="badge badge-sm bg-gradient-success">Selesai</span>
                                                    @elseif($item->status == 3)
                                                    <span class="badge badge-sm bg-gradient-info">Ditolak</span>
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="align-middle text-sm">
                                                <span class="text-xs text-capitalize">{{@$item->work_type->type}}</span>
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
</div>
</div>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            select: true,
            "searching": false,
            info: false,
            lengthChange: false,
        });
    });

</script>
@endsection
