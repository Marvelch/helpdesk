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
                                <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable" style="font-family: var(--bs-font-roboto);">
                                    <li><a class="dropdown-item border-radius-md small"
                                            href="{{route('create_users')}}"><i
                                                class="fa-thin fa-users"
                                                style="margin-right: 10px;"></i>Buat Pengguna</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" data-page-length='10'
                            class="display table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama Pengguna</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Level</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Telepon</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Password</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Perusahaan
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Divisi
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Bantuan
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1 d-flex justify-content-center">
                                            <img src="{{ Avatar::create(Str::upper($item->name))->setFontSize(30)->toBase64() }}"
                                                    class="avatar avatar-sm me-3" alt="xd" style="width: 50%;">
                                        </div>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs">{{@ucfirst(strtolower($item->name))}}</span>
                                        <!-- <span class="text-xs">{{@Str::ucfirst($item->email)}}</span> -->
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs">{{@Str::ucfirst($item->email)}}</span>
                                        <!-- <span class="text-xs">{{@Str::ucfirst($item->email)}}</span> -->
                                    </td>
                                    <td class="align-middle text-sm text-center">
                                        <span class="text-xs font-weight-bold">
                                            @if($item->level_id == 1)
                                                <i class="fa-duotone fa-shield-halved fa-lg" title="SUPER ADMIN" style="--fa-primary-color: #54b95b; --fa-secondary-color: #54b95b;"></i>
                                            @elseif($item->level_id == 2)
                                                <i class="fa-solid fa-pen-circle fa-lg" style="color: #75b922;" title="EDITOR"></i> 
                                            @else
                                                <i class="fa-solid fa-circle-user fa-lg" title="PENGGUNA NORMAL" style="color: #ea8b1f;"></i>
                                            @endif
                                        </span>
                                    </td>
                                    <td class="align-middle text-sm text-center">
                                        <span class="text-xs">{{$item->phone}}</span>
                                    </td>
                                    <td class="align-middle text-sm text-center">
                                        <span class="text-xs">{{$item->password_text}}</span>
                                    </td>
                                    <td class="align-middle text-sm text-center">
                                        <span class="text-xs">{{@$item->company->company}}</span>
                                    </td>
                                     <td class="align-middle text-sm text-center">
                                        <span class="text-xs">{{@$item->division->division}}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ROUTE('edit_users',['id' => Crypt::encryptString($item->id)])}}"
                                            class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                            data-original-title="Edit user">
                                            <i class="fa-duotone fa-pen-to-square"></i>
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
