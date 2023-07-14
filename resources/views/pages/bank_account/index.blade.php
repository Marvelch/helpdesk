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
                                <ul class="ticket__tables dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable" style="font-family: var(--bs-font-roboto);">
                                    <li><a
                                            class="dropdown-item border-radius-md small"
                                            href="{{route('create_bank_accounts')}}"><i
                                                class="fa-thin fa-users" style="margin-right: 10px;"></i>
                                            Pengguna Baru</a></li>
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
                                        Nama</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        username
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kata sandi</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        URL
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Dokumen
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bankAccounts as $item)
                                <tr>
                                    <td class="align-middle small">
                                        <span class="text-xs font-weight-bold text-capitalize">{{@$item->fullname}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs font-weight-bold text-capitalize">{{$item->username}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs font-weight-bold">{{$item->password}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs font-weight-bold">{{Str::ucfirst($item->email)}}</span>
                                    </td>
                                    <td class="align-middle text-sm">
                                        <span class="text-xs font-weight-bold">{{$item->url}}</span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if(!is_null($item->attachment))
                                        <a href="{{route('download_bank_accounts',['id' => Crypt::encryptString($item->attachment)])}}"
                                            class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                            data-original-title="Edit user">
                                            <i class="fa-solid fa-square-down"></i>
                                        </a>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <a href="{{route('edit_bank_accounts',['id' => Crypt::encryptString($item->id)])}}"
                                            class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                            data-original-title="Edit user">
                                            <i class="fa-duotone fa-pen-to-square"></i>
                                        </a>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <a href="{{route('show_bank_accounts',['id' => Crypt::encryptString($item->id)])}}"
                                            class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                            data-original-title="Edit user">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <a class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{$item->id}}">
                                            <i class="fa-duotone fa-trash"></i>
                                        </a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal{{$item->id}}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-dark">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body mb-2">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <i class="fa-solid fa-triangle-exclamation mt-2" style="color: #ff0000; font-size: 100px;"></i>
                                                            </div>
                                                            <div class="col-md-8 text-center">
                                                                <h3>WARNING!!!</h3>
                                                                <small>Penghapusan akun pengguna secara permanen</small>
                                                                <small>{{@$item->fullname}} - {{@$item->email}}</small>
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
                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
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
        });
    });

</script>
@endsection
