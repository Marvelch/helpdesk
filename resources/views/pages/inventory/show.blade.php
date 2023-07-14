@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
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
                        <div class="col-md-8 m-2" style="font-size: 12px;">
                            <div class="card-body shadow">
                                <table class="table table-borderless text-small text-capitalize">
                                    <tr>
                                        <td style="width: 20%;">Nama Barang</td>
                                        <td>: {{@$inventorys->item_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Kode</td>
                                        <td>: {{@$inventorys->inventory_unique}}</td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td>: {{@$inventorys->description}}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Stok</td>
                                        <td>: {{$inventorys->stock}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-group mt-5">
                            <div class="table-responsive table-responsive-sm">
                                <table id="myTable" data-page-length='10'
                                    class="display table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <!-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Barang</th> -->
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stok Masuk</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stok Keluar</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Adjustment</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Keterangan</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dibuat Oleh</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($details as $detail)
                                        <tr>
                                            <!-- <td class="align-middle small"><span class="text-xs font-weight-bold text-capitalize">{{$detail->inventory_unique}}</span></td> -->
                                            <td class="align-middle small"><span class="text-xs font-weight-bold text-capitalize">{{$detail->stock_in}}</span></td>
                                            <td class="align-middle small"><span class="text-xs font-weight-bold text-capitalize">{{$detail->stock_out}}</span></td>
                                            <td class="align-middle small"><span class="text-xs font-weight-bold text-capitalize">{{$detail->adjustment}}</span></td>
                                            <td class="align-middle small"><span class="text-xs font-weight-bold text-capitalize">{{$detail->description}}</span></td>
                                            <td class="align-middle small"><span class="text-xs font-weight-bold text-capitalize">{{$detail->users->name}}</span></td>
                                            <td class="align-middle small"><span class="text-xs font-weight-bold text-capitalize">{{$detail->created_at}}</span></td>
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
            select: false,
            info: false,
            lengthChange: false,
            searching: false,
            // "oLanguage": {
            //     "sSearch": " "
            // },
            order: [[4, 'desc']]
        });
    });

</script>
@endsection
