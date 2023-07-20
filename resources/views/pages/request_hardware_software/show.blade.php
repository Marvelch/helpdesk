@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow-sm p-3 bg-body rounded">
                                <div class="card-body" style="font-size: 12px;">
                                    <div class="table-responsive">
                                        <table class="table-borderless table-sm">
                                            <tbody>
                                                <tr>
                                                    <td class="w-55">Kode Permintaan</td>
                                                    <td>: {{$headers->unique_request}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Permintaan</td>
                                                    <td class="text-capitalize">: {{$headers->userRequest->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Pembuatan</td>
                                                    <td>: {{date('d-m-Y',strtotime($headers->created_at))}}</td>
                                                </tr>
                                                 <tr>
                                                    <td>Status Permintaan</td>
                                                    <td>: 
                                                        @if($headers->status == 1)
                                                            Proses Pengecekan
                                                        @elseif($headers->status == 2)
                                                            Diterima
                                                        @else
                                                            Batal
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                                <div class="table-responsive">
                                    <table class="table table-striped small">
                                        <thead>
                                            <tr class="small text-ce">
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            @foreach($details as $detail) 
                                            <tr class="small">
                                                <td class="text-capitalize">{{$detail->items_id ? $detail->inventorys->item_name : $detail->items_new_request}}</td>
                                                <td>{{$detail->qty}}</td>
                                                <td>
                                                    @if($detail->transaction_status == 1) 
                                                    Dalam Pengecekan 
                                                    @elseif($detail->transaction_status == 2) 
                                                    Tersedia
                                                    @else
                                                    Tidak Tersedia
                                                    @endif
                                                </td>
                                                <td>{{$detail->description}}</td>
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
    @endsection
