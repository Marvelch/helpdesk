@extends('layouts.app')

@section('contents')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            @if ($alert = Session::get('success'))
            <div class="alert alert-success" role="alert" style="font-size: 12px; color: white;">
                <i class="fa-solid fa-bell" style="padding-right: 15px;"></i>{{$alert}}
            </div>
            @endif
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
                                    style="background-color: transparent !important;" aria-labelledby="dropdownTable">
                                    <li class="shadow-sm mb-1 p-1 bg-white rounded"><a
                                            class="dropdown-item border-radius-md small"
                                            href="{{route('create_request_ticket')}}"><i
                                                class="fa-light fa-caret-right fa-lg" style="margin-right: 10px;"></i>
                                            Tambah</a></li>
                                    <li class="shadow-sm mb-1 p-1 bg-white rounded"><a
                                            class="dropdown-item border-radius-md small"
                                            href="{{route('create_request_ticket')}}"><i
                                                class="fa-light fa-caret-right fa-lg" style="margin-right: 10px;"></i>
                                            Ticket Approve </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body m-1">
                    <div class="table-responsive">
                        <table class="table table-striped align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Permintaan Dari</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Ditugaskan</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Masalah</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Perusahaan</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Divisi
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Batas Waktu
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Approvement
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th>
                                        <!-- Kosong -->
                                    </th>
                                </tr>
                            </thead>
                            @foreach($requestTickets as $item)
                            <tbody>
                                <td class="align-middle text-sm">
                                    <span class="text-xs font-weight-bold">{{$item->usersReq->name}}</span>
                                </td>
                                <td class="align-middle text-sm">
                                    <span class="text-xs font-weight-bold">{{@$item->usersAss->name}}</span>
                                </td>
                                <td class="align-middle text-sm">
                                    <span class="text-xs font-weight-bold">{{@$item->title}}</span>
                                </td>
                                <td class="align-middle text-sm">
                                    <span class="text-xs font-weight-bold">{{@$item->company->company}}</span>
                                </td>
                                <td class="align-middle text-sm">
                                    <span class="text-xs font-weight-bold">{{@$item->division->division}}</span>
                                </td>
                                <td class="align-middle text-sm">
                                    <span
                                        class="text-xs font-weight-bold">{{@date('d-m-Y', strtotime($item->deadline))}}</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-xs font-weight-bold">
                                        @if($item->approvement === 0)
                                        <i class="fa-solid fa-file-circle-xmark fa-lg" title="Ditolak"></i>
                                        @elseif($item->approvement == 1)
                                        <i class="fa-duotone fa-file-circle-check fa-lg"
                                            style="--fa-secondary-color: #1b3d98;" title="Diterima"></i>
                                        @else
                                        <i class="fa-duotone fa-file-circle-info fa-lg"
                                            style="--fa-secondary-color: #54b95b;" title="Tidak ada"></i>
                                        @endif
                                    </span>
                                </td>
                                <td class="align-middle text-sm">

                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-xs font-weight-bold"><a
                                            href="{{route('show_request_ticket',['id' => Crypt::encryptString($item->id)])}}"><i
                                                class="fa-solid fa-up-right-from-square"></i></a></span>
                                </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
