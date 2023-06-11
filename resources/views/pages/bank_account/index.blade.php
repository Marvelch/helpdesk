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
                                    style="background-color: transparent !important;" aria-labelledby="dropdownTable">
                                    <li class="shadow-sm mb-1 p-1 bg-white rounded"><a
                                            class="dropdown-item border-radius-md small"
                                            href="{{route('create_bank_accounts')}}"><i
                                                class="fa-light fa-caret-right fa-lg" style="margin-right: 10px;"></i>
                                            Tambah</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body m-1">
                    <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Email</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Username</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Kata sandi</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            URL
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Keterangan
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            IP
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Anydesk
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Dokumen
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                        <td class="align-middle text-sm">
                                            <span>{{@$item->email}}</span>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <span class="text-xs font-weight-bold">{{@$item->fullname}}</span>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <span class="text-xs font-weight-bold">{{$item->username}}</span>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <span class="text-xs font-weight-bold">{{$item->password}}</span>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <span class="text-xs font-weight-bold">{{$item->url}}</span>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <span class="text-xs font-weight-bold">{{$item->description}}</span>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <span class="text-xs font-weight-bold">{{$item->ip_address}}</span>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <span class="text-xs font-weight-bold">{{$item->anydesk}}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold"><a href="{{url($item->attachment)}}"><i class="fa-solid fa-file-arrow-down fa-xl text-primary"></i></a></span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <a href="{{url('/bank-accounts/'.@$item->user->id.'/edit')}}"
                                                class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                data-original-title="Edit user">
                                                Edit
                                            </a>
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
@endsection
