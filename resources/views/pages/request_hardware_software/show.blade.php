@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow">
                                <div class="card-body" style="font-size: 12px;">
                                    <div class="table-responsive">
                                        <table class="table-borderless table-sm">
                                            <tbody>
                                                <tr>
                                                    <td class="w-70">Kode Permintaan</td>
                                                    <td>: {{$headers->unique_request}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Permintaan</td>
                                                    <td>: {{$headers->userRequest->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Pembuatan</td>
                                                    <td>: {{date('d-m-Y',strtotime($headers->created_at))}}</td>
                                                </tr>
                                                 <tr>
                                                    <td>Status Permintaan</td>
                                                    <td>: 
                                                        @if($headers->status == 1)
                                                            PROSES PENGERJAAN
                                                        @elseif($headers->status == 2)
                                                            DITERIMA
                                                        @else
                                                            PEMBATALAN
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
                            @foreach($details as $detail) 
                                <div class="table-responsive">
                                    <table class="table table-stiped small">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead> 
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
